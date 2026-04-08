<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;

class CustomerAuthController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendForgotOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Email not found in our records', 
            ], 422);
        }

        $otp = 123456; // In production this should be rand(100000, 999999)

        // Store in session
        session([
            'forgot_email' => $request->email,
            'forgot_otp' => $otp,
            'forgot_otp_expires_at' => now()->addMinutes(10)
        ]);

        try {
            Mail::raw("Your password reset OTP is: $otp", function($message) use ($request) {
                $message->to($request->email)->subject('Password Reset OTP');
            });
        } catch (\Exception $e) {
            // Log error or ignore if development
        }

        return response()->json(['status' => 'otp_sent']);
    }

    public function verifyForgotOTP(Request $request)
    {
        $expiry = session('forgot_otp_expires_at');

        if (!$expiry || now()->greaterThan($expiry)) {
            session()->forget(['forgot_otp', 'forgot_email', 'forgot_otp_expires_at']);
            return response()->json(['status' => 'error', 'message' => 'OTP expired.']);
        }

        if (session('forgot_otp') != $request->otp) {
            return response()->json(['status' => 'error', 'message' => 'Invalid OTP']);
        }

        return response()->json(['status' => 'otp_verified']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $email = session('forgot_email');
        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Session expired. Please start again.'], 422);
        }

        $customer = Customer::where('email', $email)->first();
        if (!$customer) {
            return response()->json(['status' => 'error', 'message' => 'Customer not found.'], 404);
        }

        $customer->update([
            'password' => Hash::make($request->password)
        ]);

        session()->forget(['forgot_otp', 'forgot_email', 'forgot_otp_expires_at']);

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successfully! You can now login.',
            'redirect' => route('login')
        ]);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }

        if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            $customer = Auth::guard('customer')->user();
            $customer->update([
                'last_login_at' => now()
            ]);

            return response()->json([
                'status' => 'success', 
                'message' => 'Login successful! Redirecting...',
                'redirect' => route('home')
            ]);
        }

        return response()->json([
            'status' => 'error', 
            'message' => 'Invalid email or password'
        ], 401);
    }


    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }


        //$otp = rand(100000, 999999);

        $otp = 123456;

        // Store in session
        session([
            'register_data' => $request->only('name', 'email', 'password', 'phone'),
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);


        try {
            Mail::raw("Your verification OTP is: $otp", function($message) use ($request) {
                $message->to($request->email)->subject('Email Verification OTP');
            });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to send email.']);
        }

        return response()->json(['status' => 'otp_sent']);
    }

    public function verifyOTP(Request $request)
    {
        $expiry = session('otp_expires_at');

        if (!$expiry || now()->greaterThan($expiry)) {
            session()->forget(['otp', 'register_data', 'otp_expires_at']);
            return response()->json(['status' => 'error', 'message' => 'OTP expired. Please register again.']);
        }

        if (session('otp') != $request->otp) {
            return response()->json(['status' => 'error', 'message' => 'Invalid OTP']);
        }

        $data = session('register_data');

        $customer = Customer::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null, // Added phone if available
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(), // Mark as verified
            'last_login_at' => now() // Tracking last login
        ]);

        Auth::guard('customer')->login($customer);
        session()->forget(['otp', 'register_data', 'otp_expires_at']);

        return response()->json([
            'status' => 'registered',
            'message' => 'Your account has been created and verified!',
            'redirect' => route('home')
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GOOGLE LOGIN
    |--------------------------------------------------------------------------
    */

    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google authentication failed.');
        }

        $customer = Customer::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'email_verified_at' => now(),
                'last_login_at' => now()
            ]
        );

        Auth::guard('customer')->login($customer);

        return redirect('/');
    }



    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {

        Auth::guard('customer')->logout();

        return redirect('/');

    }

}
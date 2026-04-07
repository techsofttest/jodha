<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class CustomerAuthController extends Controller
{
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
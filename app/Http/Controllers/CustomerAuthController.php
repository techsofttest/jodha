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
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Email and Password are required']);
        }

        if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid login credentials']);
    }

    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $otp = rand(100000, 999999);

        // Store in session
        session([
            'register_data' => $request->only('name', 'email', 'password'),
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
            'password' => Hash::make($data['password'])
        ]);

        Auth::guard('customer')->login($customer);
        session()->forget(['otp', 'register_data', 'otp_expires_at']);

        return response()->json(['status' => 'registered']);
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

        $googleUser = Socialite::driver('google')->user();

        $customer = Customer::updateOrCreate(

            ['email'=>$googleUser->email],

            [
                'name'=>$googleUser->name,
                'google_id'=>$googleUser->id
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
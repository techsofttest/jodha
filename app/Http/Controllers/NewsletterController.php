<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please provide a valid email address.'
            ]);
        }

        $email = $request->email;

        // Check if already subscribed
        $exists = Newsletter::where('email', $email)->exists();
        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This email is already subscribed to our newsletter.'
            ]);
        }

        // Subscribe
        Newsletter::create([
            'email' => $email
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for subscribing to our newsletter!'
        ]);
    }
}

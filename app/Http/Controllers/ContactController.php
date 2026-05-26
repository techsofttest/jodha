<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $data = [];
        $data['seo'] = Seo::find(1); // Consistent with other pages
        
        return view('pages.contact', $data);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:2000',
            'subject' => 'nullable|string|max:255'
        ]);

        $data = $validated;

        try {
            Mail::send('emails.contact-form', ['data' => $data], function($m) use ($data) {
                $to = config('mail.from.address', 'no-reply@' . request()->getHost());
                $m->to($to)->subject('New contact form submission');
            });
        } catch (\Exception $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your message has been sent. We will contact you shortly.');
    }
}

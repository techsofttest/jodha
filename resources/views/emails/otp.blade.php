@extends('emails.layouts.master')

@section('title', $subject ?? ('Notification - ' . config('app.name')))
@section('header_title', $subject ?? 'Notification')

@section('content')
    <h2>Hello {{ $name ?? 'User' }},</h2>

    <p>{{ $message_intro ?? 'Here is your one-time password (OTP) for verification.' }}</p>

    <div style="text-align:center; margin: 20px 0;">
        <span class="button" style="font-size: 20px; padding: 12px 20px;">{{ $otp }}</span>
    </div>

    <p>This OTP will expire in {{ $expires ?? '10 minutes' }}.</p>

    <p>If you did not request this, please ignore this email.</p>

@endsection

@extends('emails.layouts.master')

@section('title', 'Welcome to ' . config('app.name'))
@section('header_title', 'Welcome')

@section('content')
    <h2>Hello {{ $user->name }},</h2>

    <p>Thank you for registering with {{ config('app.name') }}. Your account has been created successfully.</p>

    <p>You can now log in and start shopping.</p>

    <p>
        <a href="{{ url('/') }}" class="button">Visit Store</a>
    </p>

@endsection

@extends('emails.layouts.master')

@section('title', 'New Contact Message - ' . config('app.name'))
@section('header_title', 'Contact Form')

@section('content')
	<h2>New Contact Form Submission</h2>

	<div class="info-box">
		<div class="info-row"><span class="info-label">Name:</span> {{ $data['name'] }}</div>
		<div class="info-row"><span class="info-label">Email:</span> {{ $data['email'] }}</div>
		<div class="info-row"><span class="info-label">Phone:</span> {{ $data['phone'] ?? 'N/A' }}</div>
		<div class="info-row"><span class="info-label">Subject:</span> {{ $data['subject'] ?? 'General' }}</div>
	</div>

	<p><strong>Message:</strong></p>
	<p>{{ $data['message'] }}</p>

@endsection

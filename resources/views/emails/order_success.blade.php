@extends('emails.layouts.master')

@section('title', 'Order Confirmation - ' . config('app.name'))
@section('header_title', 'Order Confirmed')

@section('content')
    <h2>Thank you, {{ $order->first_name }}!</h2>

    <p>Your order <strong>{{ $order->order_number }}</strong> has been received and payment confirmed.</p>

    <div class="info-box">
        <div class="info-row"><span class="info-label">Order Number:</span> {{ $order->order_number }}</div>
        <div class="info-row"><span class="info-label">Total:</span> {{ number_format($order->grand_total, 2) }}</div>
        <div class="info-row"><span class="info-label">Payment Status:</span> {{ $order->payment_status }}</div>
    </div>

    <h4>Items</h4>
    <ul>
        @foreach($items as $item)
            <li>{{ $item->product_name }} x {{ $item->quantity }} — ₹{{ number_format($item->price * $item->quantity, 2) }}</li>
        @endforeach
    </ul>

    <p style="margin-top: 20px;">We will notify you when your order is shipped.</p>

    <p>
        <a href="{{ url('/') }}" class="button">View Order</a>
    </p>

@endsection

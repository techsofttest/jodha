@extends('emails.layouts.master')

@section('title', 'Order Confirmation - ' . config('app.name'))

@section('content')
    <h2 style="color: #2b9346; margin-top: 0; font-size: 22px;">Thank you for your order, {{ $order->first_name }}!</h2>

    <p style="font-size: 15px; color: #555555; line-height: 1.6;">
        We've received your order <strong>{{ $order->order_number }}</strong> and confirmed your payment. 
        A summary of your order details is shown below.
    </p>

    <!-- Order & Shipping Info Box -->
    <div style="margin: 25px 0; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; font-family: sans-serif;">
        <div style="background-color: #f8fafc; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; font-weight: bold; color: #1e293b; font-size: 14px;">
            Order Information
        </div>
        <div style="padding: 16px; background-color: #ffffff;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; line-height: 1.6; color: #334155;">
                <tr>
                    <td style="padding: 6px 0; font-weight: bold; color: #64748b; width: 35%; vertical-align: top;">Order Number:</td>
                    <td style="padding: 6px 0; color: #0f172a; font-weight: 600; vertical-align: top;">{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold; color: #64748b; vertical-align: top;">Date:</td>
                    <td style="padding: 6px 0; color: #0f172a; vertical-align: top;">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold; color: #64748b; vertical-align: top;">Payment Status:</td>
                    <td style="padding: 6px 0; color: #0f172a; vertical-align: top; text-transform: capitalize;">
                        <span style="background-color: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: bold;">
                            {{ $order->payment_status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold; color: #64748b; vertical-align: top;">Shipping Address:</td>
                    <td style="padding: 6px 0; color: #0f172a; vertical-align: top; line-height: 1.5;">
                        <strong style="color: #0f172a;">{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->address }}@if($order->apartment), {{ $order->apartment }}@endif<br>
                        {{ $order->city }}, {{ $order->state }} - {{ $order->pin_code }}<br>
                        {{ $order->country }}<br>
                        <span style="color: #64748b;">Phone:</span> {{ $order->phone }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Items Section -->
    <h3 style="color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-top: 30px; font-size: 16px;">Order Items</h3>
    <table style="width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 13px; font-family: sans-serif;">
        <thead>
            <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 10px; text-align: left; font-weight: bold; color: #475569;">Product</th>
                <th style="padding: 10px; text-align: center; font-weight: bold; color: #475569; width: 10%;">Qty</th>
                <th style="padding: 10px; text-align: right; font-weight: bold; color: #475569; width: 20%;">Price</th>
                <th style="padding: 10px; text-align: right; font-weight: bold; color: #475569; width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 10px; vertical-align: top;">
                        <div style="font-weight: bold; color: #1e293b; font-size: 13px;">{{ $item->product_name }}</div>
                        @if($item->variant_details)
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px; font-style: italic;">
                                {{ $item->variant_details }}
                            </div>
                        @endif
                    </td>
                    <td style="padding: 12px 10px; text-align: center; vertical-align: top; color: #334155;">
                        {{ $item->quantity }}
                    </td>
                    <td style="padding: 12px 10px; text-align: right; vertical-align: top; color: #334155;">
                        ₹{{ number_format($item->price, 2) }}
                    </td>
                    <td style="padding: 12px 10px; text-align: right; vertical-align: top; font-weight: bold; color: #0f172a;">
                        ₹{{ number_format($item->line_total, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Price Breakdown Section -->
    <div style="width: 100%; max-width: 320px; margin-left: auto; margin-top: 20px; margin-bottom: 30px; font-family: sans-serif;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; color: #334155;">
            <tr>
                <td style="padding: 6px 0; color: #64748b;">Subtotal:</td>
                <td style="padding: 6px 0; text-align: right; font-weight: 600; color: #1e293b;">₹{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b;">Shipping Cost:</td>
                <td style="padding: 6px 0; text-align: right; font-weight: 600; color: #1e293b;">
                    @if($order->shipping_cost > 0)
                        ₹{{ number_format($order->shipping_cost, 2) }}
                    @else
                        Free
                    @endif
                </td>
            </tr>
            @if($order->coupon_code || $order->discount > 0)
                <tr>
                    <td style="padding: 6px 0; color: #64748b; vertical-align: middle;">
                        Discount:
                        @if($order->coupon_code)
                            <span style="font-size: 11px; background-color: #dcfce7; color: #15803d; padding: 1px 6px; border-radius: 4px; font-weight: bold; margin-left: 4px;">
                                {{ $order->coupon_code }}
                            </span>
                        @endif
                    </td>
                    <td style="padding: 6px 0; text-align: right; font-weight: bold; color: #16a34a;">
                        -₹{{ number_format($order->discount, 2) }}
                    </td>
                </tr>
            @endif
            <tr style="border-top: 2px solid #e2e8f0;">
                <td style="padding: 12px 0; font-size: 15px; font-weight: bold; color: #0f172a;">Grand Total:</td>
                <td style="padding: 12px 0; text-align: right; font-size: 16px; font-weight: bold; color: #2b9346;">
                    ₹{{ number_format($order->grand_total, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <p style="font-size: 14px; color: #475569; line-height: 1.6; margin-top: 25px;">
        We will notify you by email as soon as your order has shipped with tracking details. If you have any questions, feel free to contact us.
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('order.success', ['order' => $order->order_number]) }}" class="button" style="display: inline-block; background-color: #2b9346; color: #ffffff !important; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-weight: bold; font-size: 14px;">View Order Status</a>
    </div>
@endsection

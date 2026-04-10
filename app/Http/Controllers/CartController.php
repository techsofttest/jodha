<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductColor;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $razorpayId;
    private $razorpayKey;

    public function __construct()
    {
        $this->razorpayId = config('services.razorpay.key');
        $this->razorpayKey = config('services.razorpay.secret');
    }


    /**
     * Get cart contents (AJAX)
     */
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $cartData = $this->buildCartData($cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart'    => $cartData['items'],
                'count'   => $cartData['count'],
                'subtotal' => $cartData['subtotal'],
                'subtotal_formatted' => '₹' . number_format($cartData['subtotal'], 2),
            ]);
        }

        return view('pages.cart', compact('cartData'));
    }

    /**
     * Checkout page
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $cartData = $this->buildCartData($cart);

        return view('pages.checkout', compact('cartData'));
    }


    /**
     * Add item to cart (AJAX)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'size_id'     => 'nullable|integer|exists:product_sizes,id',
            'color_id'    => 'nullable|integer|exists:product_colors,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Build a unique cart key based on product + variant
        $cartKey = $this->buildCartKey($request->product_id, $request->size_id, $request->color_id);

        $cart = session()->get('cart', []);

        // Determine the price to use
        $price = $product->prod_price;
        $sizeName = null;
        $colorName = null;

        // If a size variant is selected, use its price
        if ($request->size_id) {
            $size = ProductSize::find($request->size_id);
            if ($size) {
                $sizeName = $size->size;
                // Use size-specific price if available
                if ($size->offer_price) {
                    $price = $size->offer_price;
                } elseif ($size->price) {
                    $price = $size->price;
                }
            }
        } else {
            // Use product-level sale price if available
            if ($product->prod_sale_price) {
                $price = $product->prod_sale_price;
            }
        }

        if ($request->color_id) {
            $color = ProductColor::find($request->color_id);
            if ($color) {
                $colorName = $color->color_name;
            }
        }

        if (isset($cart[$cartKey])) {
            // Item already in cart, increase quantity
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            // New item
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name'       => $product->prod_name,
                'slug'       => $product->prod_slug,
                'image'      => $product->prod_image,
                'price'      => $price,
                'original_price' => $product->prod_price,
                'quantity'   => $request->quantity,
                'size_id'    => $request->size_id,
                'size_name'  => $sizeName,
                'color_id'   => $request->color_id,
                'color_name' => $colorName,
                'shipping_cost' => $product->shipping_cost ?? 0,
            ];
        }

        session()->put('cart', $cart);

        $cartData = $this->buildCartData($cart);

        return response()->json([
            'success'  => true,
            'message'  => $product->prod_name . ' added to cart!',
            'cart'     => $cartData['items'],
            'count'    => $cartData['count'],
            'subtotal' => $cartData['subtotal'],
            'subtotal_formatted' => '₹' . number_format($cartData['subtotal'], 2),
        ]);
    }


    /**
     * Update cart item quantity (AJAX)
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_key'  => 'required|string',
            'quantity'  => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            $cart[$request->cart_key]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        $cartData = $this->buildCartData($cart);

        return response()->json([
            'success'  => true,
            'cart'     => $cartData['items'],
            'count'    => $cartData['count'],
            'subtotal' => $cartData['subtotal'],
            'subtotal_formatted' => '₹' . number_format($cartData['subtotal'], 2),
        ]);
    }


    /**
     * Remove item from cart (AJAX)
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            unset($cart[$request->cart_key]);
            session()->put('cart', $cart);
        }

        $cartData = $this->buildCartData($cart);

        return response()->json([
            'success'  => true,
            'message'  => 'Item removed from cart.',
            'cart'     => $cartData['items'],
            'count'    => $cartData['count'],
            'subtotal' => $cartData['subtotal'],
            'subtotal_formatted' => '₹' . number_format($cartData['subtotal'], 2),
        ]);
    }


    /**
     * Clear entire cart (AJAX)
     */
    public function clear(Request $request)
    {
        session()->forget('cart');
        session()->forget('coupon');

        return response()->json([
            'success'  => true,
            'message'  => 'Cart cleared.',
            'cart'     => [],
            'count'    => 0,
            'subtotal' => 0,
            'subtotal_formatted' => '₹0.00',
        ]);
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = \App\Models\Coupon::where('coupon_code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
        }

        if ($coupon->coupon_fromdate && now()->startOfDay()->lt(\Carbon\Carbon::parse($coupon->coupon_fromdate))) {
            return response()->json(['success' => false, 'message' => 'This coupon is not yet active.']);
        }

        if ($coupon->coupon_todate && now()->startOfDay()->gt(\Carbon\Carbon::parse($coupon->coupon_todate))) {
            return response()->json(['success' => false, 'message' => 'This coupon has expired.']);
        }

        session()->put('coupon', [
            'code' => $coupon->coupon_code,
            'type' => $coupon->coupon_type,
            'amount' => $coupon->coupon_amount,
        ]);

        $cart = session()->get('cart', []);
        $cartData = $this->buildCartData($cart);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'cartData' => $cartData
        ]);
    }

    /**
     * Place order (AJAX)
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pin_code' => 'required|string|max:20',
            'shippingMethod' => 'required|string',
            // 'paymentGateway' => 'required|string', // We know it's Razorpay now
            
            // Conditional billing validation
            'billing_first_name' => 'required_if:billingAddress,billingDifferent|nullable|string|max:255',
            'billing_last_name' => 'required_if:billingAddress,billingDifferent|nullable|string|max:255',
            'billing_email' => 'required_if:billingAddress,billingDifferent|nullable|email|max:255',
            'billing_phone' => 'required_if:billingAddress,billingDifferent|nullable|string|max:20',
            'billing_address' => 'required_if:billingAddress,billingDifferent|nullable|string|max:255',
            'billing_city' => 'required_if:billingAddress,billingDifferent|nullable|string|max:255',
            'billing_state' => 'required_if:billingAddress,billingDifferent|nullable|string|max:255',
            'billing_pin_code' => 'required_if:billingAddress,billingDifferent|nullable|string|max:20',
            'billing_country' => 'required_if:billingAddress,billingDifferent|nullable|string|max:255',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }

        $cartData = $this->buildCartData($cart);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $billingDetails = null;
            if ($request->billingAddress === 'billingDifferent') {
                $billingDetails = [
                    'first_name' => $request->billing_first_name,
                    'last_name' => $request->billing_last_name,
                    'email' => $request->billing_email,
                    'address' => $request->billing_address,
                    'apartment' => $request->billing_apartment,
                    'city' => $request->billing_city,
                    'state' => $request->billing_state,
                    'pin_code' => $request->billing_pin_code,
                    'country' => $request->billing_country,
                    'phone' => $request->billing_phone,
                ];
            }

            $order = \App\Models\Order::create([
                'order_number' => 'JOD-' . strtoupper(uniqid()),
                'user_id' => Auth::guard('customer')->id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'pin_code' => $request->pin_code,
                'billing_details' => $billingDetails,
                'shipping_method' => $request->shippingMethod,
                'payment_method' => 'razorpay',
                'subtotal' => $cartData['subtotal'],
                'shipping_cost' => $cartData['total_shipping'],
                'discount' => $cartData['discount'],
                'coupon_code' => $cartData['applied_coupon'],
                'grand_total' => $cartData['grand_total'],
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create Razorpay Order
            $api = new Api($this->razorpayId, $this->razorpayKey);
            $razorpayOrder = $api->order->create([
                'receipt'         => $order->order_number,
                'amount'          => round($order->grand_total * 100), // Amount in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // Auto capture
            ]);

            $order->update(['notes' => $razorpayOrder['id']]); // Temporarily store rzp_order_id in notes or a meta field

            foreach ($cart as $item) {
                // Determine variant string
                $variant = '';
                if ($item['color_name']) $variant .= $item['color_name'];
                if ($item['size_name']) {
                    if ($variant) $variant .= ' / ';
                    $variant .= $item['size_name'];
                }

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'size_id' => $item['size_id'],
                    'color_id' => $item['color_id'],
                    'variant_details' => $variant,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'shipping_cost' => $item['shipping_cost'] ?? 0,
                    'line_total' => $item['price'] * $item['quantity'],
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $order->grand_total * 100,
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'contact' => $request->phone,
                'order_number' => $order->order_number,
                'key' => $this->razorpayId
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Verify payment status (AJAX)
     */
    public function verifyPayment(Request $request)
    {
        $input = $request->all();
        $api = new Api($this->razorpayId, $this->razorpayKey);

        try {
            // Verify signature
            $attributes = [
                'razorpay_order_id' => $input['razorpay_order_id'],
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'razorpay_signature' => $input['razorpay_signature']
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Fetch order
            $order = \App\Models\Order::where('order_number', $input['order_number'])->first();
            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing', // Move from pending to processing
                    'notes' => 'Razorpay Payment ID: ' . $input['razorpay_payment_id']
                ]);
            }

            // Clear cart
            session()->forget('cart');
            session()->forget('coupon');

            return response()->json([
                'success' => true,
                'message' => 'Payment successful!',
                'redirect_url' => route('order.success') . '?order=' . $order->order_number
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed: ' . $e->getMessage()]);
        }
    }


    /**
     * Order success page
     */
    public function success(Request $request)
    {
        $orderNumber = $request->get('order');
        $order = \App\Models\Order::where('order_number', $orderNumber)->first();
        
        return view('pages.order-success', compact('order'));
    }


    /**
     * Remove applied coupon
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
        $cart = session()->get('cart', []);
        $cartData = $this->buildCartData($cart);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
            'cartData' => $cartData
        ]);
    }


    /**
     * Build a unique cart key from product + variant IDs
     */
    private function buildCartKey($productId, $sizeId = null, $colorId = null)
    {
        $key = 'p' . $productId;
        if ($sizeId) $key .= '_s' . $sizeId;
        if ($colorId) $key .= '_c' . $colorId;
        return $key;
    }


    /**
     * Build structured cart data for JSON response
     */
    private function buildCartData($cart)
    {
        $items = [];
        $totalCount = 0;
        $subtotal = 0;
        $totalShippingCost = 0;

        foreach ($cart as $key => $item) {
            $lineTotal = $item['price'] * $item['quantity'];
            $subtotal += $lineTotal;
            $totalCount += $item['quantity'];
            
            $shipping_cost = isset($item['shipping_cost']) ? $item['shipping_cost'] : 0;
            $lineShipping = $shipping_cost * $item['quantity'];
            $totalShippingCost += $lineShipping;

            $variant = '';
            if ($item['color_name']) {
                $variant .= $item['color_name'];
            }
            if ($item['size_name']) {
                if ($variant) $variant .= ' / ';
                $variant .= $item['size_name'];
            }

            $items[] = [
                'cart_key'      => $key,
                'product_id'    => $item['product_id'],
                'name'          => $item['name'],
                'slug'          => $item['slug'],
                'image'         => asset('storage/' . $item['image']),
                'price'         => $item['price'],
                'price_formatted' => '₹' . number_format($item['price'], 2),
                'original_price' => $item['original_price'],
                'quantity'      => $item['quantity'],
                'line_total'    => $lineTotal,
                'line_total_formatted' => '₹' . number_format($lineTotal, 2),
                'variant'       => $variant,
                'url'           => route('product.show', $item['slug']),
                'shipping_cost' => $shipping_cost,
                'shipping_cost_formatted' => '₹' . number_format($shipping_cost, 2),
            ];
        }

        $discountAmount = 0;
        $appliedCoupon = null;

        $coupon = session()->get('coupon');
        if ($coupon && $subtotal > 0) {
            $appliedCoupon = $coupon['code'];
            if ($coupon['type'] == 1) {
                // Percentage
                $discountAmount = ($subtotal * $coupon['amount']) / 100;
            } else {
                // Cash
                $discountAmount = $coupon['amount'];
            }
            if ($discountAmount > $subtotal) {
                $discountAmount = $subtotal;
            }
        }

        $grandTotal = ($subtotal - $discountAmount) + $totalShippingCost;

        return [
            'items'    => $items,
            'count'    => $totalCount,
            'subtotal' => $subtotal,
            'subtotal_formatted' => '₹' . number_format($subtotal, 2),
            'total_shipping' => $totalShippingCost,
            'total_shipping_formatted' => '₹' . number_format($totalShippingCost, 2),
            'discount' => $discountAmount,
            'discount_formatted' => '-₹' . number_format($discountAmount, 2),
            'applied_coupon' => $appliedCoupon,
            'grand_total' => $grandTotal,
            'grand_total_formatted' => '₹' . number_format($grandTotal, 2),
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        // Get order statistics for the customer
        $totalOrders = Order::where('user_id', $customer->id)->count();
        $pendingOrders = Order::where('user_id', $customer->id)->where('status', 'pending')->count();
        $totalSpent = Order::where('user_id', $customer->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        // Fetch recent orders
        $recentOrders = Order::with(['items.product'])->where('user_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('profile.dashboard', compact('customer', 'totalOrders', 'pendingOrders', 'totalSpent', 'recentOrders'));
    }

    public function orders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::with(['items.product'])->where('user_id', $customer->id)->latest()->paginate(10);
        return view('profile.orders', compact('customer', 'orders'));
    }

    public function cancel(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Check ownership
        if ($order->user_id !== $customer->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized action.'], 403);
        }

        // Check if already delivered/completed
        $restrictiveStatuses = ['delivered', 'completed', 'cancelled', 'shipped'];
        if (in_array($order->status, $restrictiveStatuses)) {
            return response()->json(['status' => 'error', 'message' => 'This order cannot be cancelled as it is already ' . $order->status . '.'], 400);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json(['status' => 'success', 'message' => 'Order #'.$order->order_number.' has been cancelled successfully.']);
    }

    public function addresses()
    {
        $customer = Auth::guard('customer')->user();
        $addresses = CustomerAddress::where('user_id', $customer->id)->latest()->get();
        return view('profile.addresses', compact('customer', 'addresses'));
    }

    public function storeAddress(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $isDefault = $request->has('is_default') ? 1 : 0;
        
        if ($isDefault) {
            CustomerAddress::where('user_id', $customer->id)->update(['is_default' => 0]);
        }

        CustomerAddress::create(array_merge($request->all(), [
            'user_id' => $customer->id,
            'is_default' => $isDefault
        ]));

        return response()->json(['status' => 'success', 'message' => 'Address saved successfully.']);
    }

    public function updateAddress(Request $request, CustomerAddress $address)
    {
        $customer = Auth::guard('customer')->user();
        if ($address->user_id !== $customer->id) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $isDefault = $request->has('is_default') ? 1 : 0;
        
        if ($isDefault) {
            CustomerAddress::where('user_id', $customer->id)->update(['is_default' => 0]);
        }

        $address->update(array_merge($request->all(), ['is_default' => $isDefault]));

        return response()->json(['status' => 'success', 'message' => 'Address updated successfully.']);
    }

    public function deleteAddress(CustomerAddress $address)
    {
        $customer = Auth::guard('customer')->user();
        if ($address->user_id !== $customer->id) abort(403);
        
        $address->delete();
        return response()->json(['status' => 'success', 'message' => 'Address deleted successfully.']);
    }

    public function setDefaultAddress(CustomerAddress $address)
    {
        $customer = Auth::guard('customer')->user();
        if ($address->user_id !== $customer->id) abort(403);

        CustomerAddress::where('user_id', $customer->id)->update(['is_default' => 0]);
        $address->update(['is_default' => 1]);

        return response()->json(['status' => 'success', 'message' => 'Default address updated.']);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Auth::guard('customer')->user();

        if (!Hash::check($request->current_password, $customer->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password does not match'
            ], 401);
        }

        $customer->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully!'
        ]);
    }
}


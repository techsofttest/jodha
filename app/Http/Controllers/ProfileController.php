<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
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
        $recentOrders = Order::where('user_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('profile.dashboard', compact('customer', 'totalOrders', 'pendingOrders', 'totalSpent', 'recentOrders'));
    }

    public function orders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::where('user_id', $customer->id)->latest()->paginate(10);
        return view('profile.orders', compact('customer', 'orders'));
    }

    public function addresses()
    {
        $customer = Auth::guard('customer')->user();
        $addresses = $customer->addresses;
        return view('profile.addresses', compact('customer', 'addresses'));
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


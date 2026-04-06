<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Create an order immediately (Buy Now)
     */
    public function placeOrder(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        Order::create([
            'user_id'      => Auth::id(),
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'price'        => $product->price,
            'status'       => 'pending'
        ]);

        return redirect()->route('orders.my')->with('success', 'Order placed successfully!');
    }

    /**
     * View logged-in user's orders
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('my_orders', compact('orders'));
    }

    /**
     * Cancel a pending order
     */
    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->status == 'pending') {
            $order->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Order cancelled.');
        }

        return redirect()->back()->with('error', 'Cannot cancel this order.');
    }

    /**
     * Admin: Update status
     */
    public function updateStatus($id, $status)
    {
        if (Auth::user()->is_admin != 1) { abort(403); }

        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);

        return redirect()->back()->with('success', 'Order status updated!');
    }
}
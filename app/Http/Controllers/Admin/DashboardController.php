<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Security Check
        if (Auth::user()->is_admin != 1) {
            return redirect()->route('home');
        }

        // 2. Fetch Data for all tabs
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        $users = User::where('is_admin', 0)->get(); // Show only customers
        
        // Fetch ALL orders for the admin to see
        $orders = Order::with(['user', 'product'])->latest()->get();

        // 3. Return the single Dashboard view
        return view('admin.dashboard', compact('products', 'categories', 'users', 'orders'));
    }
}
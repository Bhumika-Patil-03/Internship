<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart', compact('cartItems'));
    }

    public function addToCart($id) {
        if (!Auth::check()) { return redirect()->route('login'); }
        
        $item = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();
        if ($item) {
            $item->increment('quantity');
        } else {
            Cart::create(['user_id' => Auth::id(), 'product_id' => $id, 'quantity' => 1]);
        }
        return redirect()->back()->with('success', 'Added to cart!');
    }

    public function remove($id) {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Removed from cart.');
    }
}
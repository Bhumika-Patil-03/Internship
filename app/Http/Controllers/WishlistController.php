<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index() {
        $wishlistItems = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('wishlist', compact('wishlistItems'));
    }

    public function toggleWishlist($id) {
        if (!Auth::check()) { return redirect()->route('login'); }
        
        $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $id)->first();
        if ($exists) {
            $exists->delete();
            return redirect()->back()->with('success', 'Removed from Wishlist');
        } else {
            Wishlist::create(['user_id' => Auth::id(), 'product_id' => $id]);
            return redirect()->back()->with('success', 'Added to Wishlist');
        }
    }
}
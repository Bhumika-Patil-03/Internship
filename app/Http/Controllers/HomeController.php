<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the Front Page with Search Functionality
     */
    public function index(Request $request)
    {
        // 1. Fetch all categories for the sidebar
        $categories = Category::all();
        
        // 2. Capture the search input from the URL (?search=item)
        $searchTerm = $request->input('search');

        // 3. Create the Product Query
        $query = Product::query();

        // 4. If a search term exists, filter by Name or Description
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 5. Execute the query to get products for the Featured section
        $products = $query->latest()->get();

        // 6. Data for the bottom sliders (remains unfiltered)
        $latestProducts = Product::latest()->take(6)->get();
        $topRatedProducts = Product::inRandomOrder()->take(6)->get();
        $reviewProducts = Product::orderBy('name', 'desc')->take(6)->get();

        return view('welcome', compact(
            'categories', 
            'products', 
            'latestProducts', 
            'topRatedProducts', 
            'reviewProducts'
        ));
    }

    /**
     * Display Products by Category
     */
    public function category($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->get();
        
        return view('shop', compact('categories', 'category', 'products'));
    }

    /**
     * Display Product Details
     */
    public function product_details($id)
    {
        $product = Product::findOrFail($id);
        return view('product_details', compact('product'));
    }
}
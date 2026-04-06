<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private function checkAdmin() 
    {
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function create() 
    {
        $this->checkAdmin();
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request) 
    {
        $this->checkAdmin();
        
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string', 
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();  
            // Changed to 'uploads/products' to avoid folder/route conflict
            $request->image->move(public_path('uploads/products'), $imageName);
            $validatedData['image'] = 'uploads/products/' . $imageName;
        }

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit($id) 
    {
        $this->checkAdmin();
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id) 
    {
        $this->checkAdmin();
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if (File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $imageName = time() . '.' . $request->image->extension();  
            $request->image->move(public_path('uploads/products'), $imageName);
            $validatedData['image'] = 'uploads/products/' . $imageName;
        }

        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function destroy($id) 
    {
        $this->checkAdmin();
        $product = Product::findOrFail($id);
        if (File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
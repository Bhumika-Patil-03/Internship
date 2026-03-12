<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. List Products (with Search & Category Filter)
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory']);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(5); 

        return view('admin.products.index', compact('products'));
    }

    // 2. SHOW CREATE FORM (This was missing!)
    public function create()
    {
        // Get only main categories (where parent_id is null)
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.products.create', compact('categories'));
    }

    // 3. Save New Product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product Added Successfully!');
    }

    // 4. Show Edit Form
    public function edit(Product $product)
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. Update Product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if($product->image) { Storage::disk('public')->delete($product->image); }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully!');
    }

    // 6. Delete Product
    public function destroy(Product $product)
    {
        if($product->image) { Storage::disk('public')->delete($product->image); }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted!');
    }

    // 7. AJAX logic for Dependent Dropdown
    public function getSubcategories($parentId)
    {
        $subcategories = Category::where('parent_id', $parentId)->get();
        return response()->json($subcategories);
    }
}
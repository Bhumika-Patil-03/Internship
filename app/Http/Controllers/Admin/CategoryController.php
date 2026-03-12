<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Use paginate instead of get
        $categories = Category::with('parent')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    // Logic to check if category is present before saving
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255', // Checks for duplicates
            'parent_id' => 'nullable|exists:categories,id'
        ], [
            'name.unique' => 'This Category name is already present in our records.' // Custom message
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Created Successfully!');
    }

    public function edit(Category $category) {
        $parentCategories = Category::where('id', '!=', $category->id)->whereNull('parent_id')->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    // Logic to check duplicates while updating
    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id'
        ], [
            'name.unique' => 'This Category name is already present.'
        ]);

        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Updated Successfully!');
    }

    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Security Check: Only Admins can manage categories.
     */
    private function checkAdmin() 
    {
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            abort(403, 'Unauthorized access.');
        }
    }

    /**
     * Show form to create a new category.
     */
    public function create() 
    {
        $this->checkAdmin();

        // FIX: This fetches categories so the "Parent Category" dropdown works
        $parentCategories = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store the category in the database.
     */
    public function store(Request $request) 
    {
        $this->checkAdmin();

        $validatedData = $request->validate([
            'name'      => 'required|string|max:255|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($validatedData);

        // Redirects to your Dashboard Categories tab
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Show form to edit an existing category.
     */
    public function edit($id) 
    {
        $this->checkAdmin();
        $category = Category::findOrFail($id);

        // FIX: Also provide categories here, excluding the current one to prevent circular loops
        $parentCategories = Category::whereNull('parent_id')
                            ->where('id', '!=', $id)
                            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the category in the database.
     */
    public function update(Request $request, $id) 
    {
        $this->checkAdmin();
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name'      => 'required|string|max:255|unique:categories,name,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Delete the category.
     */
    public function destroy($id) 
    {
        $this->checkAdmin();
        $category = Category::findOrFail($id);
        
        // Before deleting, make any sub-categories top-level
        Category::where('parent_id', $id)->update(['parent_id' => null]);
        
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
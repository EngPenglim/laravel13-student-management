<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with book count.
     */
    public function index()
    {
        $categories = Category::withCount('books')->orderBy('category_id')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'shelf_location' => ['nullable', 'string', 'max:100'],
            'floor_no' => ['nullable', 'integer', 'min:1'],
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Book Category created successfully!');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'shelf_location' => ['nullable', 'string', 'max:100'],
            'floor_no' => ['nullable', 'integer', 'min:1'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $name = $category->category_name;
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', "Category '{$name}' deleted successfully!");
    }
}

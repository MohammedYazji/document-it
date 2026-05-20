<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::with(['parent', 'posts'])
            ->latest()
            ->get();

        return view('dashboard.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $parents = Category::whereNull('parent_id')->latest()->get();

        return view('dashboard.categories.create', [
            'category' => new Category(),
            'parents'  => $parents,
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        $request->merge([
            'slug' => Str::slug($request->input('name')),
        ]);

        Category::create($request->only(['name', 'slug', 'description', 'parent_id']));

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(int $id)
    {
        $category = Category::findOrFail($id);

        // Exclude self and own children from parent options to avoid circular refs
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->latest()
            ->get();

        return view('dashboard.categories.edit', [
            'category' => $category,
            'parents'  => $parents,
        ]);
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        $request->merge([
            'slug' => Str::slug($request->input('name')),
        ]);

        $category->update($request->only(['name', 'slug', 'description', 'parent_id']));

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(int $id)
    {
        Category::destroy($id);

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}

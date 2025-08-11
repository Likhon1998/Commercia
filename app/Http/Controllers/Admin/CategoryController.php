<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Get all categories with their parent, newest first
        $categories = Category::with('parent')->orderBy('created_at', 'desc')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Fetch only root categories (parent_id null) for parent dropdown
        $categories = Category::whereNull('parent_id')->get();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Category::where('name', $value)
                        ->where('parent_id', $request->parent_id)
                        ->exists();
                    if ($exists) {
                        $fail("Category '{$value}' already exists under the selected parent category.");
                    }
                }
            ],
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Create unique slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Fetch only root categories except current for parent dropdown
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $category) {
                    $exists = Category::where('name', $value)
                        ->where('parent_id', $request->parent_id)
                        ->where('id', '!=', $category->id)
                        ->exists();
                    if ($exists) {
                        $fail("Category '{$value}' already exists under the selected parent category.");
                    }
                }
            ],
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
            'status' => 'nullable|in:active,inactive',
        ]);

        // Create unique slug (exclude current category)
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? $category->status,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with subcategories.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}

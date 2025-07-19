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
        $categories = Category::with('parent')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    
    public function create()
    {
        $allCategories = Category::all(); 
        return view('categories.create', compact('allCategories'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->parent_id = $request->parent_id;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    
    public function show(Category $category)
    {
        return redirect()->route('categories.index');
    }

    
    public function edit(Category $category)
    {
        $allCategories = Category::where('id', '!=', $category->id)->get(); 
        return view('categories.edit', compact('category', 'allCategories'));
    }

    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->parent_id = $request->parent_id;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    
}

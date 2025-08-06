<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category; // Section = Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('category')->latest()->get();
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('brands.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->category_id = $request->category_id;
        $brand->status = $request->status;

        if ($request->hasFile('image')) {
            $brand->image = $request->file('image')->store('brands', 'public');
        }

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand added successfully.');
    }

    public function edit(Brand $brand)
    {
        $categories = Category::where('status', 'active')->get();
        return view('brands.edit', compact('brand', 'categories'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $brand->name = $request->name;
        $brand->category_id = $request->category_id;
        $brand->status = $request->status;

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
            $brand->image = $request->file('image')->store('brands', 'public');
        }

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}

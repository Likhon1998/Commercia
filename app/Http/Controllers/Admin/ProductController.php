<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'primaryImage')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $attributes = ProductAttribute::with('values')->get();

        // Important: set empty selected attributes for new product create form
        $selectedAttributeValueIds = [];

        return view('products.create', compact('categories', 'attributes', 'selectedAttributeValueIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric',
            'sku'           => 'nullable|string|max:100|unique:products,sku',
            'stock_qty'     => 'required|integer',
            'category_id'   => 'required|exists:categories,id',
            'status'        => 'required|in:1,0',
            'image'         => 'nullable|image|max:2048',
            'attribute_value_ids' => 'nullable|array',
            'attribute_value_ids.*' => 'exists:product_attribute_values,id',
        ]);

        $product = Product::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'description'   => $request->description,
            'price'         => $request->price,
            'sku'           => $request->sku,
            'stock_qty'     => $request->stock_qty,
            'category_id'   => $request->category_id,
            'status'        => (int) $request->status,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id'    => $product->id,
                'image_path'    => $path,
                'is_primary'    => true,
            ]);
        }

        if ($request->filled('attribute_value_ids')) {
            $product->attributeValues()->attach($request->attribute_value_ids);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $attributes = ProductAttribute::with('values')->get();

        $selectedAttributeValueIds = $product->attributeValues->pluck('id')->toArray();

        return view('products.edit', compact('product', 'categories', 'attributes', 'selectedAttributeValueIds'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric',
            'sku'           => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'stock_qty'     => 'required|integer',
            'category_id'   => 'required|exists:categories,id',
            'status'        => 'required|in:1,0',
            'image'         => 'nullable|image|max:2048',
            'attribute_value_ids' => 'nullable|array',
            'attribute_value_ids.*' => 'exists:product_attribute_values,id',
        ]);

        $product->update([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'description'   => $request->description,
            'price'         => $request->price,
            'sku'           => $request->sku,
            'stock_qty'     => $request->stock_qty,
            'category_id'   => $request->category_id,
            'status'        => (int) $request->status,
        ]);

        if ($request->hasFile('image')) {
            $oldImage = $product->primaryImage;
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
                $oldImage->delete();
            }

            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        if ($request->filled('attribute_value_ids')) {
            $product->attributeValues()->sync($request->attribute_value_ids);
        } else {
            $product->attributeValues()->detach();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->attributeValues()->detach();

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

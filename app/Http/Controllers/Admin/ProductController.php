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
        $selectedAttributeValueIds = [];

        return view('products.create', compact('categories', 'attributes', 'selectedAttributeValueIds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string',
            'price'                 => 'required|numeric',
            'sku'                   => 'nullable|string|max:100|unique:products,sku',
            'stock_qty'             => 'required|integer',
            'category_id'           => 'required|exists:categories,id',
            'status'                => 'required|in:1,0',
            'image'                 => 'nullable|image|max:10240',
            'attribute_value_ids'   => 'nullable|array',
            'attribute_value_ids.*' => 'exists:product_attribute_values,id',
        ]);

        $product = Product::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'sku'         => $validated['sku'] ?? null,
            'stock_qty'   => $validated['stock_qty'],
            'category_id' => $validated['category_id'],
            'status'      => (int) $validated['status'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        if (!empty($validated['attribute_value_ids'])) {
            $product->attributeValues()->attach($validated['attribute_value_ids']);
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
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string',
            'price'                 => 'required|numeric',
            'sku'                   => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'stock_qty'             => 'required|integer',
            'category_id'           => 'required|exists:categories,id',
            'status'                => 'required|in:1,0',
            'image'                 => 'nullable|image|max:2048',
            'attribute_value_ids'   => 'nullable|array',
            'attribute_value_ids.*' => 'exists:product_attribute_values,id',
        ]);

        $product->update([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'sku'         => $validated['sku'] ?? null,
            'stock_qty'   => $validated['stock_qty'],
            'category_id' => $validated['category_id'],
            'status'      => (int) $validated['status'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->primaryImage) {
                Storage::disk('public')->delete($product->primaryImage->image_path);
                $product->primaryImage->delete();
            }

            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        if (!empty($validated['attribute_value_ids'])) {
            $product->attributeValues()->sync($validated['attribute_value_ids']);
        } else {
            $product->attributeValues()->detach();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'primaryImage',
            'images',
            'attributeValues.attribute',
            'reviews.user',
            'reviews.replies.user',
        ]);

        return view('products.show', compact('product'));
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

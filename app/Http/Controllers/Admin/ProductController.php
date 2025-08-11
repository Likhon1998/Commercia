<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\People;
use App\Models\Unit;
use App\Models\Vat;
use App\Models\VatGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'subCategory', 'brand', 'supplier', 'primaryImage')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->get();
        $suppliers = People::where('status', 1)
            ->whereJsonContains('person_type', 'supplier')
            ->get();
        $units = Unit::where('status', 'active')->get();
        $vats = Vat::where('status', 'active')->get();
        $vatGroups = VatGroup::where('status', 'active')->get();

        return view('products.create', compact(
            'brands',
            'categories',
            'suppliers',
            'units',
            'vats',
            'vatGroups'
        ));
    }

    public function show(Product $product)
    {
        $product->load('category', 'subCategory', 'brand', 'supplier', 'unit', 'vat', 'vatGroup');
        return view('products.show', compact('product'));
    }

    protected function getVatPercentage($vatType, $vatId)
    {
        if (!$vatId) return 0;

        if ($vatType === 'vat') {
            $vat = Vat::find($vatId);
            return $vat ? (float)$vat->percentage : 0;
        } elseif ($vatType === 'group') {
            $group = VatGroup::find($vatId);
            return $group ? (float)$group->percentage : 0;
        }

        return 0;
    }

    protected function calculateSellingPrices(array $data)
    {
        $vatType = $data['vat_type'] ?? null;
        $vatId = $data['vat_id'] ?? null;
        $costPriceInc = $data['cost_price_inclusive'] ?? null;
        $costPriceExc = $data['cost_price_exclusive'] ?? null;
        $marginPercent = $data['profit_margin'] ?? 0;
        $discountType = $data['discount_type'] ?? null;
        $discountValue = $data['discount_value'] ?? 0;
        $costPriceType = $data['cost_price_type'] ?? 'inclusive';

        $vatPercent = $this->getVatPercentage($vatType, $vatId);

        if ($costPriceType === 'inclusive' && $costPriceInc !== null) {
            $costExclusive = $costPriceInc / (1 + $vatPercent / 100);
            $costInclusive = $costPriceInc;
        } elseif ($costPriceType === 'exclusive' && $costPriceExc !== null) {
            $costExclusive = $costPriceExc;
            $costInclusive = $costPriceExc * (1 + $vatPercent / 100);
        } else {
            $costExclusive = 0;
            $costInclusive = 0;
        }

        $sellingPrice = $costExclusive * (1 + $marginPercent / 100);

        if ($discountType === 'percentage') {
            $discountAmount = $sellingPrice * ($discountValue / 100);
        } elseif ($discountType === 'amount') {
            $discountAmount = $discountValue;
        } else {
            $discountAmount = 0;
        }

        $finalSellingPrice = max(0, $sellingPrice - $discountAmount);

        return [
            'cost_price_exclusive' => round($costExclusive, 2),
            'cost_price_inclusive' => round($costInclusive, 2),
            'selling_price_exc_vat' => round($finalSellingPrice, 2),
            'selling_price_inc_vat' => round($finalSellingPrice * (1 + $vatPercent / 100), 2),
            'vat_id' => $vatId,
            'vat_type' => $vatType,
            'discount_percent' => $discountType === 'percentage' ? $discountValue : null,
            'discount_amount' => $discountType === 'amount' ? $discountValue : null,
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_type'          => 'required|in:normal,combo,variant',
            'name'                  => 'required|string|max:255',
            'slug'                  => 'nullable|string|max:255|unique:products,slug',
            'model'                 => 'nullable|string|max:255',
            'brand_id'              => 'nullable|exists:brands,id',
            'category_id'           => 'required|exists:categories,id',
            'sub_category_id'       => 'nullable|exists:categories,id',
            'supplier_id'           => 'nullable|exists:people,id',
            'unit_id'               => 'nullable|exists:units,id',
            'min_qty_alert'         => 'nullable|integer|min:0',
            'price'                 => 'required|numeric|min:0',
            'sku'                   => 'nullable|string|max:100|unique:products,sku',
            'stock_qty'             => 'required|integer|min:0',

            'vat_type'              => 'nullable|string|in:vat,group',
            'vat_id'                => 'nullable|string',
            'cost_price_type'       => 'nullable|string|in:inclusive,exclusive',
            'cost_price_inclusive'  => 'nullable|numeric|min:0',
            'cost_price_exclusive'  => 'nullable|numeric|min:0',
            'profit_margin'         => 'nullable|numeric|min:0|max:100',
            'discount_type'         => 'nullable|string|in:percentage,amount',
            'discount_value'        => 'nullable|numeric|min:0',

            'is_barcode'            => 'boolean',
            'barcode_source'        => 'nullable|in:generate,supplier',
            'image'                 => 'nullable|image|max:10240',
            'is_warranty'           => 'boolean',
            'is_salable'            => 'boolean',
            'is_expirable'          => 'boolean',
            'is_serviceable'        => 'boolean',
            'hsn_code'              => 'nullable|string|max:50',
            'show_on_website'       => 'boolean',
            'near_expiry_days'      => 'nullable|integer|min:0',
            'warning_expiry_days'   => 'nullable|integer|min:0',
            'tags'                  => 'nullable|string',
            'description'           => 'nullable|string',
            'additional_information'=> 'nullable|string',
            'status'                => 'required|in:1,0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $booleanFields = ['is_barcode', 'is_warranty', 'is_salable', 'is_expirable', 'is_serviceable', 'show_on_website'];
        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        $prices = $this->calculateSellingPrices($request->all());
        $validated = array_merge($validated, $prices);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $brands = Brand::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->get();
        $suppliers = People::whereJsonContains('person_type', 'supplier')->where('status', 'active')->get();
        $units = Unit::where('status', 'active')->get();
        $vats = Vat::where('status', 'active')->get();
        $vatGroups = VatGroup::where('status', 'active')->get();

        return view('products.edit', compact(
            'product',
            'brands',
            'categories',
            'suppliers',
            'units',
            'vats',
            'vatGroups'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_type'          => 'required|in:normal,combo,variant',
            'name'                  => 'required|string|max:255',
            'slug'                  => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'model'                 => 'nullable|string|max:255',
            'brand_id'              => 'nullable|exists:brands,id',
            'category_id'           => 'required|exists:categories,id',
            'sub_category_id'       => 'nullable|exists:categories,id',
            'supplier_id'           => 'nullable|exists:people,id',
            'unit_id'               => 'nullable|exists:units,id',
            'min_qty_alert'         => 'nullable|integer|min:0',
            'price'                 => 'required|numeric|min:0',
            'sku'                   => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'stock_qty'             => 'required|integer|min:0',

            'vat_type'              => 'nullable|string|in:vat,group',
            'vat_id'                => 'nullable|string',
            'cost_price_type'       => 'nullable|string|in:inclusive,exclusive',
            'cost_price_inclusive'  => 'nullable|numeric|min:0',
            'cost_price_exclusive'  => 'nullable|numeric|min:0',
            'profit_margin'         => 'nullable|numeric|min:0|max:100',
            'discount_type'         => 'nullable|string|in:percentage,amount',
            'discount_value'        => 'nullable|numeric|min:0',

            'is_barcode'            => 'boolean',
            'barcode_source'        => 'nullable|in:generate,supplier',
            'image'                 => 'nullable|image|max:10240',
            'is_warranty'           => 'boolean',
            'is_salable'            => 'boolean',
            'is_expirable'          => 'boolean',
            'is_serviceable'        => 'boolean',
            'hsn_code'              => 'nullable|string|max:50',
            'show_on_website'       => 'boolean',
            'near_expiry_days'      => 'nullable|integer|min:0',
            'warning_expiry_days'   => 'nullable|integer|min:0',
            'tags'                  => 'nullable|string',
            'description'           => 'nullable|string',
            'additional_information'=> 'nullable|string',
            'status'                => 'required|in:1,0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle booleans explicitly to ensure false if unchecked
        $booleanFields = ['is_barcode', 'is_warranty', 'is_salable', 'is_expirable', 'is_serviceable', 'show_on_website'];
        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        $prices = $this->calculateSellingPrices($request->all());
        $validated = array_merge($validated, $prices);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

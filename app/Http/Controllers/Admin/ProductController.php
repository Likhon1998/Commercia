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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        $costPriceInc = $data['cost_price_inclusive'] ?? $data['cost_price_inc_vat'] ?? null;
        $costPriceExc = $data['cost_price_exclusive'] ?? $data['cost_price_exc_vat'] ?? null;
        $marginPercent = $data['profit_margin'] ?? $data['margin_percent'] ?? 0;
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
            'cost_price_exc_vat'     => round($costExclusive, 2),
            'cost_price_inc_vat'     => round($costInclusive, 2),
            'selling_price_exc_vat'  => round($finalSellingPrice, 2),
            'selling_price_inc_vat'  => round($finalSellingPrice * (1 + $vatPercent / 100), 2),
            'vat_percent'            => $vatPercent,
            'vat_type'               => $vatType,
            'discount_percent'       => $discountType === 'percentage' ? $discountValue : null,
            'discount_amount'        => $discountType === 'amount' ? $discountValue : null,
            'margin_percent'         => $marginPercent,
            'profit_percent'         => $marginPercent,
        ];
    }

   public function store(Request $request)
{
    $input = $request->all();

    if (isset($input['selling_price'])) {
        $input['price'] = $input['selling_price'];
    }

    $validator = Validator::make($input, [
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
        'discount_percent'      => 'nullable|numeric|min:0|max:100',
        'vat_type'              => 'nullable|string|in:vat,group',
        'vat_id'                => 'nullable|exists:vats,id',
        'vat_percent'           => 'nullable|numeric|min:0|max:100',
        'discount_type'         => 'nullable|string|in:percentage,amount',
        'is_barcode'            => 'sometimes|boolean',
        'barcode_source'        => 'nullable|string|max:100',
        'image'                 => 'nullable|image|max:10240',
        'is_warranty'           => 'sometimes|boolean',
        'is_salable'            => 'sometimes|boolean',
        'is_expirable'          => 'sometimes|boolean',
        'is_serviceable'        => 'sometimes|boolean',
        'hsn_code'              => 'nullable|string|max:50',
        'show_on_website'       => 'sometimes|boolean',
        'near_expiry_days'      => 'nullable|integer|min:0',
        'warning_expiry_days'   => 'nullable|integer|min:0',
        'cost_price_exc_vat'    => 'nullable|numeric|min:0',
        'cost_price_inc_vat'    => 'nullable|numeric|min:0',
        'margin_percent'        => 'nullable|numeric|min:0|max:100',
        'selling_price_exc_vat' => 'nullable|numeric|min:0',
        'selling_price_inc_vat' => 'nullable|numeric|min:0',
        'profit_percent'        => 'nullable|numeric|min:0|max:100',
        'tags'                  => 'nullable|string',
        'description'           => 'nullable|string',
        'additional_information'=> 'nullable|string',
        'status'                => 'required|in:1,0',
    ]);

    if ($validator->fails()) {
        dd('Validation errors:', $validator->errors()->all());
    }

    $validated = $validator->validated();

    // Auto-generate slug if empty
    if (empty($validated['slug'])) {
        $slug = Str::slug($validated['name']);
        $count = Product::where('slug', 'like', "$slug%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $validated['slug'] = $slug;
    }

    // Fix boolean unchecked checkboxes
    $booleanFields = ['is_barcode', 'is_warranty', 'is_salable', 'is_expirable', 'is_serviceable', 'show_on_website'];
    foreach ($booleanFields as $field) {
        $validated[$field] = $request->has($field) ? (bool) $request->input($field) : false;
    }

    $prices = $this->calculateSellingPrices($validated);
    $pricesFiltered = collect($prices)->only([
        'cost_price_exc_vat',
        'cost_price_inc_vat',
        'selling_price_exc_vat',
        'selling_price_inc_vat',
        'vat_percent',
        'vat_type',
        'discount_percent',
        'discount_amount',
        'margin_percent',
        'profit_percent',
    ])->toArray();

    $validated = array_merge($validated, $pricesFiltered);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    try {
        $product = Product::create($validated);
    } catch (\Exception $e) {
        dd('Create product exception:', $e->getMessage());
    }

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}


    public function edit(Product $product)
    {
        $brands = Brand::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->get();
        $suppliers = People::whereJsonContains('person_type', 'supplier')->where('status', 1)->get();
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

            'vat_type'              => 'nullable|string|in:vat,group',
            'vat_id'                => 'nullable|exists:vats,id',
            'cost_price_type'       => 'nullable|string|in:inclusive,exclusive',
            'cost_price_inclusive'  => 'nullable|numeric|min:0',
            'cost_price_exclusive'  => 'nullable|numeric|min:0',
            'profit_margin'         => 'nullable|numeric|min:0|max:100',
            'discount_type'         => 'nullable|string|in:percentage,amount',
            'discount_value'        => 'nullable|numeric|min:0',

            'is_barcode'            => 'sometimes|boolean',
            'barcode_source'        => 'nullable|in:generate,supplier',
            'image'                 => 'nullable|image|max:10240',
            'is_warranty'           => 'sometimes|boolean',
            'is_salable'            => 'sometimes|boolean',
            'is_expirable'          => 'sometimes|boolean',
            'is_serviceable'        => 'sometimes|boolean',
            'hsn_code'              => 'nullable|string|max:50',
            'show_on_website'       => 'sometimes|boolean',
            'near_expiry_days'      => 'nullable|integer|min:0',
            'warning_expiry_days'   => 'nullable|integer|min:0',
            'tags'                  => 'nullable|string',
            'description'           => 'nullable|string',
            'additional_information'=> 'nullable|string',
            'status'                => 'required|in:1,0',
            'price'                 => 'required|numeric|min:0',
            'sku'                   => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'stock_qty'             => 'required|integer|min:0',
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $slug = Str::slug($validated['name']);
            $count = Product::where('slug', 'like', "$slug%")->where('id', '!=', $product->id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $validated['slug'] = $slug;
        }

        // Fix boolean unchecked checkboxes
        $booleanFields = ['is_barcode', 'is_warranty', 'is_salable', 'is_expirable', 'is_serviceable', 'show_on_website'];
        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field) ? (bool) $request->input($field) : false;
        }

        // Calculate prices and margins
        $prices = $this->calculateSellingPrices($validated);

        $pricesFiltered = collect($prices)->only([
            'cost_price_exc_vat',
            'cost_price_inc_vat',
            'selling_price_exc_vat',
            'selling_price_inc_vat',
            'vat_percent',
            'vat_type',
            'discount_percent',
            'discount_amount',
            'margin_percent',
            'profit_percent',
        ])->toArray();

        $validated = array_merge($validated, $pricesFiltered);

        // Image upload & delete old if exists
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

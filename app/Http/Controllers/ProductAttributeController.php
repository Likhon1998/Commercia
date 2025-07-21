<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

class ProductAttributeController extends Controller
{
    public function index()
    {
        $attributes = ProductAttribute::with('values')->get();
        return view('attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|max:255',
        ]);

        $attribute = ProductAttribute::create(['name' => $request->name]);

        foreach ($request->values as $value) {
            $attribute->values()->create(['value' => $value]);
        }

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully.');
    }

    public function edit(ProductAttribute $attribute)
    {
        $attribute->load('values');
        return view('attributes.edit', compact('attribute'));
    }

    public function update(Request $request, ProductAttribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'values_existing' => 'nullable|array',
            'values_existing.*' => 'required|string|max:255',
            'values_new' => 'nullable|array',
            'values_new.*' => 'required|string|max:255',
        ]);

        // Update attribute name
        $attribute->update(['name' => $request->name]);

        // Update existing attribute values
        if ($request->filled('values_existing')) {
            foreach ($request->values_existing as $valueId => $valueName) {
                $value = $attribute->values()->where('id', $valueId)->first();
                if ($value) {
                    $value->update(['value' => $valueName]);
                }
            }
        }

        // Add new attribute values
        if ($request->filled('values_new')) {
            foreach ($request->values_new as $newValue) {
                $attribute->values()->create(['value' => $newValue]);
            }
        }

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(ProductAttribute $attribute)
    {
        // Optionally delete related values first
        $attribute->values()->delete();

        $attribute->delete();

        return back()->with('success', 'Attribute deleted successfully.');
    }
}

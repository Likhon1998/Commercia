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
    $request->validate(['name' => 'required']);
    ProductAttribute::create($request->only('name'));
    return redirect()->route('attributes.index');
}

public function edit(ProductAttribute $attribute)
{
    return view('attributes.edit', compact('attribute'));
}

public function update(Request $request, ProductAttribute $attribute)
{
    $request->validate(['name' => 'required']);
    $attribute->update($request->only('name'));
    return redirect()->route('attributes.index');
}

public function destroy(ProductAttribute $attribute)
{
    $attribute->delete();
    return back();
}
}

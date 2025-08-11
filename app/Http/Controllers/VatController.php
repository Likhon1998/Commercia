<?php

namespace App\Http\Controllers;

use App\Models\Vat;
use Illuminate\Http\Request;

class VatController extends Controller
{
    public function index(Request $request)
    {
        $query = Vat::query();

        // Simple search by name or vat_number
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('vat_number', 'like', "%$search%");
        }

        $vats = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('vat.index', compact('vats'));
    }

    public function create()
    {
        return view('vat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:vats,name',
            'vat_number' => 'required|string|unique:vats,vat_number',
            'percentage' => 'required|numeric|between:0,100',
            'status' => 'required|in:active,inactive',
        ]);

        Vat::create($validated);

        return redirect()->route('vat.index')->with('success', 'VAT created successfully.');
    }

    public function edit(Vat $vat)
    {
        return view('vat.edit', compact('vat'));
    }

    public function update(Request $request, Vat $vat)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:vats,name,' . $vat->id,
            'vat_number' => 'required|string|unique:vats,vat_number,' . $vat->id,
            'percentage' => 'required|numeric|between:0,100',
            'status' => 'required|in:active,inactive',
        ]);

        $vat->update($validated);

        return redirect()->route('vat.index')->with('success', 'VAT updated successfully.');
    }

    public function destroy(Vat $vat)
    {
        $vat->delete();

        return redirect()->route('vat.index')->with('success', 'VAT deleted successfully.');
    }
}

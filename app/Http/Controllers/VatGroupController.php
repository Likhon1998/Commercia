<?php

namespace App\Http\Controllers;

use App\Models\Vat;
use App\Models\VatGroup;
use Illuminate\Http\Request;

class VatGroupController extends Controller
{
    public function index()
    {
        $vatGroups = VatGroup::with('vats')->orderBy('created_at', 'desc')->paginate(15);

        return view('vat-group.index', compact('vatGroups'));
    }

    public function create()
    {
        $vats = Vat::where('status', 'active')->get();

        return view('vat-group.create', compact('vats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:vat_groups,name',
            'status' => 'required|in:active,inactive',
            'vat_ids' => 'required|array',
            'vat_ids.*' => 'exists:vats,id',
        ]);

        $vatGroup = VatGroup::create([
            'name' => $validated['name'],
            'status' => $validated['status'],
        ]);

        $vatGroup->vats()->sync($validated['vat_ids']);

        return redirect()->route('vat-group.index')->with('success', 'VAT Group created successfully.');
    }

    public function edit(VatGroup $vatGroup)
{
    $vats = Vat::where('status', 'active')->get();
    $selectedVatIds = $vatGroup->vats()->pluck('vats.id')->toArray(); // FIXED here

    // Convert status int to string for dropdown
    $vatGroup->status = $vatGroup->status == 1 ? 'active' : 'inactive';

    return view('vat-group.edit', compact('vatGroup', 'vats', 'selectedVatIds'));
}

    public function update(Request $request, VatGroup $vatGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:vat_groups,name,' . $vatGroup->id,
            'status' => 'required|in:active,inactive',
            'vat_ids' => 'required|array',
            'vat_ids.*' => 'exists:vats,id',
        ]);

        $vatGroup->update([
            'name' => $validated['name'],
            'status' => $validated['status'],
        ]);

        $vatGroup->vats()->sync($validated['vat_ids']);

        return redirect()->route('vat-group.index')->with('success', 'VAT Group updated successfully.');
    }

    public function destroy(VatGroup $vatGroup)
    {
        $vatGroup->delete();

        return redirect()->route('vat-group.index')->with('success', 'VAT Group deleted successfully.');
    }
}

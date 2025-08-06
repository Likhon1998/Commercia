<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    // Show all outlets
    public function index()
    {
        $outlets = Outlet::all();
        return view('outlets.index', compact('outlets'));
    }

    // Show form to create a new outlet
    public function create()
    {
        return view('outlets.create');
    }

    // Store new outlet
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'default' => 'nullable|boolean',
        ]);

        Outlet::create($request->all());

        return redirect()->route('outlets.index')->with('success', 'Outlet created successfully.');
    }

    // Show form to edit an outlet
    public function edit(Outlet $outlet)
    {
        return view('outlets.edit', compact('outlet'));
    }

    // Update outlet
    public function update(Request $request, Outlet $outlet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'default' => 'nullable|boolean',
        ]);

        $outlet->update($request->all());

        return redirect()->route('outlets.index')->with('success', 'Outlet updated successfully.');
    }
}

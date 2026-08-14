<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::paginate(15);
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:drivers',
            'license_number' => 'required|string|unique:drivers',
            'license_plate' => 'required|string',
            'address' => 'nullable|string',
            'license_expiry' => 'nullable|date',
        ]);

        Driver::create($validated);
        return redirect()->route('drivers.index')->with('success', 'Driver created successfully');
    }

    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:drivers,phone,' . $driver->id,
            'license_number' => 'required|string|unique:drivers,license_number,' . $driver->id,
            'license_plate' => 'required|string',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
            'license_expiry' => 'nullable|date',
        ]);

        $driver->update($validated);
        return redirect()->route('drivers.show', $driver)->with('success', 'Driver updated successfully');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully');
    }
}

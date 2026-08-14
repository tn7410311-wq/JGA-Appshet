<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::paginate(15);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|unique:vehicles',
            'vehicle_type' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'capacity' => 'required|integer',
            'color' => 'nullable|string',
            'fuel_capacity' => 'required|numeric',
            'fuel_consumption' => 'required|numeric',
        ]);

        Vehicle::create($validated);
        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $vehicle->id,
            'vehicle_type' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'capacity' => 'required|integer',
            'color' => 'nullable|string',
            'status' => 'required|in:active,maintenance,inactive',
            'fuel_capacity' => 'required|numeric',
            'fuel_consumption' => 'required|numeric',
        ]);

        $vehicle->update($validated);
        return redirect()->route('vehicles.show', $vehicle)->with('success', 'Vehicle updated successfully');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully');
    }
}

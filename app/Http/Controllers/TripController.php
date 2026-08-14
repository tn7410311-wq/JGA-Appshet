<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Route;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['vehicle', 'driver', 'route'])
                      ->paginate(15);
        return view('trips.index', compact('trips'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'active')->get();
        $drivers = Driver::where('status', 'active')->get();
        $routes = Route::where('status', 'active')->get();
        return view('trips.create', compact('vehicles', 'drivers', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date_format:Y-m-d H:i',
            'passengers' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'planned';
        Trip::create($validated);
        return redirect()->route('trips.index')->with('success', 'Trip created successfully');
    }

    public function show(Trip $trip)
    {
        $trip->load(['vehicle', 'driver', 'route', 'checkins', 'expenses']);
        return view('trips.show', compact('trip'));
    }

    public function startTrip(Trip $trip)
    {
        if ($trip->status !== 'planned') {
            return back()->with('error', 'Trip must be in planned status');
        }

        $trip->update([
            'status' => 'in_progress',
            'departure_time' => now(),
        ]);

        return back()->with('success', 'Trip started successfully');
    }

    public function endTrip(Request $request, Trip $trip)
    {
        if ($trip->status !== 'in_progress') {
            return back()->with('error', 'Trip must be in progress');
        }

        $validated = $request->validate([
            'distance_traveled' => 'required|numeric',
            'fuel_used' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $trip->update(array_merge($validated, [
            'status' => 'completed',
            'arrival_time' => now(),
        ]));

        return back()->with('success', 'Trip completed successfully');
    }

    public function destroy(Trip $trip)
    {
        if ($trip->status === 'in_progress') {
            return back()->with('error', 'Cannot delete trip in progress');
        }

        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Trip deleted successfully');
    }
}

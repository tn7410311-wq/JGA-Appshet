<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Trip;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_name' => 'required|string',
            'fuel_level' => 'nullable|numeric|min:0|max:100',
            'passengers' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['checked_at'] = now();

        CheckIn::create($validated);
        return response()->json(['success' => 'Check-in recorded successfully']);
    }

    public function tripCheckins(Trip $trip)
    {
        $checkins = $trip->checkins()->latest('checked_at')->get();
        return response()->json($checkins);
    }
}

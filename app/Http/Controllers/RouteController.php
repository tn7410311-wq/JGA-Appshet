<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::paginate(15);
        return view('routes.index', compact('routes'));
    }

    public function create()
    {
        return view('routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:routes',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'distance' => 'required|numeric',
            'estimated_time' => 'required|integer',
            'standard_fuel_cost' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Route::create($validated);
        return redirect()->route('routes.index')->with('success', 'Route created successfully');
    }

    public function show(Route $route)
    {
        return view('routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        return view('routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:routes,code,' . $route->id,
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'distance' => 'required|numeric',
            'estimated_time' => 'required|integer',
            'standard_fuel_cost' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $route->update($validated);
        return redirect()->route('routes.show', $route)->with('success', 'Route updated successfully');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('routes.index')->with('success', 'Route deleted successfully');
    }
}

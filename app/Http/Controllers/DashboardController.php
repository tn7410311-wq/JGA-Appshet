<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activeTrips = Trip::where('status', 'in_progress')->count();
        $completedTripsToday = Trip::where('status', 'completed')
                                   ->whereDate('arrival_time', today())
                                   ->count();
        $activeDrivers = Driver::where('status', 'active')->count();
        $activeVehicles = Vehicle::where('status', 'active')->count();
        
        $todayExpenses = Expense::whereDate('expense_date', today())->sum('amount');
        $todayFuelCost = Expense::where('expense_type', 'fuel')
                               ->whereDate('expense_date', today())
                               ->sum('amount');
        
        $recentTrips = Trip::with(['vehicle', 'driver', 'route'])
                          ->latest('departure_time')
                          ->limit(10)
                          ->get();
        
        $topDrivers = Driver::withCount('trips')
                           ->orderByDesc('trips_count')
                           ->limit(5)
                           ->get();

        return view('dashboard.index', compact(
            'activeTrips',
            'completedTripsToday',
            'activeDrivers',
            'activeVehicles',
            'todayExpenses',
            'todayFuelCost',
            'recentTrips',
            'topDrivers'
        ));
    }
}

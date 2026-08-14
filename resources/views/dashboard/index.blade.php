@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">KTV Management Dashboard</h1>
        <span class="text-slate-400 text-sm">{{ date('l, F d, Y') }}</span>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Active Trips -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:border-red-600 transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium">Active Trips</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $activeTrips ?? 0 }}</p>
                </div>
                <i class="fas fa-route text-red-600 text-2xl"></i>
            </div>
            <p class="text-slate-500 text-xs mt-4">
                <i class="fas fa-check-circle text-green-500"></i> Running now
            </p>
        </div>

        <!-- Completed Today -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:border-blue-600 transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium">Completed Today</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $completedTripsToday ?? 0 }}</p>
                </div>
                <i class="fas fa-check text-blue-600 text-2xl"></i>
            </div>
            <p class="text-slate-500 text-xs mt-4">
                <i class="fas fa-calendar-day text-green-500"></i> This day
            </p>
        </div>

        <!-- Active Drivers -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:border-green-600 transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium">Active Drivers</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $activeDrivers ?? 0 }}</p>
                </div>
                <i class="fas fa-users text-green-600 text-2xl"></i>
            </div>
            <p class="text-slate-500 text-xs mt-4">
                <i class="fas fa-circle text-green-500"></i> On duty
            </p>
        </div>

        <!-- Active Vehicles -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:border-yellow-600 transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium">Active Vehicles</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $activeVehicles ?? 0 }}</p>
                </div>
                <i class="fas fa-car text-yellow-600 text-2xl"></i>
            </div>
            <p class="text-slate-500 text-xs mt-4">
                <i class="fas fa-check-circle text-green-500"></i> Available
            </p>
        </div>
    </div>

    <!-- Costs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Today Expenses -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">
                <i class="fas fa-money-bill-wave text-red-600"></i> Today Expenses
            </h3>
            <p class="text-2xl font-bold text-white">{{ number_format($todayExpenses ?? 0, 0, ',', '.') }} VNĐ</p>
            <p class="text-slate-400 text-xs mt-2">All expense types</p>
        </div>

        <!-- Fuel Cost Today -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">
                <i class="fas fa-gas-pump text-orange-600"></i> Fuel Cost Today
            </h3>
            <p class="text-2xl font-bold text-white">{{ number_format($todayFuelCost ?? 0, 0, ',', '.') }} VNĐ</p>
            <p class="text-slate-400 text-xs mt-2">Fuel expenses only</p>
        </div>

        <!-- Quick Actions -->
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">
                <i class="fas fa-bolt text-yellow-600"></i> Quick Actions
            </h3>
            <div class="space-y-2">
                <a href="{{ route('trips.create') }}" class="block text-sm text-red-600 hover:text-red-400 transition">
                    <i class="fas fa-plus-circle"></i> New Trip
                </a>
                <a href="{{ route('drivers.create') }}" class="block text-sm text-blue-600 hover:text-blue-400 transition">
                    <i class="fas fa-user-plus"></i> Add Driver
                </a>
                <a href="{{ route('vehicles.create') }}" class="block text-sm text-green-600 hover:text-green-400 transition">
                    <i class="fas fa-plus-square"></i> Add Vehicle
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Trips -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-white mb-4">
            <i class="fas fa-history"></i> Recent Trips
        </h2>
        
        @if($recentTrips && count($recentTrips) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-slate-400 font-semibold">Trip ID</th>
                            <th class="px-4 py-3 text-left text-slate-400 font-semibold">Driver</th>
                            <th class="px-4 py-3 text-left text-slate-400 font-semibold">Vehicle</th>
                            <th class="px-4 py-3 text-left text-slate-400 font-semibold">Route</th>
                            <th class="px-4 py-3 text-left text-slate-400 font-semibold">Status</th>
                            <th class="px-4 py-3 text-left text-slate-400 font-semibold">Departure</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTrips as $trip)
                        <tr class="border-b border-slate-800 hover:bg-slate-800/50 transition">
                            <td class="px-4 py-3 text-white font-medium">#{{ $trip->id }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $trip->driver->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $trip->vehicle->plate_number ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $trip->route->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-3 py-1 rounded text-xs font-medium
                                    @if($trip->status === 'completed') bg-green-900/30 text-green-400
                                    @elseif($trip->status === 'in_progress') bg-yellow-900/30 text-yellow-400
                                    @elseif($trip->status === 'planned') bg-blue-900/30 text-blue-400
                                    @else bg-red-900/30 text-red-400 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-400 text-xs">{{ $trip->departure_time->format('H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-slate-400 text-center py-8">
                <i class="fas fa-inbox text-3xl mb-2"></i><br>
                No trips yet. <a href="{{ route('trips.create') }}" class="text-red-600 hover:text-red-400">Create one</a>
            </p>
        @endif
    </div>

    <!-- Top Drivers -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
        <h2 class="text-xl font-bold text-white mb-4">
            <i class="fas fa-trophy"></i> Top Drivers
        </h2>
        
        @if($topDrivers && count($topDrivers) > 0)
            <div class="space-y-3">
                @foreach($topDrivers as $index => $driver)
                <div class="flex items-center justify-between bg-slate-800/50 rounded p-4">
                    <div class="flex items-center space-x-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-red-600 text-white font-bold text-sm">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <p class="text-white font-medium">{{ $driver->name }}</p>
                            <p class="text-slate-400 text-xs">{{ $driver->phone }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-white font-bold">{{ $driver->trips_count }} trips</p>
                        <p class="text-slate-400 text-xs">Total completed</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-slate-400 text-center py-8">No driver data yet</p>
        @endif
    </div>
</div>
@endsection

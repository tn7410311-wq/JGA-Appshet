@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('drivers.index') }}" class="text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left"></i> Back to Drivers
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Driver Info Card -->
        <div class="lg:col-span-2">
            <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-800 px-6 py-6">
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $driver->name }}</h1>
                    <div class="flex gap-4">
                        <span class="inline-block px-3 py-1 rounded text-xs font-medium
                            @if($driver->status === 'active') bg-green-900/30 text-green-400
                            @elseif($driver->status === 'inactive') bg-slate-900/30 text-slate-400
                            @else bg-red-900/30 text-red-400 @endif">
                            {{ ucfirst($driver->status) }}
                        </span>
                        <p class="text-red-100 text-sm">Driver ID: #{{ $driver->id }}</p>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-slate-400 text-sm mb-1">Phone</p>
                            <p class="text-white font-semibold">{{ $driver->phone }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm mb-1">License Number</p>
                            <p class="text-white font-semibold font-mono">{{ $driver->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm mb-1">License Plate</p>
                            <p class="text-white font-semibold font-mono">{{ $driver->license_plate }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm mb-1">License Expiry</p>
                            <p class="text-white font-semibold">{{ $driver->license_expiry ? $driver->license_expiry->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    @if($driver->address)
                    <div class="pt-4 border-t border-slate-800">
                        <p class="text-slate-400 text-sm mb-1">Address</p>
                        <p class="text-white">{{ $driver->address }}</p>
                    </div>
                    @endif

                    <div class="pt-4 border-t border-slate-800">
                        <p class="text-slate-400 text-sm mb-2">Created</p>
                        <p class="text-white text-sm">{{ $driver->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="bg-slate-800/50 px-6 py-4 flex gap-3">
                    <a href="{{ route('drivers.edit', $driver) }}" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('drivers.destroy', $driver) }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="space-y-6">
            <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
                <h3 class="text-lg font-bold text-white mb-4">
                    <i class="fas fa-bar-chart text-blue-600"></i> Statistics
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-slate-400 text-sm">Total Trips</p>
                        <p class="text-2xl font-bold text-white">{{ $driver->trips->count() }}</p>
                    </div>
                    <div class="pt-3 border-t border-slate-800">
                        <p class="text-slate-400 text-sm">Completed Trips</p>
                        <p class="text-2xl font-bold text-green-400">{{ $driver->trips->where('status', 'completed')->count() }}</p>
                    </div>
                    <div class="pt-3 border-t border-slate-800">
                        <p class="text-slate-400 text-sm">Total Distance</p>
                        <p class="text-2xl font-bold text-white">{{ number_format($driver->trips->sum('distance_traveled'), 2) }} km</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
                <h3 class="text-lg font-bold text-white mb-4">
                    <i class="fas fa-quick-stats text-purple-600"></i> Quick Actions
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('trips.create') }}" class="block bg-red-600 hover:bg-red-700 text-white text-center py-2 rounded-lg transition text-sm font-medium">
                        <i class="fas fa-plus"></i> New Trip
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Trips -->
    @if($driver->trips && count($driver->trips) > 0)
    <div class="mt-8 bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
        <div class="bg-slate-800 px-6 py-4">
            <h2 class="text-xl font-bold text-white">
                <i class="fas fa-list"></i> Recent Trips
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-800 border-b border-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-slate-300">Trip ID</th>
                        <th class="px-6 py-3 text-left text-slate-300">Vehicle</th>
                        <th class="px-6 py-3 text-left text-slate-300">Route</th>
                        <th class="px-6 py-3 text-left text-slate-300">Status</th>
                        <th class="px-6 py-3 text-left text-slate-300">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($driver->trips->sortByDesc('departure_time')->take(10) as $trip)
                    <tr class="border-b border-slate-800 hover:bg-slate-800/50">
                        <td class="px-6 py-3 text-white font-medium">#{{ $trip->id }}</td>
                        <td class="px-6 py-3 text-slate-300">{{ $trip->vehicle->plate_number }}</td>
                        <td class="px-6 py-3 text-slate-300">{{ $trip->route->name }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-block px-3 py-1 rounded text-xs font-medium
                                @if($trip->status === 'completed') bg-green-900/30 text-green-400
                                @elseif($trip->status === 'in_progress') bg-yellow-900/30 text-yellow-400
                                @else bg-blue-900/30 text-blue-400 @endif">
                                {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-slate-400 text-sm">{{ $trip->departure_time->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

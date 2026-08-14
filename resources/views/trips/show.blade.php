@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('trips.index') }}" class="text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left"></i> Back to Trips
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Trip Info -->
        <div class="lg:col-span-2">
            <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-600 to-yellow-800 px-6 py-6">
                    <h1 class="text-3xl font-bold text-white mb-2">Trip #{{ $trip->id }}</h1>
                    <div class="flex gap-4">
                        <span class="inline-block px-3 py-1 rounded text-xs font-medium
                            @if($trip->status === 'completed') bg-green-900/30 text-green-400
                            @elseif($trip->status === 'in_progress') bg-yellow-900/30 text-yellow-400
                            @elseif($trip->status === 'planned') bg-blue-900/30 text-blue-400
                            @else bg-red-900/30 text-red-400 @endif">
                            {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Trip Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-info-circle text-yellow-600"></i> Trip Details
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Driver</p>
                                <p class="text-white font-semibold">{{ $trip->driver->name }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Vehicle</p>
                                <p class="text-white font-semibold">{{ $trip->vehicle->plate_number }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Route</p>
                                <p class="text-white font-semibold">{{ $trip->route->name }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Passengers</p>
                                <p class="text-white font-semibold">{{ $trip->passengers }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Times -->
                    <div class="border-t border-slate-800 pt-6">
                        <h3 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-clock text-yellow-600"></i> Schedule
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Departure</p>
                                <p class="text-white font-semibold">{{ $trip->departure_time->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($trip->arrival_time)
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Arrival</p>
                                <p class="text-white font-semibold">{{ $trip->arrival_time->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Fuel & Distance -->
                    @if($trip->status === 'completed')
                    <div class="border-t border-slate-800 pt-6">
                        <h3 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-gas-pump text-yellow-600"></i> Trip Metrics
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Distance Traveled</p>
                                <p class="text-white font-semibold">{{ $trip->distance_traveled ?? 'N/A' }} km</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Fuel Used</p>
                                <p class="text-white font-semibold">{{ $trip->fuel_used ?? 'N/A' }} L</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($trip->notes)
                    <div class="border-t border-slate-800 pt-6">
                        <p class="text-slate-400 text-sm mb-2">Notes</p>
                        <p class="text-white">{{ $trip->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="bg-slate-800/50 px-6 py-4 flex gap-3">
                    @if($trip->status === 'planned')
                    <form action="{{ route('trips.start', $trip) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition">
                            <i class="fas fa-play"></i> Start Trip
                        </button>
                    </form>
                    @endif
                    @if($trip->status !== 'completed')
                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-lg transition">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Checkins -->
        <div>
            <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
                <h3 class="text-lg font-bold text-white mb-4">
                    <i class="fas fa-map-marker-alt text-purple-600"></i> Check-ins
                </h3>
                @if($trip->checkins && count($trip->checkins) > 0)
                <div class="space-y-3">
                    @foreach($trip->checkins->sortByDesc('checked_at') as $checkin)
                    <div class="bg-slate-800/50 rounded p-3 text-sm">
                        <p class="text-white font-semibold">{{ $checkin->location_name }}</p>
                        <p class="text-slate-400 text-xs">{{ $checkin->checked_at->format('H:i') }}</p>
                        @if($checkin->fuel_level)
                        <p class="text-slate-400 text-xs">Fuel: {{ $checkin->fuel_level }}%</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-slate-400 text-sm text-center py-4">No check-ins recorded</p>
                @endif
            </div>

            <!-- Expenses -->
            <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 mt-6">
                <h3 class="text-lg font-bold text-white mb-4">
                    <i class="fas fa-money-bill text-orange-600"></i> Expenses
                </h3>
                @if($trip->expenses && count($trip->expenses) > 0)
                <div class="space-y-3">
                    @foreach($trip->expenses as $expense)
                    <div class="bg-slate-800/50 rounded p-3 text-sm">
                        <p class="text-white font-semibold">{{ ucfirst($expense->expense_type) }}</p>
                        <p class="text-orange-400 font-bold">{{ number_format($expense->amount, 0, ',', '.') }} VNĐ</p>
                    </div>
                    @endforeach
                    <div class="bg-orange-900/20 border border-orange-600 rounded p-3 mt-3">
                        <p class="text-orange-400 font-semibold">
                            Total: {{ number_format($trip->expenses->sum('amount'), 0, ',', '.') }} VNĐ
                        </p>
                    </div>
                </div>
                @else
                <p class="text-slate-400 text-sm text-center py-4">No expenses recorded</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

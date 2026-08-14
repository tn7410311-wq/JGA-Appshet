@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Trips Management</h1>
        <a href="{{ route('trips.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus"></i> Create New Trip
        </a>
    </div>

    @if($trips && count($trips) > 0)
    <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-800 border-b border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Trip ID</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Driver</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Vehicle</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Route</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Departure</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                    <tr class="border-b border-slate-800 hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4 text-white font-medium">#{{ $trip->id }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ $trip->driver->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ $trip->vehicle->plate_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ $trip->route->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded text-xs font-medium
                                @if($trip->status === 'completed') bg-green-900/30 text-green-400
                                @elseif($trip->status === 'in_progress') bg-yellow-900/30 text-yellow-400
                                @elseif($trip->status === 'planned') bg-blue-900/30 text-blue-400
                                @else bg-red-900/30 text-red-400 @endif">
                                {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">{{ $trip->departure_time->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('trips.show', $trip) }}" class="text-blue-400 hover:text-blue-300 text-sm transition" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($trip->status === 'planned')
                            <form action="{{ route('trips.start', $trip) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-400 hover:text-green-300 text-sm transition" title="Start">
                                    <i class="fas fa-play"></i>
                                </button>
                            </form>
                            @endif
                            @if($trip->status === 'in_progress')
                            <a href="{{ route('trips.show', $trip) }}" class="text-yellow-400 hover:text-yellow-300 text-sm transition" title="End trip">
                                <i class="fas fa-stop"></i>
                            </a>
                            @endif
                            <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-400 hover:text-red-300 text-sm transition" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $trips->links('pagination::tailwind') }}
    </div>
    @else
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-12 text-center">
        <i class="fas fa-route text-4xl text-slate-700 mb-4"></i>
        <p class="text-slate-400 mb-6">No trips found. Create your first trip to get started.</p>
        <a href="{{ route('trips.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
            <i class="fas fa-plus"></i> Create First Trip
        </a>
    </div>
    @endif
</div>
@endsection

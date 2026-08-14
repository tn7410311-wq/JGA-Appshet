@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Vehicles Management</h1>
        <a href="{{ route('vehicles.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus"></i> Add New Vehicle
        </a>
    </div>

    @if($vehicles && count($vehicles) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($vehicles as $vehicle)
        <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden hover:border-red-600 transition">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h3 class="text-lg font-bold text-white">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                <p class="text-blue-200 text-sm">{{ $vehicle->vehicle_type }} • Year: {{ $vehicle->year }}</p>
            </div>
            <div class="p-6 space-y-3">
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-hashtag w-5 text-blue-600"></i>
                    <span class="ml-3 font-mono text-white">{{ $vehicle->plate_number }}</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-gauge-high w-5 text-blue-600"></i>
                    <span class="ml-3">Capacity: {{ $vehicle->capacity }}</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-gas-pump w-5 text-blue-600"></i>
                    <span class="ml-3">{{ $vehicle->fuel_capacity }}L • {{ $vehicle->fuel_consumption }}L/100km</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-palette w-5 text-blue-600"></i>
                    <span class="ml-3">{{ $vehicle->color ?? 'N/A' }}</span>
                </div>
                <div class="pt-3 border-t border-slate-800 mt-3">
                    <span class="inline-block px-3 py-1 rounded text-xs font-medium
                        @if($vehicle->status === 'active') bg-green-900/30 text-green-400
                        @elseif($vehicle->status === 'maintenance') bg-yellow-900/30 text-yellow-400
                        @else bg-red-900/30 text-red-400 @endif">
                        {{ ucfirst($vehicle->status) }}
                    </span>
                </div>
            </div>
            <div class="bg-slate-800/50 px-6 py-3 flex gap-3">
                <a href="{{ route('vehicles.show', $vehicle) }}" class="flex-1 text-center text-blue-400 hover:text-blue-300 text-sm font-medium transition">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('vehicles.edit', $vehicle) }}" class="flex-1 text-center text-yellow-400 hover:text-yellow-300 text-sm font-medium transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')" class="w-full text-red-400 hover:text-red-300 text-sm font-medium transition">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $vehicles->links('pagination::tailwind') }}
    </div>
    @else
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-12 text-center">
        <i class="fas fa-car text-4xl text-slate-700 mb-4"></i>
        <p class="text-slate-400 mb-6">No vehicles found. Add your first vehicle to get started.</p>
        <a href="{{ route('vehicles.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
            <i class="fas fa-plus"></i> Add First Vehicle
        </a>
    </div>
    @endif
</div>
@endsection

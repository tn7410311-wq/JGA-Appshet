@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Routes Management</h1>
        <a href="{{ route('routes.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus"></i> Add New Route
        </a>
    </div>

    @if($routes && count($routes) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($routes as $route)
        <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden hover:border-red-600 transition">
            <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4">
                <h3 class="text-lg font-bold text-white">{{ $route->name }}</h3>
                <p class="text-green-200 text-sm">Code: {{ $route->code }}</p>
            </div>
            <div class="p-6 space-y-3">
                <div class="flex items-start text-slate-300 text-sm">
                    <i class="fas fa-map-pin w-5 text-green-600 mt-1"></i>
                    <div class="ml-3">
                        <p class="font-medium">From: {{ $route->start_location }}</p>
                        <p>To: {{ $route->end_location }}</p>
                    </div>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-road w-5 text-green-600"></i>
                    <span class="ml-3">Distance: {{ number_format($route->distance, 2) }} km</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-clock w-5 text-green-600"></i>
                    <span class="ml-3">Est. Time: {{ $route->estimated_time }} min</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-money-bill w-5 text-green-600"></i>
                    <span class="ml-3">Fuel Cost: {{ number_format($route->standard_fuel_cost, 0, ',', '.') }} VNĐ</span>
                </div>
                <div class="pt-3 border-t border-slate-800 mt-3">
                    <span class="inline-block px-3 py-1 rounded text-xs font-medium
                        @if($route->status === 'active') bg-green-900/30 text-green-400
                        @else bg-slate-900/30 text-slate-400 @endif">
                        {{ ucfirst($route->status) }}
                    </span>
                </div>
            </div>
            <div class="bg-slate-800/50 px-6 py-3 flex gap-3">
                <a href="{{ route('routes.show', $route) }}" class="flex-1 text-center text-blue-400 hover:text-blue-300 text-sm font-medium transition">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('routes.edit', $route) }}" class="flex-1 text-center text-yellow-400 hover:text-yellow-300 text-sm font-medium transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('routes.destroy', $route) }}" method="POST" class="flex-1">
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
        {{ $routes->links('pagination::tailwind') }}
    </div>
    @else
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-12 text-center">
        <i class="fas fa-map text-4xl text-slate-700 mb-4"></i>
        <p class="text-slate-400 mb-6">No routes found. Create your first route to get started.</p>
        <a href="{{ route('routes.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
            <i class="fas fa-plus"></i> Add First Route
        </a>
    </div>
    @endif
</div>
@endsection

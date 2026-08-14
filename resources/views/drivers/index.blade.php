@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Drivers Management</h1>
        <a href="{{ route('drivers.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus"></i> Add New Driver
        </a>
    </div>

    @if($drivers && count($drivers) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($drivers as $driver)
        <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden hover:border-red-600 transition">
            <div class="bg-gradient-to-r from-red-600 to-red-800 px-6 py-4">
                <h3 class="text-lg font-bold text-white">{{ $driver->name }}</h3>
            </div>
            <div class="p-6 space-y-3">
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-phone w-5 text-red-600"></i>
                    <span class="ml-3">{{ $driver->phone }}</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-id-card w-5 text-red-600"></i>
                    <span class="ml-3">{{ $driver->license_number }}</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-car w-5 text-red-600"></i>
                    <span class="ml-3">{{ $driver->license_plate }}</span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <i class="fas fa-calendar w-5 text-red-600"></i>
                    <span class="ml-3">License: {{ $driver->license_expiry ? $driver->license_expiry->format('d/m/Y') : 'N/A' }}</span>
                </div>
                <div class="pt-3 border-t border-slate-800 mt-3">
                    <span class="inline-block px-3 py-1 rounded text-xs font-medium
                        @if($driver->status === 'active') bg-green-900/30 text-green-400
                        @elseif($driver->status === 'inactive') bg-slate-900/30 text-slate-400
                        @else bg-red-900/30 text-red-400 @endif">
                        {{ ucfirst($driver->status) }}
                    </span>
                </div>
            </div>
            <div class="bg-slate-800/50 px-6 py-3 flex gap-3">
                <a href="{{ route('drivers.show', $driver) }}" class="flex-1 text-center text-blue-400 hover:text-blue-300 text-sm font-medium transition">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('drivers.edit', $driver) }}" class="flex-1 text-center text-yellow-400 hover:text-yellow-300 text-sm font-medium transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('drivers.destroy', $driver) }}" method="POST" class="flex-1">
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
        {{ $drivers->links('pagination::tailwind') }}
    </div>
    @else
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-12 text-center">
        <i class="fas fa-users text-4xl text-slate-700 mb-4"></i>
        <p class="text-slate-400 mb-6">No drivers found. Create your first driver to get started.</p>
        <a href="{{ route('drivers.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
            <i class="fas fa-plus"></i> Add First Driver
        </a>
    </div>
    @endif
</div>
@endsection

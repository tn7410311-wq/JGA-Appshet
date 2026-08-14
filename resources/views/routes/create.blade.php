@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center mb-8">
        <a href="{{ route('routes.index') }}" class="text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left"></i> Back to Routes
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
        <h1 class="text-3xl font-bold text-white mb-8">
            <i class="fas fa-plus-circle text-green-600"></i> Add New Route
        </h1>

        @if ($errors->any())
        <div class="bg-red-900/30 border border-red-600 rounded-lg p-4 mb-6">
            <p class="text-red-400 font-semibold mb-2">Please fix the following errors:</p>
            <ul class="text-red-400 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('routes.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-heading text-green-600"></i> Route Name *
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition"
                    placeholder="Hanoi - Haiphong">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Code -->
            <div>
                <label for="code" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-barcode text-green-600"></i> Route Code *
                </label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition font-mono uppercase"
                    placeholder="HN-HP-001">
                @error('code') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Start Location -->
            <div>
                <label for="start_location" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-map-pin text-green-600"></i> Start Location *
                </label>
                <input type="text" id="start_location" name="start_location" value="{{ old('start_location') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition"
                    placeholder="Ha Noi Terminal">
                @error('start_location') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- End Location -->
            <div>
                <label for="end_location" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-map-pin text-green-600"></i> End Location *
                </label>
                <input type="text" id="end_location" name="end_location" value="{{ old('end_location') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition"
                    placeholder="Haiphong Port">
                @error('end_location') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Distance -->
                <div>
                    <label for="distance" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-road text-green-600"></i> Distance (km) *
                    </label>
                    <input type="number" id="distance" name="distance" value="{{ old('distance') }}" step="0.1" min="1" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition"
                        placeholder="120">
                    @error('distance') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Estimated Time -->
                <div>
                    <label for="estimated_time" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-clock text-green-600"></i> Est. Time (min) *
                    </label>
                    <input type="number" id="estimated_time" name="estimated_time" value="{{ old('estimated_time') }}" min="1" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition"
                        placeholder="180">
                    @error('estimated_time') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Standard Fuel Cost -->
            <div>
                <label for="standard_fuel_cost" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-money-bill text-green-600"></i> Standard Fuel Cost (VNĐ) *
                </label>
                <input type="number" id="standard_fuel_cost" name="standard_fuel_cost" value="{{ old('standard_fuel_cost') }}" step="1000" min="0" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition"
                    placeholder="500000">
                @error('standard_fuel_cost') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-note-sticky text-green-600"></i> Description
                </label>
                <textarea id="description" name="description" rows="3"
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-green-600 focus:outline-none transition"
                    placeholder="Route details...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-slate-800">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    <i class="fas fa-save"></i> Create Route
                </button>
                <a href="{{ route('routes.index') }}" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-6 rounded-lg text-center transition">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

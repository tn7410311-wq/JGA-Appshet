@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center mb-8">
        <a href="{{ route('trips.index') }}" class="text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left"></i> Back to Trips
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
        <h1 class="text-3xl font-bold text-white mb-8">
            <i class="fas fa-route text-yellow-600"></i> Create New Trip
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

        <form action="{{ route('trips.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- Driver -->
                <div>
                    <label for="driver_id" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-user text-yellow-600"></i> Driver *
                    </label>
                    <select id="driver_id" name="driver_id" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-yellow-600 focus:outline-none transition">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }} ({{ $driver->phone }})
                        </option>
                        @endforeach
                    </select>
                    @error('driver_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Vehicle -->
                <div>
                    <label for="vehicle_id" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-car text-yellow-600"></i> Vehicle *
                    </label>
                    <select id="vehicle_id" name="vehicle_id" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-yellow-600 focus:outline-none transition">
                        <option value="">Select Vehicle</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}
                        </option>
                        @endforeach
                    </select>
                    @error('vehicle_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Route -->
                <div class="col-span-2">
                    <label for="route_id" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-map-pin text-yellow-600"></i> Route *
                    </label>
                    <select id="route_id" name="route_id" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-yellow-600 focus:outline-none transition">
                        <option value="">Select Route</option>
                        @foreach($routes as $route)
                        <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                            {{ $route->name }} ({{ $route->distance }}km)
                        </option>
                        @endforeach
                    </select>
                    @error('route_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Departure Time -->
                <div>
                    <label for="departure_time" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-clock text-yellow-600"></i> Departure Time *
                    </label>
                    <input type="datetime-local" id="departure_time" name="departure_time" value="{{ old('departure_time') }}" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-yellow-600 focus:outline-none transition">
                    @error('departure_time') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Passengers -->
                <div>
                    <label for="passengers" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-users text-yellow-600"></i> Passengers
                    </label>
                    <input type="number" id="passengers" name="passengers" value="{{ old('passengers', 0) }}" min="0"
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-yellow-600 focus:outline-none transition"
                        placeholder="0">
                    @error('passengers') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-note-sticky text-yellow-600"></i> Notes
                </label>
                <textarea id="notes" name="notes" rows="3"
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-yellow-600 focus:outline-none transition"
                    placeholder="Additional notes for this trip...">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-slate-800">
                <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    <i class="fas fa-save"></i> Create Trip
                </button>
                <a href="{{ route('trips.index') }}" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-6 rounded-lg text-center transition">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

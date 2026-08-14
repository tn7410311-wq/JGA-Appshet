@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center mb-8">
        <a href="{{ route('vehicles.index') }}" class="text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left"></i> Back to Vehicles
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
        <h1 class="text-3xl font-bold text-white mb-8">
            <i class="fas fa-car text-blue-600"></i> Add New Vehicle
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

        <form action="{{ route('vehicles.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-tag text-blue-600"></i> Brand *
                    </label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition"
                        placeholder="Toyota">
                    @error('brand') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Model -->
                <div>
                    <label for="model" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-cube text-blue-600"></i> Model *
                    </label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition"
                        placeholder="Innova">
                    @error('model') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Vehicle Type -->
                <div>
                    <label for="vehicle_type" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-shuttle-van text-blue-600"></i> Vehicle Type *
                    </label>
                    <select id="vehicle_type" name="vehicle_type" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-blue-600 focus:outline-none transition">
                        <option value="">Select Type</option>
                        <option value="Car" {{ old('vehicle_type') === 'Car' ? 'selected' : '' }}>Car</option>
                        <option value="Van" {{ old('vehicle_type') === 'Van' ? 'selected' : '' }}>Van</option>
                        <option value="Truck" {{ old('vehicle_type') === 'Truck' ? 'selected' : '' }}>Truck</option>
                        <option value="Bus" {{ old('vehicle_type') === 'Bus' ? 'selected' : '' }}>Bus</option>
                    </select>
                    @error('vehicle_type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Year -->
                <div>
                    <label for="year" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-calendar-alt text-blue-600"></i> Year *
                    </label>
                    <input type="number" id="year" name="year" value="{{ old('year') }}" min="2000" max="{{ date('Y') }}" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition"
                        placeholder="2023">
                    @error('year') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Plate Number -->
                <div>
                    <label for="plate_number" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-hashtag text-blue-600"></i> Plate Number *
                    </label>
                    <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number') }}" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition font-mono"
                        placeholder="29A123456">
                    @error('plate_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Capacity -->
                <div>
                    <label for="capacity" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-users text-blue-600"></i> Capacity *
                    </label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition"
                        placeholder="5">
                    @error('capacity') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-palette text-blue-600"></i> Color
                    </label>
                    <input type="text" id="color" name="color" value="{{ old('color') }}"
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition"
                        placeholder="White">
                    @error('color') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Fuel Capacity -->
                <div>
                    <label for="fuel_capacity" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-gas-pump text-blue-600"></i> Fuel Capacity (L) *
                    </label>
                    <input type="number" id="fuel_capacity" name="fuel_capacity" value="{{ old('fuel_capacity') }}" step="0.1" min="1" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition"
                        placeholder="50">
                    @error('fuel_capacity') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Fuel Consumption -->
                <div>
                    <label for="fuel_consumption" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-oil-can text-blue-600"></i> Fuel Consumption (L/100km) *
                    </label>
                    <input type="number" id="fuel_consumption" name="fuel_consumption" value="{{ old('fuel_consumption') }}" step="0.1" min="1" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-blue-600 focus:outline-none transition"
                        placeholder="8">
                    @error('fuel_consumption') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-slate-800">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    <i class="fas fa-save"></i> Create Vehicle
                </button>
                <a href="{{ route('vehicles.index') }}" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-6 rounded-lg text-center transition">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

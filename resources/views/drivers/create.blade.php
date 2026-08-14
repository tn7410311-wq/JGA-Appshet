@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center mb-8">
        <a href="{{ route('drivers.index') }}" class="text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left"></i> Back to Drivers
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
        <h1 class="text-3xl font-bold text-white mb-8">
            <i class="fas fa-user-plus text-red-600"></i> Add New Driver
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

        <form action="{{ route('drivers.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-user text-red-600"></i> Full Name *
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-red-600 focus:outline-none transition @error('name') border-red-600 @enderror"
                    placeholder="John Doe">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-phone text-red-600"></i> Phone Number *
                </label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-red-600 focus:outline-none transition @error('phone') border-red-600 @enderror"
                    placeholder="0123456789">
                @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- License Number -->
            <div>
                <label for="license_number" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-id-card text-red-600"></i> License Number *
                </label>
                <input type="text" id="license_number" name="license_number" value="{{ old('license_number') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-red-600 focus:outline-none transition @error('license_number') border-red-600 @enderror"
                    placeholder="A000000">
                @error('license_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- License Plate -->
            <div>
                <label for="license_plate" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-car text-red-600"></i> License Plate *
                </label>
                <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-red-600 focus:outline-none transition @error('license_plate') border-red-600 @enderror"
                    placeholder="29A123456">
                @error('license_plate') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-map-pin text-red-600"></i> Address
                </label>
                <textarea id="address" name="address" rows="2"
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-red-600 focus:outline-none transition @error('address') border-red-600 @enderror"
                    placeholder="123 Main Street, City">{{ old('address') }}</textarea>
                @error('address') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- License Expiry -->
            <div>
                <label for="license_expiry" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-calendar text-red-600"></i> License Expiry Date
                </label>
                <input type="date" id="license_expiry" name="license_expiry" value="{{ old('license_expiry') }}"
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-red-600 focus:outline-none transition @error('license_expiry') border-red-600 @enderror">
                @error('license_expiry') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-slate-800">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    <i class="fas fa-save"></i> Create Driver
                </button>
                <a href="{{ route('drivers.index') }}" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-6 rounded-lg text-center transition">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

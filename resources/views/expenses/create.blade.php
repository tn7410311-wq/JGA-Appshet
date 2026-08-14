@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center mb-8">
        <a href="{{ route('expenses.index') }}" class="text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left"></i> Back to Expenses
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
        <h1 class="text-3xl font-bold text-white mb-8">
            <i class="fas fa-receipt text-purple-600"></i> Record Expense
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

        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- Vehicle -->
                <div>
                    <label for="vehicle_id" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-car text-purple-600"></i> Vehicle *
                    </label>
                    <select id="vehicle_id" name="vehicle_id" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-purple-600 focus:outline-none transition">
                        <option value="">Select Vehicle</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->plate_number }}
                        </option>
                        @endforeach
                    </select>
                    @error('vehicle_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Expense Type -->
                <div>
                    <label for="expense_type" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-tag text-purple-600"></i> Expense Type *
                    </label>
                    <select id="expense_type" name="expense_type" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-purple-600 focus:outline-none transition">
                        <option value="">Select Type</option>
                        <option value="fuel" {{ old('expense_type') === 'fuel' ? 'selected' : '' }}>Fuel</option>
                        <option value="maintenance" {{ old('expense_type') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="tolls" {{ old('expense_type') === 'tolls' ? 'selected' : '' }}>Tolls</option>
                        <option value="parking" {{ old('expense_type') === 'parking' ? 'selected' : '' }}>Parking</option>
                        <option value="other" {{ old('expense_type') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('expense_type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Expense Date -->
                <div>
                    <label for="expense_date" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-calendar text-purple-600"></i> Expense Date *
                    </label>
                    <input type="date" id="expense_date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-purple-600 focus:outline-none transition">
                    @error('expense_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-slate-300 font-medium mb-2">
                        <i class="fas fa-money-bill text-purple-600"></i> Amount (VNĐ) *
                    </label>
                    <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="1000" min="0" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-purple-600 focus:outline-none transition"
                        placeholder="500000">
                    @error('amount') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-note-sticky text-purple-600"></i> Description *
                </label>
                <textarea id="description" name="description" rows="2" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-purple-600 focus:outline-none transition"
                    placeholder="Description of the expense...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Receipt Number -->
            <div>
                <label for="receipt_number" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-hashtag text-purple-600"></i> Receipt Number
                </label>
                <input type="text" id="receipt_number" name="receipt_number" value="{{ old('receipt_number') }}"
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-purple-600 focus:outline-none transition"
                    placeholder="Optional receipt number">
                @error('receipt_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-slate-300 font-medium mb-2">
                    <i class="fas fa-comment text-purple-600"></i> Notes
                </label>
                <textarea id="notes" name="notes" rows="2"
                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white placeholder-slate-500 focus:border-purple-600 focus:outline-none transition"
                    placeholder="Additional notes...">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-slate-800">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    <i class="fas fa-save"></i> Record Expense
                </button>
                <a href="{{ route('expenses.index') }}" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-6 rounded-lg text-center transition">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

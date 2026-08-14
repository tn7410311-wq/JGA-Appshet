@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Expenses Management</h1>
        <a href="{{ route('expenses.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus"></i> Record Expense
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <p class="text-slate-400 text-sm font-medium mb-2">Total Expenses</p>
            <p class="text-2xl font-bold text-white">{{ number_format($expenses->sum('amount') ?? 0, 0, ',', '.') }} VNĐ</p>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <p class="text-slate-400 text-sm font-medium mb-2">This Month</p>
            <p class="text-2xl font-bold text-white">{{ number_format(0, 0, ',', '.') }} VNĐ</p>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
            <p class="text-slate-400 text-sm font-medium mb-2">Avg. per Trip</p>
            <p class="text-2xl font-bold text-white">{{ number_format(0, 0, ',', '.') }} VNĐ</p>
        </div>
    </div>

    <!-- Expenses Table -->
    @if($expenses && count($expenses) > 0)
    <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-800 border-b border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Date</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Type</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Vehicle</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Description</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Amount</th>
                        <th class="px-6 py-4 text-left text-slate-300 font-semibold">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr class="border-b border-slate-800 hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4 text-slate-300">{{ $expense->expense_date->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded text-xs font-medium
                                @if($expense->expense_type === 'fuel') bg-orange-900/30 text-orange-400
                                @elseif($expense->expense_type === 'maintenance') bg-blue-900/30 text-blue-400
                                @else bg-slate-900/30 text-slate-400 @endif">
                                {{ ucfirst($expense->expense_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-300">{{ $expense->vehicle->plate_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ Str::limit($expense->description, 30) }}</td>
                        <td class="px-6 py-4 text-white font-semibold">{{ number_format($expense->amount, 0, ',', '.') }} VNĐ</td>
                        <td class="px-6 py-4 text-slate-400 text-xs">{{ $expense->receipt_number ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $expenses->links('pagination::tailwind') }}
    </div>
    @else
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-12 text-center">
        <i class="fas fa-receipt text-4xl text-slate-700 mb-4"></i>
        <p class="text-slate-400 mb-6">No expenses recorded yet.</p>
        <a href="{{ route('expenses.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
            <i class="fas fa-plus"></i> Record First Expense
        </a>
    </div>
    @endif
</div>
@endsection

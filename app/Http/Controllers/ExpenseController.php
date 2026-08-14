<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['trip', 'vehicle', 'driver'])
                           ->paginate(20);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $trips = Trip::where('status', 'completed')->get();
        return view('expenses.create', compact('vehicles', 'trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'nullable|exists:trips,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'expense_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'receipt_number' => 'nullable|string',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Expense::create($validated);
        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully');
    }

    public function report()
    {
        $totalExpenses = Expense::sum('amount');
        $fuelExpenses = Expense::where('expense_type', 'fuel')->sum('amount');
        $maintenanceExpenses = Expense::where('expense_type', 'maintenance')->sum('amount');
        
        $monthlyExpenses = Expense::selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
                                 ->groupByRaw('MONTH(expense_date)')
                                 ->get();

        return view('expenses.report', compact('totalExpenses', 'fuelExpenses', 'maintenanceExpenses', 'monthlyExpenses'));
    }
}

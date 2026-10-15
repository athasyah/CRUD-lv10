<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with('activity')->get();
        $activities = Activity::all();
        return view('expenses.index', compact('expenses', 'activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activities = Activity::all();
        return view('expenses.create', compact('activities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
         
   'activity_id' => 'required|exists:activities,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
        // $totalActivityCost = Activity::whereHas('destination', function ($query) use ($trip) {
        //     $query->where('trip_id', $trip->id);
        // })->sum('cost');

        $activity = Activity::findOrFail($request->activity_id);

        // $totalExpenseCost = Expense::where('activity_id', function ($query) use ($activity) {
        //     $query->where('activity_id', $activity->id);
        // })->sum('amount');

        $totalExpenseCost = Expense::where('activity_id', $activity->id)->sum('amount');

        $newTotalExpense = $totalExpenseCost + $request->amount;

        $existingExpense = Expense::whereHas('activity', function ($query) use ($activity) {
            $query->where('destination_id', $activity->destination->id);
        })->exists();

        if ($existingExpense) {
            return redirect()->back()->withErrors(['activity_id' => 'Destinasi ini sudah memiliki pengeluaran!'])->withInput();
        }

        if ($newTotalExpense > $activity->cost) {
            return redirect()->back()->withErrors(['amount' => 'Total biaya pengeluaran melebihi anggaran Destinasi!'])->withInput();
        }
        $expense = new Expense();
        $expense->description = $validated['description'];
        $expense->amount = $validated['amount'];
        $expense->activity_id = $validated['activity_id'];


        $expense->save();
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $activities = Activity::all();
        return view('expenses.edit', compact('expense', 'activities'));

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0'

        ]);

        $activity = Activity::findOrFail($request->activity_id);

        $totalExpenseCost = Expense::where('activity_id', $activity->id)->sum('amount');


        if ($totalExpenseCost > $activity->cost) {
            return redirect()->back()->withErrors(['amount' => 'Total biaya pengeluaran melebihi anggaran Destinasi!'])->withInput();
        }

        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus');
    }
}

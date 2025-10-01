<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
class ExpensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::orderBy('id', 'desc')->get();
        return view('expens.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('expens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Expense::create($request->only(['description','price','date']));

        return redirect()->route('expenses.index')
                        ->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);
        $expense = Expense::findOrFail($id);
        $expense->update($request->only(['description','price','date']));
        return redirect()->route('expenses.index')
                        ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect()->route('expenses.index')
                        ->with('success', 'Expense deleted successfully.');
    }
}

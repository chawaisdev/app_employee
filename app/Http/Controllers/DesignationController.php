<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designation = Designation::all();
        return view('designation.index', compact('designation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Designation::create([
            'name' => $request->name,
        ]);

        return redirect()->route('designation.index')->with('success', 'Designation created successfully.');
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
        $designation = Designation::findOrFail($id);
        return view('designation.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $designation = Designation::findOrFail($id);
        $designation->update([
            'name' => $request->name,
        ]);

        return redirect()->route('designation.index')->with('success', 'Designation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return redirect()->route('designation.index')->with('success', 'Designation deleted successfully.');
    }
}

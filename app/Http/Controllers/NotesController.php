<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note; // Assuming you have a Note model
class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::all(); // Fetch all notes from the database
        return view('note.index', compact('notes')); // Assuming you have a view to display notes
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('note.create'); // Assuming you have a view for creating a note
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('notes', 'public'); 
            }
        }

        Note::create([
            'content' => $request->content,
            'images' => json_encode($imagePaths),
        ]);
        return redirect()->back()->with('success', 'Note added successfully!');
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
        $note = Note::findOrFail($id);
        return view('note.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'content' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'existing_images' => 'array'
        ]);

        $note = Note::findOrFail($id);

        // Get kept existing images
        $imagePaths = $request->existing_images ?? []; // only keeps the images not removed

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePaths[] = $image->store('notes', 'public'); // add new uploaded images
        }
    }

    $note->update([
        'content' => $request->content,
        'images' => json_encode($imagePaths),
    ]);


        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

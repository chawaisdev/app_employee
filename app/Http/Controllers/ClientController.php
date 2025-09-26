<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    // Retrieve all users and pass them to the adduser index blade view
    public function index(Request $request)
    {
        $users = User::all()
        ->where('user_type', 'client');
        return view('client.index', compact('users'));
    }

    // Return the create user form where admin can input user details
    public function create()
    {
        return view('client.create');
    }

    // Validate and store new user details including hashed password into database

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:15|unique:users,phone_number',
        ]);

        // Create user
        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'user_type'    => 'client',
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('client.create')->with('success', 'Client added successfully.');
    }



    // Fetch user by ID and show it in the edit form for updating
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('client.edit', compact('user'));
    }

    // Validate and update the user details including optional password update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $id,
            'password'     => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('client.index')->with('success', 'Client updated successfully.');
    }


    // Find the user by ID and delete the user from the database
    public function destroy($id)
    {
        $adduser = User::findOrFail($id);
        $adduser->delete();

        return redirect()->route('client.index')->with('success', 'Client deleted successfully.');
    }


    public function clientTaskindex(Request $request)
    {
        $user = Auth::user();

        if ($user->type === 'admin') {
            $projects = Project::all();
            $tasks = Task::query()
                ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))
                ->when($request->project_id, fn($q) => $q->where('project_id', $request->project_id))
                ->with(['project', 'employee'])
                ->latest()
                ->get();
        } else {
            $projectId = $user->project_id;

            $projects = Project::where('id', $projectId)->get();

            $tasks = Task::query()
                ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))
                ->where('project_id', $projectId)
                ->with(['project', 'employee'])
                ->latest()
                ->get();
        }

        return view('client.index', compact('tasks', 'projects'));
    }

    public function show($id)
    {
        $task = Task::with(['project', 'employee'])->findOrFail($id);
        return view('client.show', compact('task'));
    }

}

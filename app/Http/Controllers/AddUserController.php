<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserSchedule; // Make sure this is imported

class AddUserController extends Controller
{
    // Retrieve all users and pass them to the adduser index blade view
    public function index(Request $request)
    {
        $query = User::query();
        $users = $query->paginate(10);
        return view('adduser.index', compact('users'));
    }

    // Return the create user form where admin can input user details
    public function create()
    {
        return view('adduser.create');
    }

    // Validate and store new user details including hashed password into database

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:8',
            'user_type' => 'required|string|in:admin,hr,employee',
            'phone' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|',
            'cnic' => 'nullable|numeric|',
        ]);


        // Create user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'phone' => $request->phone,
            'address' => $request->address,
            'cnic' => $request->cnic,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('adduser.create')->with('success', 'User added successfully.');
    }


    // Fetch user by ID and show it in the edit form for updating
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('adduser.edit', compact('user'));
    }

    // Validate and update the user details including optional password update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'user_type' => 'required|string|in:admin,hr,employee',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string',
            'cnic' => 'nullable|numeric',
        ]);


        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->cnic = $request->cnic;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('adduser.index')->with('success', 'User updated successfully.');
    }


    // Find the user by ID and delete the user from the database
    public function destroy($id)
    {
        $adduser = User::findOrFail($id);
        $adduser->delete();

        return redirect()->route('adduser.index')->with('success', 'User deleted successfully.');
    }

}

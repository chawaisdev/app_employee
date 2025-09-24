<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;
use App\Models\Project;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['employees', 'user'])->get();
        // dd($tasks);
        return view('task.index', compact('tasks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employeeId = auth('employee')->id();
        $projects = Project::whereHas('employees', function ($query) use ($employeeId) {
            $query->where('employee_id', $employeeId);
        })->get();

        $employees = Employee::all();

        return view('task.create', compact('projects', 'employees'));
    }



    /**
     * Store a newly created resource in storage.
     */ 
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_employees' => 'required|array',
            'assigned_employees.*' => 'exists:employees,id',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('tasks', 'public');
            }
        }

        // Task create (logged-in employee as creator)
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'images' => json_encode($imagePaths),
            'employee_id' => auth()->id(), // Logged-in employee
        ]);

        // Sync assigned employees with pivot data
        $assignedEmployees = $request->assigned_employees;
        $pivotData = [];
        foreach ($assignedEmployees as $employeeId) {
            $pivotData[$employeeId] = ['assigned_by' => auth()->id()];
        }
        $task->employees()->sync($pivotData);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
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
        $task = Task::with('user', 'users', 'project')->findOrFail($id);
        $users = User::where('id', '!=', auth()->id())->get();
        $projects = Project::all();
        return view('task.edit', compact('task', 'users', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate all required fields, including project_id
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id', // Validate project_id
            'assigned_users' => 'required|array',
            'assigned_users.*' => 'exists:users,id',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $task = Task::findOrFail($id);

        // Handle image removal
        $existingImages = $task->images ? json_decode($task->images, true) : [];
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $removeId) {
                if (isset($existingImages[$removeId])) {
                    Storage::disk('public')->delete($existingImages[$removeId]);
                    unset($existingImages[$removeId]);
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $existingImages[] = $image->store('tasks', 'public');
            }
        }

        // Update task with validated data
        $task->update([
            'title' => $request->title,
            'project_id' => $request->project_id, // Include project_id
            'description' => $request->description,
            'images' => json_encode(array_values($existingImages)),
        ]);

        // Sync assigned users with pivot data
        $assignedUsers = $request->assigned_users;
        $pivotData = [];
        foreach ($assignedUsers as $userId) {
            $pivotData[$userId] = ['assigned_by' => auth()->id()];
        }
        $task->users()->sync($pivotData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $taskId, $userId)
    {
        $request->validate([
            'status' => 'required|in:pending,doing,complete',
        ]);

        $task = Task::findOrFail($taskId);
        $task->users()->updateExistingPivot($userId, ['status' => $request->status]);

        return back()->with('success', 'Task status updated successfully.');
    }

}

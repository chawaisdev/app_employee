<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index(Request $request)
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

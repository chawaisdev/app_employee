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


    public function dashboard()
    {
        $user = Auth::user();

        if ($user->type === 'admin') {
            $totalProjects = Project::count();
            $totalTasks = Task::count();
            $completedTasks = Task::where('is_status', 'complete')->count();
            $pendingTasks = Task::where('is_status', 'pending')->count();
            $ongoingTasks = Task::where('is_status', 'ongoing')->count();
        } else {
            $projectId = $user->project_id;

            $totalProjects = Project::where('id', $projectId)->count();
            $totalTasks = Task::where('project_id', $projectId)->count();
            $completedTasks = Task::where('project_id', $projectId)->where('is_status', 'complete')->count();
            $pendingTasks = Task::where('project_id', $projectId)->where('is_status', 'pending')->count();
            $ongoingTasks = Task::where('project_id', $projectId)->where('is_status', 'ongoing')->count();
        }

        // percentage calculation
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

        return view('client.dashboard', compact(
            'totalProjects',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'ongoingTasks',
            'completionPercentage'
        ));
    }

}

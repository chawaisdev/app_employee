<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Leave;
use App\Models\Designation;
use App\Models\Task;

class DashboardController extends Controller
{
   public function index()
{
    // Counts from database
    $totalProjects    = Project::count();
    $totalEmployees   = Employee::where('user_type', 'employee')->count();
    $totalInterns     = Employee::where('user_type', 'intern')->count();
    $totalStudents    = Student::count();
    $totalLeaves      = Leave::count();
    $totalDesignations= Designation::count();
    $totalTasks       = Task::count();

    // Send to Blade
    return view('dashboard.index', compact(
        'totalProjects',
        'totalEmployees',
        'totalInterns',
        'totalStudents',
        'totalLeaves',
        'totalDesignations',
        'totalTasks'
    ));
}

}

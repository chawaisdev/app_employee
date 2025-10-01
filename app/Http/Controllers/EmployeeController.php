<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Designation;
use App\Models\Project;
use App\Models\Task;
use Auth;
use Carbon\Carbon;
use App\Mail\EmployeeRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('projects')->get();
        $projects = Project::all();

        return view('employees.index', compact('employees', 'projects'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $designations = Designation::all();
        return view('employees.create', compact('designations'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $plainPassword = $request->password;

        // ===== Common Fields =====
        $employee = new Employee();
        $employee->full_name   = $request->full_name;
        $employee->phone       = $request->phone;
        $employee->email       = $request->email;
        $employee->user_type   = $request->user_type;
        $employee->password    = Hash::make($request->password);

        // ===== Employee Fields =====
        if ($request->user_type === 'employee') {
            $employee->designation_id     = $request->designation_id;
            $employee->joining_date       = $request->joining_date;
            $employee->employment_type    = $request->employment_type;
            $employee->salary_amount      = $request->salary_amount;
            $employee->shift_name         = $request->shift_name;
            $employee->shift_start        = $request->shift_start;
            $employee->shift_end          = $request->shift_end;
            $employee->education_level    = $request->education_level;
            $employee->university_college = $request->university_college;
        }

        // ===== Intern Fields =====
        elseif ($request->user_type === 'intern') {
            $employee->internship_department = $request->internship_department;
            $employee->internship_start      = $request->internship_start;
            $employee->internship_end        = $request->internship_end;
            $employee->internship_duration   = $request->internship_duration;
            $employee->stipend               = $request->stipend ? 1 : 0;
            $employee->stipend_amount        = $request->stipend_amount;
            $employee->education_level       = $request->education_level;
            $employee->university_college    = $request->university_college;
        }

        // ===== File Upload (Common) =====
        if ($request->hasFile('cv_path')) {
            $employee->cv_path = $request->file('cv_path')->store('cvs', 'public');
        }

        // ===== Save Record =====
        $employee->save();

        // ===== Send Email (Common) =====
        if ($employee->email) {
            Mail::to($employee->email)->send(new EmployeeRegisteredMail($employee, $plainPassword));
        }

        return redirect()->route('employees.index')
            ->with('success', 'Employee/Intern created successfully and login details sent via email.');
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
        $employee = Employee::findOrFail($id);
        $designations = Designation::all();

        return view('employees.edit', compact('employee', 'designations'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // ===== Common Fields =====
        $employee->fill($request->only([
            'full_name','phone','email','user_type'
        ]));

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        // ===== File Uploads =====
        if ($request->hasFile('photo_path')) {
            $employee->photo_path = $request->file('photo_path')->store('photos','public');
        }
        if ($request->hasFile('cv_path')) {
            $employee->cv_path = $request->file('cv_path')->store('cvs','public');
        }

        // ===== Employee Fields =====
        if ($request->user_type === 'employee') {
            $employee->fill($request->only([
                'designation_id','joining_date','employment_type','salary_amount',
                'shift_name','shift_start','shift_end','education_level','university_college'
            ]));

            // clear intern fields
            $employee->internship_department = null;
            $employee->internship_start      = null;
            $employee->internship_end        = null;
            $employee->internship_duration   = null;
            $employee->stipend               = 0;
            $employee->stipend_amount        = null;
        }

        // ===== Intern Fields =====
        elseif ($request->user_type === 'intern') {
            $employee->fill($request->only([
                'internship_department','internship_start','internship_end',
                'internship_duration','stipend','stipend_amount','education_level','university_college'
            ]));

            // clear employee fields
            $employee->designation_id  = null;
            $employee->joining_date    = null;
            $employee->employment_type = null;
            $employee->salary_amount   = null;
            $employee->shift_name      = null;
            $employee->shift_start     = null;
            $employee->shift_end       = null;
        }

        $employee->save();

        return redirect()->route('employees.index')
            ->with('success','Employee/Intern updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    
    public function taskList(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        $date = $request->date ?? Carbon::today()->format('Y-m-d');

        $tasks = Task::with(['project', 'assets'])
            ->where('employee_id', $employee->id)
            ->when($date, fn($q) => $q->whereDate('created_at', $date))
            ->when($request->project_id, fn($q) => $q->where('project_id', $request->project_id))
            ->latest()
            ->get();


        return view('task.list', compact('tasks', 'date'));
    }


   public function assignProjects(Request $request, $id)
    {
        $request->validate([
            'projects' => 'required|array',
            'projects.*' => 'exists:projects,id',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->projects()->sync($request->projects);

        return redirect()->route('employees.index')->with('success', 'Projects assigned successfully.');
    }

}

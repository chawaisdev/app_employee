<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Designation;
use Illuminate\Support\Facades\Hash;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
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

        $employee = new Employee();

        // Common
        $employee->full_name = $request->full_name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);
        $employee->user_type = $request->user_type;
        // Employee fields
        $employee->designation_id = $request->designation_id;
        $employee->joining_date = $request->joining_date;
        $employee->employment_type = $request->employment_type;
        // dd($request->employment_type);
        $employee->salary_amount = $request->salary_amount;
        $employee->shift_name = $request->shift_name;
        $employee->shift_start = $request->shift_start;
        $employee->shift_end = $request->shift_end;
        $employee->education_level = $request->education_level;
        $employee->university_college = $request->university_college;

        // Intern fields
        $employee->internship_department = $request->internship_department;
        $employee->internship_start = $request->internship_start;
        $employee->internship_end = $request->internship_end;
        $employee->internship_duration = $request->internship_duration;
        $employee->stipend = $request->input('stipend') ? 1 : 0;
        $employee->stipend_amount = $request->stipend_amount;
        // File uploads
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        // if ($request->hasFile('photo_path')) {
        //     $employee->photo_path = $request->file('photo_path')->store('photos', 'public');
        // }

        if ($request->hasFile('cv_path')) {
            $employee->cv_path = $request->file('cv_path')->store('cvs', 'public');
        }

        $employee->save(); // Save to DB

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
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

        $employee->fill($request->only([
            'full_name','guardian_name','dob','gender','cnic','phone',
            'email','emergency_contact_name','emergency_contact_phone',
            'current_address','permanent_address','user_type'
        ]));

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo_path')) {
            $employee->photo_path = $request->file('photo_path')->store('photos','public');
        }
        if ($request->hasFile('cv_path')) {
            $employee->cv_path = $request->file('cv_path')->store('cvs','public');
        }

        if ($request->user_type === 'employee') {
            $employee->fill($request->only([
                'designation_id','joining_date','employment_type','salary_amount',
                'shift_name','shift_start','shift_end','education_level','university_college'
            ]));
            $employee->internship_department = null;
            $employee->internship_start = null;
            $employee->internship_end = null;
            $employee->internship_duration = null;
            $employee->stipend = 0;
            $employee->stipend_amount = null;
        } else {
            $employee->fill($request->only([
                'internship_department','internship_start','internship_end',
                'internship_duration','stipend','stipend_amount','education_level','university_college'
            ]));
            $employee->designation_id = null;
            $employee->joining_date = null;
            $employee->employment_type = null;
            $employee->salary_amount = null;
            $employee->shift_name = null;
            $employee->shift_start = null;
            $employee->shift_end = null;
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success','Employee updated successfully.');
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
}

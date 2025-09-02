<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        
        if (!$employee) {
            abort(403, 'Unauthorized');
        }

        return view('settings.index', compact('employee'));
    }

    public function update(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if (!$employee) {
            abort(403, 'Unauthorized');
        }

        $rules = [
            'full_name' => 'required|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'cnic' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:employees,email,' . $employee->id,
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'current_address' => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
            'designation_id' => 'nullable|integer',
            'joining_date' => 'nullable|date',
            'employment_type' => 'nullable|string|max:255',
            'salary_amount' => 'nullable|numeric',
            'shift_name' => 'nullable|string|max:255',
            'shift_start' => 'nullable|date_format:H:i',
            'shift_end' => 'nullable|date_format:H:i',
            'education_level' => 'nullable|string|max:255',
            'university_college' => 'nullable|string|max:255',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv_path' => 'nullable|file|mimes:pdf|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        // Add internship-related validation only for interns
        if ($employee->user_type === 'intern') {
            $rules = array_merge($rules, [
                'internship_department' => 'nullable|string|max:255',
                'internship_start' => 'nullable|date',
                'internship_end' => 'nullable|date',
                'internship_duration' => 'nullable|string|max:255',
                'stipend' => 'nullable|string|max:255',
                'stipend_amount' => 'nullable|numeric',
            ]);
        }

        $validated = $request->validate($rules);

        $data = $request->only([
            'full_name',
            'guardian_name',
            'dob',
            'gender',
            'cnic',
            'phone',
            'email',
            'emergency_contact_name',
            'emergency_contact_phone',
            'current_address',
            'permanent_address',
            'designation_id',
            'joining_date',
            'employment_type',
            'salary_amount',
            'shift_name',
            'shift_start',
            'shift_end',
            'education_level',
            'university_college',
        ]);

        // Include internship fields only for interns
        if ($employee->user_type === 'intern') {
            $data = array_merge($data, $request->only([
                'internship_department',
                'internship_start',
                'internship_end',
                'internship_duration',
                'stipend',
                'stipend_amount',
            ]));
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['is_password_update'] = true;
        }


        if ($request->hasFile('photo_path')) {
            // Delete old photo if exists
            if ($employee->photo_path && Storage::disk('public')->exists($employee->photo_path)) {
                Storage::disk('public')->delete($employee->photo_path);
            }

            // Get uploaded file
            $file = $request->file('photo_path');

            // Get original extension
            $extension = $file->getClientOriginalExtension();

            // Generate a unique filename
            $filename = 'employee_' . time() . '.' . $extension;

            // Store file in public/storage/employee
            $path = $file->storeAs('employee', $filename, 'public');

            // Save path to database
            $data['photo_path'] = $path;
        }


        $employee->update($data);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
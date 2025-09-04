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

        if ($employee->is_profile_update) {
            $rules = [
                'password' => 'nullable|string|min:8|confirmed',
            ];

            $validated = $request->validate($rules);

            $data = [];
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
                $data['is_password_update'] = true;
            }

            if (!empty($data)) {
                $employee->update($data);
            }

            return redirect()->route('settings.index')->with('success', 'Password updated successfully.');
        }

        $rules = [
            'full_name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'cnic' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:employees,email,' . $employee->id,
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'current_address' => 'required|string|max:500',
            'permanent_address' => 'required|string|max:500',
            'designation_id' => 'nullable|integer',
            'joining_date' => 'nullable|date',
            'employment_type' => 'nullable|string|max:255',
            'salary_amount' => 'nullable|numeric',
            'shift_name' => 'nullable|string|max:255',
            'shift_start' => 'nullable',
            'shift_end' => 'nullable',
            'education_level' => 'required|string|max:255',
            'university_college' => 'required|string|max:255',
            'photo_path' => 'required|image|mimes:jpeg,png,jpg,gif',
            'cv_path' => 'required|file|mimes:pdf',
            'password' => 'nullable|string|min:8|confirmed',
        ];

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
            if ($employee->photo_path && Storage::disk('public')->exists($employee->photo_path)) {
                Storage::disk('public')->delete($employee->photo_path);
            }

            $file = $request->file('photo_path');

            $extension = $file->getClientOriginalExtension();

            $filename = 'employee_' . time() . '.' . $extension;

            $path = $file->storeAs('employee', $filename, 'public');

            $data['photo_path'] = $path;
        }

        if ($request->hasFile('cv_path')) {
            if ($employee->cv_path && Storage::disk('public')->exists($employee->cv_path)) {
                Storage::disk('public')->delete($employee->cv_path);
            }

            $file = $request->file('cv_path');

            $extension = $file->getClientOriginalExtension();

            $filename = 'cv_' . time() . '.' . $extension;

            $path = $file->storeAs('employee', $filename, 'public');

            $data['cv_path'] = $path;
        }

        $data['is_profile_update'] = 1;

        $employee->update($data);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }


}
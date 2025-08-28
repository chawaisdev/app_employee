<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();
        return view('students.index', compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'full_name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'cnic' => 'required|string|max:50|unique:students,cnic',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:students,email',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'current_address' => 'required|string',
            'permanent_address' => 'required|string',
            'photo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Extra fields
            'enrollment_date' => 'nullable|date',
            'course_program' => 'nullable|string|max:255',
            'batch_session' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:100',
            'fee_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:unpaid,partial,paid',
            'education_level' => 'nullable|string|max:100',
            'university_college' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo_path')) {
            $photoPath = $request->file('photo_path')->store('students', 'public');
        }

        // Create student object
        $student = new Student();
        $student->full_name = $request->input('full_name');
        $student->guardian_name = $request->input('guardian_name');
        $student->dob = $request->input('dob');
        $student->gender = $request->input('gender');
        $student->cnic = $request->input('cnic');
        $student->phone = $request->input('phone');
        $student->email = $request->input('email');
        $student->emergency_contact_name = $request->input('emergency_contact_name');
        $student->emergency_contact_phone = $request->input('emergency_contact_phone');
        $student->current_address = $request->input('current_address');
        $student->permanent_address = $request->input('permanent_address');
        $student->photo_path = $photoPath;

        // Extra fields
        $student->enrollment_date = $request->input('enrollment_date');
        $student->course_program = $request->input('course_program');
        $student->batch_session = $request->input('batch_session');
        $student->duration = $request->input('duration');
        $student->fee_amount = $request->input('fee_amount');
        $student->payment_status = $request->input('payment_status');
        $student->education_level = $request->input('education_level');
        $student->university_college = $request->input('university_college');

        // Save to database
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
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
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'cnic' => 'required|string|max:50|unique:students,cnic,'.$id,
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:students,email,'.$id,
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'current_address' => 'required|string',
            'permanent_address' => 'required|string',
            'photo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Extra fields
            'enrollment_date' => 'nullable|date',
            'course_program' => 'nullable|string|max:255',
            'batch_session' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:100',
            'fee_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:unpaid,partial,paid',
            'education_level' => 'nullable|string|max:100',
            'university_college' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        $photoPath = $student->photo_path;
        if ($request->hasFile('photo_path')) {
            // Delete old photo if exists
            if ($photoPath) {
                \Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo_path')->store('students', 'public');
        }

        // Update student object
        $student->full_name = $request->input('full_name');
        $student->guardian_name = $request->input('guardian_name');
        $student->dob = $request->input('dob');
        $student->gender = $request->input('gender');
        $student->cnic = $request->input('cnic');
        $student->phone = $request->input('phone');
        $student->email = $request->input('email');
        $student->emergency_contact_name = $request->input('emergency_contact_name');
        $student->emergency_contact_phone = $request->input('emergency_contact_phone');
        $student->current_address = $request->input('current_address');
        $student->permanent_address = $request->input('permanent_address');
        $student->photo_path = $photoPath;

        // Extra fields
        $student->enrollment_date = $request->input('enrollment_date');
        $student->course_program = $request->input('course_program');
        $student->batch_session = $request->input('batch_session');
        $student->duration = $request->input('duration');
        $student->fee_amount = $request->input('fee_amount');
        $student->payment_status = $request->input('payment_status');
        $student->education_level = $request->input('education_level');
        $student->university_college = $request->input('university_college');

        // Save to database
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $student = Student::findOrFail($id);
        // Delete photo if exists
        if ($student->photo_path) {
            \Storage::disk('public')->delete($student->photo_path);
        }
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}

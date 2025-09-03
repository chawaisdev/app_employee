@extends('layouts.app')

@section('title')
    Edit Employee / Intern
@endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Employee Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ===== Common Fields ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $employee->full_name) }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Father’s/Guardian’s Name *</label>
                                <input type="text" name="guardian_name"
                                    value="{{ old('guardian_name', $employee->guardian_name) }}" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Date of Birth *</label>
                                <input type="date" name="dob" value="{{ old('dob', $employee->dob) }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gender *</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="male"
                                        {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female"
                                        {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other"
                                        {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CNIC / Passport *</label>
                                <input type="text" name="cnic" value="{{ old('cnic', $employee->cnic) }}"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Leave blank to keep current password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact Phone *</label>
                                <input type="text" name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact Name</label>
                                <input type="text" name="emergency_contact_name"
                                    value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Current Address *</label>
                                <textarea name="current_address" class="form-control" required>{{ old('current_address', $employee->current_address) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Permanent Address *</label>
                                <textarea name="permanent_address" class="form-control" required>{{ old('permanent_address', $employee->permanent_address) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Photo (Optional)</label>
                                <input type="file" name="photo_path" class="form-control">
                                @if ($employee->photo_path)
                                    <small>Current: <a href="{{ asset('storage/' . $employee->photo_path) }}"
                                            target="_blank">View</a></small>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">User Type *</label>
                                <select name="user_type" id="user_type" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="employee"
                                        {{ old('user_type', $employee->user_type) == 'employee' ? 'selected' : '' }}>
                                        Employee</option>
                                    <option value="intern"
                                        {{ old('user_type', $employee->user_type) == 'intern' ? 'selected' : '' }}>Intern
                                    </option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        {{-- Employee Fields --}}
                        <div id="employee_fields" style="display:none;">
                            <h5 class="mb-3">Employee Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Designation *</label>
                                    <select name="designation_id" class="form-select">
                                        <option value="">-- Select --</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>
                                                {{ $designation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Joining Date *</label>
                                    <input type="date" name="joining_date"
                                        value="{{ old('joining_date', $employee->joining_date) }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Employment Type *</label>
                                    <select name="employment_type" class="form-select">
                                        <option value="">-- Select --</option>
                                        <option value="full-time"
                                            {{ old('employment_type', $employee->employment_type) == 'full-time' ? 'selected' : '' }}>
                                            Full-time</option>
                                        <option value="part-time"
                                            {{ old('employment_type', $employee->employment_type) == 'part-time' ? 'selected' : '' }}>
                                            Part-time</option>
                                        <option value="contract"
                                            {{ old('employment_type', $employee->employment_type) == 'contract' ? 'selected' : '' }}>
                                            Contract</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Salary/Package *</label>
                                    <input type="number" step="0.01" name="salary_amount"
                                        value="{{ old('salary_amount', $employee->salary_amount) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Shift Name</label>
                                    <input type="text" name="shift_name"
                                        value="{{ old('shift_name', $employee->shift_name) }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Shift Start</label>
                                    <input type="time" name="shift_start"
                                        value="{{ old('shift_start', $employee->shift_start) }}" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Shift End</label>
                                    <input type="time" name="shift_end"
                                        value="{{ old('shift_end', $employee->shift_end) }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Education Level *</label>
                                    <input type="text" name="education_level"
                                        value="{{ old('education_level', $employee->education_level) }}"
                                        class="form-control">

                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">University/College *</label>
                                    <input type="text" name="university_college"
                                        value="{{ old('university_college', $employee->university_college) }}"
                                        class="form-control">

                                </div>
                            </div>
                        </div>

                        {{-- Intern Fields --}}
                        <div id="intern_fields" style="display:none;">
                            <h5 class="mb-3">Intern Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Internship Department *</label>
                                    <input type="text" name="internship_department"
                                        value="{{ old('internship_department', $employee->internship_department) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Internship Start *</label>
                                    <input type="date" name="internship_start"
                                        value="{{ old('internship_start', $employee->internship_start) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Internship End *</label>
                                    <input type="date" name="internship_end"
                                        value="{{ old('internship_end', $employee->internship_end) }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Duration *</label>
                                    <input type="text" name="internship_duration"
                                        value="{{ old('internship_duration', $employee->internship_duration) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stipend</label>
                                    <select name="stipend" class="form-select">
                                        <option value="0"
                                            {{ old('stipend', $employee->stipend) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1"
                                            {{ old('stipend', $employee->stipend) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stipend Amount</label>
                                    <input type="number" step="0.01" name="stipend_amount"
                                        value="{{ old('stipend_amount', $employee->stipend_amount) }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Education Level *</label>
                                    <input type="text" name="education_level"
                                        value="{{ old('education_level', $employee->education_level) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">University/College *</label>
                                    <input type="text" name="university_college"
                                        value="{{ old('university_college', $employee->university_college) }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                    <script>
                        function toggleFields() {
                            let type = document.getElementById('user_type').value;
                            document.getElementById('employee_fields').style.display = (type === 'employee') ? 'block' : 'none';
                            document.getElementById('intern_fields').style.display = (type === 'intern') ? 'block' : 'none';
                        }
                        document.getElementById('user_type').addEventListener('change', toggleFields);
                        window.onload = toggleFields;
                    </script>
                </div>

            </div>
        </div>
    </div>
@endsection

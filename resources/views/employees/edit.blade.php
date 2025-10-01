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
                    
                    {{-- Update Form --}}
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ===== Common Fields ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-control" 
                                       value="{{ old('full_name', $employee->full_name) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone', $employee->phone) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" class="form-control"
                                       value="{{ old('email', $employee->email) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Password (leave blank if not changing)</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">User Type *</label>
                                <select name="user_type" id="user_type" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="employee" {{ old('user_type', $employee->user_type) == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="intern" {{ old('user_type', $employee->user_type) == 'intern' ? 'selected' : '' }}>Intern</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        {{-- ===== Employee Fields ===== --}}
                        <div id="employee_fields" style="display: none;">
                            <h5 class="mb-3">Employee Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Designation/Job Title *</label>
                                    <select name="designation_id" class="form-select">
                                        <option value="">-- Select Designation --</option>
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
                                    <input type="date" name="joining_date" class="form-control"
                                           value="{{ old('joining_date', $employee->joining_date) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Employment Type *</label>
                                    <select name="employment_type" class="form-select">
                                        <option value="">-- Select --</option>
                                        <option value="full-time" {{ old('employment_type', $employee->employment_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                        <option value="part-time" {{ old('employment_type', $employee->employment_type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                        <option value="contract" {{ old('employment_type', $employee->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Salary/Package *</label>
                                    <input type="number" step="0.01" name="salary_amount" class="form-control"
                                           value="{{ old('salary_amount', $employee->salary_amount) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Upload CV</label>
                                    <input type="file" name="cv_path" class="form-control">
                                    @if ($employee->cv_path)
                                        <small class="text-muted">Current: {{ $employee->cv_path }}</small>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Shift Name</label>
                                    <input type="text" name="shift_name" class="form-control"
                                           value="{{ old('shift_name', $employee->shift_name) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Shift Start</label>
                                    <input type="time" name="shift_start" class="form-control"
                                           value="{{ old('shift_start', $employee->shift_start) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Shift End</label>
                                    <input type="time" name="shift_end" class="form-control"
                                           value="{{ old('shift_end', $employee->shift_end) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Education Level *</label>
                                    <input type="text" name="education_level" class="form-control"
                                           value="{{ old('education_level', $employee->education_level) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">University/College (Last studied) *</label>
                                    <input type="text" name="university_college" class="form-control"
                                           value="{{ old('university_college', $employee->university_college) }}">
                                </div>
                            </div>
                        </div>

                        {{-- ===== Intern Fields ===== --}}
                        <div id="intern_fields" style="display: none;">
                            <h5 class="mb-3">Intern Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Internship Program/Department *</label>
                                    <input type="text" name="internship_department" class="form-control"
                                           value="{{ old('internship_department', $employee->internship_department) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Internship Start *</label>
                                    <input type="date" name="internship_start" class="form-control"
                                           value="{{ old('internship_start', $employee->internship_start) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Internship End *</label>
                                    <input type="date" name="internship_end" class="form-control"
                                           value="{{ old('internship_end', $employee->internship_end) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Duration *</label>
                                    <input type="text" name="internship_duration" class="form-control"
                                           value="{{ old('internship_duration', $employee->internship_duration) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stipend (Yes/No)</label>
                                    <select name="stipend" class="form-select">
                                        <option value="0" {{ old('stipend', $employee->stipend) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('stipend', $employee->stipend) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stipend Amount (if Yes)</label>
                                    <input type="number" step="0.01" name="stipend_amount" class="form-control"
                                           value="{{ old('stipend_amount', $employee->stipend_amount) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Education Level *</label>
                                    <input type="text" name="education_level" class="form-control"
                                           value="{{ old('education_level', $employee->education_level) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">University/College (Last studied) *</label>
                                    <input type="text" name="university_college" class="form-control"
                                           value="{{ old('university_college', $employee->university_college) }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>


                    {{-- Toggle Fields --}}
                    <script>
                        function toggleFields(type) {
                            document.getElementById('employee_fields').style.display = (type === 'employee') ? 'block' : 'none';
                            document.getElementById('intern_fields').style.display = (type === 'intern') ? 'block' : 'none';
                        }

                        document.getElementById('user_type').addEventListener('change', function() {
                            toggleFields(this.value);
                        });

                        // Run once on page load with current value
                        toggleFields("{{ old('user_type', $employee->user_type) }}");
                    </script>

                </div>

            </div>
        </div>
    </div>
@endsection

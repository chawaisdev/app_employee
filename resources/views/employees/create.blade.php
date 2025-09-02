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
                    <li class="breadcrumb-item active" aria-current="page">Employee Create</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ===== Common Fields ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                         <div class="col-md-4">
                                <label class="form-label">EMail</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">User Type *</label>
                                <select name="user_type" id="user_type" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="employee">Employee</option>
                                    <option value="intern">Intern</option>
                                </select>
                            </div>
                        </div>

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
                                                {{ isset($employee) && $employee->designation_id == $designation->id ? 'selected' : '' }}>
                                                {{ $designation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Joining Date *</label>
                                    <input type="date" name="joining_date" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Employment Type *</label>
                                    <select name="employment_type" class="form-select">
                                        <option value="">-- Select --</option>
                                        <option value="full-time">Full-time</option>
                                        <option value="part-time">Part-time</option>
                                        <option value="contract">Contract</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Salary/Package *</label>
                                    <input type="number" step="0.01" name="salary_amount" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Upload CV</label>
                                    <input type="file" name="cv_path" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Shift Name</label>
                                    <input type="text" name="shift_name" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Shift Start</label>
                                    <input type="time" name="shift_start" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Shift End</label>
                                    <input type="time" name="shift_end" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Education Level *</label>
                                    <input type="text" name="education_level" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">University/College (Last studied) *</label>
                                    <input type="text" name="university_college" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- ===== Intern Fields ===== --}}
                        <div id="intern_fields" style="display: none;">
                            <h5 class="mb-3">Intern Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Internship Program/Department *</label>
                                    <input type="text" name="internship_department" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Internship Start *</label>
                                    <input type="date" name="internship_start" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Internship End *</label>
                                    <input type="date" name="internship_end" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Duration *</label>
                                    <input type="text" name="internship_duration" class="form-control"
                                        placeholder="e.g., 6 weeks, 3 months">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stipend (Yes/No)</label>
                                    <select name="stipend" class="form-select">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stipend Amount (if Yes)</label>
                                    <input type="number" step="0.01" name="stipend_amount" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Education Level *</label>
                                    <input type="text" name="education_level" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">University/College (Last studied) *</label>
                                    <input type="text" name="university_college" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>


                    {{-- Toggle Fields --}}
                    <script>
                        document.getElementById('user_type').addEventListener('change', function() {
                            let type = this.value;
                            document.getElementById('employee_fields').style.display = (type === 'employee') ? 'block' : 'none';
                            document.getElementById('intern_fields').style.display = (type === 'intern') ? 'block' : 'none';
                        });
                    </script>

                </div>

            </div>
        </div>
    </div>
@endsection

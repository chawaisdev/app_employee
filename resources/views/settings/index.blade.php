@extends('layouts.app')

@section('title')
    Setting Index
@endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Setting Index</li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('settings.update', ['setting' => Auth::guard('employee')->id()]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-5">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane show active" id="personal-info" role="tabpanel">
                                    <div class="p-sm-3 p-0">
                                        <div class="row gy-4 mb-4">
                                            <!-- Personal Information -->
                                            <div class="col-xl-6">
                                                <label for="full_name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="full_name" name="full_name"
                                                    value="{{ $employee->full_name }}" placeholder="Full Name">
                                                @error('full_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="guardian_name" class="form-label">Guardian Name</label>
                                                <input type="text" class="form-control" id="guardian_name"
                                                    name="guardian_name" value="{{ $employee->guardian_name }}"
                                                    placeholder="Guardian Name">
                                                @error('guardian_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob"
                                                    value="{{ $employee->dob }}" placeholder="Date of Birth">
                                                @error('dob')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select class="form-control" id="gender" name="gender">
                                                    <option value="Male"
                                                        {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female"
                                                        {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female
                                                    </option>
                                                    <option value="Other"
                                                        {{ $employee->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="cnic" class="form-label">CNIC</label>
                                                <input type="text" class="form-control" id="cnic" name="cnic"
                                                    value="{{ $employee->cnic }}" placeholder="CNIC">
                                                @error('cnic')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{ $employee->phone }}" placeholder="Phone">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $employee->email }}" placeholder="Email">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="emergency_contact_name" class="form-label">Emergency Contact
                                                    Name</label>
                                                <input type="text" class="form-control" id="emergency_contact_name"
                                                    name="emergency_contact_name"
                                                    value="{{ $employee->emergency_contact_name }}"
                                                    placeholder="Emergency Contact Name">
                                                @error('emergency_contact_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="emergency_contact_phone" class="form-label">Emergency Contact
                                                    Phone</label>
                                                <input type="text" class="form-control" id="emergency_contact_phone"
                                                    name="emergency_contact_phone"
                                                    value="{{ $employee->emergency_contact_phone }}"
                                                    placeholder="Emergency Contact Phone">
                                                @error('emergency_contact_phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="current_address" class="form-label">Current Address</label>
                                                <input type="text" class="form-control" id="current_address"
                                                    name="current_address" value="{{ $employee->current_address }}"
                                                    placeholder="Current Address">
                                                @error('current_address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="permanent_address" class="form-label">Permanent
                                                    Address</label>
                                                <input type="text" class="form-control" id="permanent_address"
                                                    name="permanent_address" value="{{ $employee->permanent_address }}"
                                                    placeholder="Permanent Address">
                                                @error('permanent_address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Employment Information -->
                                            <div class="col-xl-6">
                                                <label for="designation_name" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="designation_name"
                                                    name="designation_name"
                                                    value="{{ $employee->designation?->name ?? 'N/A' }}"
                                                    placeholder="Designation" readonly disabled>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="joining_date" class="form-label">Joining Date</label>
                                                <input type="date" class="form-control" id="joining_date"
                                                    name="joining_date" value="{{ $employee->joining_date }}"
                                                    placeholder="Joining Date">
                                                @error('joining_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="employment_type" class="form-label">Employment Type</label>
                                                <input type="text" class="form-control" id="employment_type"
                                                    name="employment_type" value="{{ $employee->employment_type }}"
                                                    placeholder="Employment Type">
                                                @error('employment_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="salary_amount" class="form-label">Salary Amount</label>
                                                <input type="number" class="form-control" id="salary_amount"
                                                    name="salary_amount" value="{{ $employee->salary_amount }}"
                                                    placeholder="Salary Amount" readonly disabled>
                                                @error('salary_amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="shift_name" class="form-label">Shift Name</label>
                                                <input type="text" class="form-control" id="shift_name"
                                                    name="shift_name" value="{{ $employee->shift_name }}"
                                                    placeholder="Shift Name" readonly disabled>
                                                @error('shift_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="shift_start" class="form-label">Shift Start</label>
                                                <input type="time" class="form-control" id="shift_start"
                                                    name="shift_start" value="{{ $employee->shift_start }}"
                                                    placeholder="Shift Start" readonly disabled>
                                                @error('shift_start')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="shift_end" class="form-label">Shift End</label>
                                                <input type="time" class="form-control" id="shift_end"
                                                    name="shift_end" value="{{ $employee->shift_end }}"
                                                    placeholder="Shift End" readonly disabled>
                                                @error('shift_end')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Education Information -->
                                            <div class="col-xl-6">
                                                <label for="education_level" class="form-label">Education Level</label>
                                                <input type="text" class="form-control" id="education_level"
                                                    name="education_level" value="{{ $employee->education_level }}"
                                                    placeholder="Education Level">
                                                @error('education_level')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="university_college"
                                                    class="form-label">University/College</label>
                                                <input type="text" class="form-control" id="university_college"
                                                    name="university_college" value="{{ $employee->university_college }}"
                                                    placeholder="University/College">
                                                @error('university_college')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Internship Information (Shown only for interns) -->
                                            @if ($employee->user_type === 'intern')
                                                <div class="col-xl-6">
                                                    <label for="internship_department" class="form-label">Internship
                                                        Department</label>
                                                    <input type="text" class="form-control" id="internship_department"
                                                        name="internship_department"
                                                        value="{{ $employee->internship_department }}"
                                                        placeholder="Internship Department">
                                                    @error('internship_department')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="internship_start" class="form-label">Internship
                                                        Start</label>
                                                    <input type="date" class="form-control" id="internship_start"
                                                        name="internship_start" value="{{ $employee->internship_start }}"
                                                        placeholder="Internship Start" readonly disabled>
                                                    @error('internship_start')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="internship_end" class="form-label">Internship End</label>
                                                    <input type="date" class="form-control" id="internship_end"
                                                        name="internship_end" value="{{ $employee->internship_end }}"
                                                        placeholder="Internship End" readonly disabled>
                                                    @error('internship_end')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="internship_duration" class="form-label">Internship
                                                        Duration</label>
                                                    <input type="text" class="form-control" id="internship_duration"
                                                        name="internship_duration"
                                                        value="{{ $employee->internship_duration }}"
                                                        placeholder="Internship Duration" readonly disabled>
                                                    @error('internship_duration')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="stipend" class="form-label">Stipend</label>
                                                    <input type="text" class="form-control" id="stipend"
                                                        name="stipend" value="{{ $employee->stipend }}"
                                                        placeholder="Stipend" readonly disabled>
                                                    @error('stipend')
                                                        <span class="text-danger" readonly disabled>{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="stipend_amount" class="form-label">Stipend Amount</label>
                                                    <input type="number" class="form-control" id="stipend_amount"
                                                        name="stipend_amount" value="{{ $employee->stipend_amount }}"
                                                        placeholder="Stipend Amount" readonly disabled>
                                                    @error('stipend_amount')
                                                        <span class="text-danger"{{ $message }}</span>
                                                        @enderror
                                                </div>
                                            @endif
                                            <!-- File Uploads -->
                                            <div class="col-xl-6">
                                                <label for="photo_path" class="form-label">Profile Photo</label>
                                                <input type="file" class="form-control" id="photo_path"
                                                    name="photo_path" accept="image/*" readonly disabled>
                                                @if ($employee->photo_path)
                                                    <img id="profile-img-preview"
                                                        src="{{ Storage::url($employee->photo_path) }}"
                                                        alt="Profile Image" style="max-width: 100px; margin-top: 10px;">
                                                @endif
                                                @error('photo_path')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="cv_path" class="form-label">CV Upload</label>
                                                <input type="file" class="form-control" id="cv_path" name="cv_path"
                                                    accept=".pdf">
                                                @error('cv_path')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Password -->
                                            <div class="col-xl-6">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Leave blank to keep current">
                                                <small class="text-muted">Leave password fields blank if you don't want to
                                                    change your password.</small>
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="password_confirmation" class="form-label">Confirm
                                                    Password</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" placeholder="Confirm Password">
                                                @error('password_confirmation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary m-1">Update Setting</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- JS for live preview -->
    <script>
        document.getElementById('photo_path').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('profile-img-preview').src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection

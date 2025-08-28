@extends('layouts.app')

@section('title')
    Student Edit
@endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                    <form action="{{ route('students.update', $student->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ===== Common Fields ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-control"
                                    value="{{ old('full_name', $student->full_name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Father’s/Guardian’s Name *</label>
                                <input type="text" name="guardian_name" class="form-control"
                                    value="{{ old('guardian_name', $student->guardian_name) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Date of Birth *</label>
                                <input type="date" name="dob" class="form-control"
                                    value="{{ old('dob', $student->dob) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gender *</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="male"
                                        {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female"
                                        {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other"
                                        {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CNIC / Passport *</label>
                                <input type="text" name="cnic" class="form-control"
                                    value="{{ old('cnic', $student->cnic) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $student->phone) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $student->email) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Emergency Contact Name</label>
                                <input type="text" name="emergency_contact_name" class="form-control"
                                    value="{{ old('emergency_contact_name', $student->emergency_contact_name) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact Phone *</label>
                                <input type="text" name="emergency_contact_phone" class="form-control"
                                    value="{{ old('emergency_contact_phone', $student->emergency_contact_phone) }}"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Address *</label>
                            <textarea name="current_address" class="form-control" required>{{ old('current_address', $student->current_address) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permanent Address *</label>
                            <textarea name="permanent_address" class="form-control" required>{{ old('permanent_address', $student->permanent_address) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo (Optional)</label>
                            <input type="file" name="photo_path" class="form-control">
                            @if ($student->photo_path)
                                <small class="text-muted">Current: <a href="{{ asset('storage/' . $student->photo_path) }}"
                                        target="_blank">View Photo</a></small>
                            @endif
                        </div>

                        {{-- ===== Extra Fields ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Enrollment Date</label>
                                <input type="date" name="enrollment_date" class="form-control"
                                    value="{{ old('enrollment_date', $student->enrollment_date) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Course / Program</label>
                                <input type="text" name="course_program" class="form-control"
                                    value="{{ old('course_program', $student->course_program) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Batch / Session</label>
                                <input type="text" name="batch_session" class="form-control"
                                    value="{{ old('batch_session', $student->batch_session) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Duration</label>
                                <input type="text" name="duration" class="form-control"
                                    value="{{ old('duration', $student->duration) }}" placeholder="e.g. 6 Months">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fee Amount</label>
                                <input type="number" name="fee_amount" class="form-control" step="0.01"
                                    value="{{ old('fee_amount', $student->fee_amount) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Payment Status</label>
                                <select name="payment_status" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="unpaid"
                                        {{ old('payment_status', $student->payment_status) == 'unpaid' ? 'selected' : '' }}>
                                        Unpaid</option>
                                    <option value="partial"
                                        {{ old('payment_status', $student->payment_status) == 'partial' ? 'selected' : '' }}>
                                        Partial</option>
                                    <option value="paid"
                                        {{ old('payment_status', $student->payment_status) == 'paid' ? 'selected' : '' }}>
                                        Paid</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Education Level</label>
                                <input type="text" name="education_level" class="form-control"
                                    value="{{ old('education_level', $student->education_level) }}"
                                    placeholder="e.g. BS, Intermediate">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">University / College</label>
                            <input type="text" name="university_college" class="form-control"
                                value="{{ old('university_college', $student->university_college) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

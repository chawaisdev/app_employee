@extends('layouts.app')

@section('title')
    Student Index
@endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Create</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                 <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ===== Common Fields ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Father’s/Guardian’s Name *</label>
                                <input type="text" name="guardian_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Date of Birth *</label>
                                <input type="date" name="dob" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gender *</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CNIC / Passport *</label>
                                <input type="text" name="cnic" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Emergency Contact Name</label>
                                <input type="text" name="emergency_contact_name" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact Phone *</label>
                                <input type="text" name="emergency_contact_phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Address *</label>
                            <textarea name="current_address" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permanent Address *</label>
                            <textarea name="permanent_address" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo (Optional)</label>
                            <input type="file" name="photo_path" class="form-control">
                        </div>

                        {{-- ===== Extra Fields ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Enrollment Date</label>
                                <input type="date" name="enrollment_date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Course / Program</label>
                                <input type="text" name="course_program" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Batch / Session</label>
                                <input type="text" name="batch_session" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Duration</label>
                                <input type="text" name="duration" class="form-control" placeholder="e.g. 6 Months">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fee Amount</label>
                                <input type="number" name="fee_amount" class="form-control" step="0.01">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Payment Status</label>
                                <select name="payment_status" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="partial">Partial</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Education Level</label>
                                <input type="text" name="education_level" class="form-control"
                                    placeholder="e.g. BS, Intermediate">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">University / College</label>
                            <input type="text" name="university_college" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

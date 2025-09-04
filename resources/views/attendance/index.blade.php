@extends('layouts.app')
@section('title')
    Attendance Index
@endsection
@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Attendance Index</li>
                </ol>
            </nav>
        </div>
        <div class="col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Attendance</h3>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="text-end">
                            {{-- Check In/Check Out/Complete Status --}}
                            @if (!$todayAttendance || !$todayAttendance->check_in)
                                <form action="{{ route('attendance.checkin') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Check In
                                    </button>
                                </form>
                            @elseif ($todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out)
                                <form action="{{ route('attendance.checkout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Check Out
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-primary btn-sm" disabled>Attendance Complete
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendance as $att)
                                    <tr>
                                        <td>{{ $att->id }}</td>
                                        <td>{{ $att->employee->full_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($att->date)->format('d-m-Y') }}</td>
                                        <td>{{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('h:i:s A') : 'N/A' }}
                                        </td>
                                        <td>{{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('h:i:s A') : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->check() && !auth()->user()->is_password_update)
        <!-- Password Change Modal -->
        <div class="modal fade" id="forcePasswordModal" tabindex="-1" aria-labelledby="forcePasswordModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('update.password') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Change Your Password</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Old Password</label>
                                <input type="password" name="old_password" class="form-control" required>
                                @error('old_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Script to auto-open modal --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('forcePasswordModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                myModal.show();
            });
        </script>
    @endif
@endsection

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
                                    <tr>
                                        <td colspan="5" class="text-center">No attendance records found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

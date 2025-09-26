@extends('layouts.app')

@section('title')
    Student Index
@endsection

@section('body')

    <div class="container-fluid">
        <!-- PAGE HEADER AND ADD BUTTON -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Index</li>
                </ol>
            </nav>
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
                Add Student
            </a>
        </div>

        <!-- Student TABLE -->
        <div class="col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6>All Students</h6>
                </div>
                <!-- TABLE DATA -->
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Sr #</th>
                                    <th scope="col">Profile</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Guardian Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Current Address</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($student->isEmpty())
                                @else
                                    @foreach ($student as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <!-- Profile Image -->
                                            <td>
                                                @if ($user->photo_path)
                                                    <img src="{{ asset('storage/' . $user->photo_path) }}"
                                                        alt="Student Photo" width="60" height="60"
                                                        class="rounded-circle">
                                                @else
                                                    <span>No Photo</span>
                                                @endif
                                            </td>

                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->guardian_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->current_address }}</td>
                                            <td>
                                                <!-- DELETE USER BUTTON -->
                                                <form action="{{ route('students.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>

                                                <!-- EDIT USER BUTTON -->
                                                <a href="{{ route('students.edit', $user->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pen-to-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title')
    Edit Item
@endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Item Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                    <form action="{{ route('adduser.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Change this to PUT for update --}}

                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3 col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>


                            <div class="mb-3 col-6">
                                <label for="password" class="form-label">Password (optional)</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Enter new password">
                            </div>
                            <div class="mb-3 col-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter phone"
                                    value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="mb-3 col-6">
                                <label for="cnic" class="form-label">Cnic</label>
                                <input type="text" name="cnic" class="form-control" placeholder="Enter Cnic"
                                    value="{{ old('cnic', $user->cnic) }}">
                            </div>

                            <div class="mb-3 col-6">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control" placeholder="Enter address">{{ old('address', $user->address) }}</textarea>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="user_type" class="form-label">User Type</label>
                                <select name="user_type" class="form-select" required>
                                    <option value="">-- Select User Type --</option>
                                    <option value="admin"
                                        {{ old('user_type', $user->user_type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="hr"
                                        {{ old('user_type', $user->user_type) == 'hr' ? 'selected' : '' }}>HR</option>
                                    <option value="employee"
                                        {{ old('user_type', $user->user_type) == 'employee' ? 'selected' : '' }}>Employee
                                    </option>
                                </select>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title')
    Designation Index
@endsection

@section('body')
    <div class="container-fluid">
        <!-- PAGE HEADER -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Designation </li>
                </ol>
            </nav>
            <button class="btn btn-primary btn-sm" onclick="openAddModal()">Add Designation</button>
        </div>

        <!-- TABLE -->
        <div class="col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Designation</h6>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Sr#</th>
                                    <th scope="col">Designation Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designation as $index => $designation)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $designation->name }}</td>
                                        <td>{{ $designation->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <form action="{{ route('designation.destroy', $designation->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="openEditModal({{ $designation }})">
                                                <i class="fa fa-pen-to-square"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="designationModal" tabindex="-1" role="dialog" aria-labelledby="designationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="designationForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="id" id="designation_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="designationModalLabel">Add Designation</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            $('#designationForm').attr('action', '{{ route('designation.store') }}');
            $('#formMethod').val('POST');
            $('#designationModalLabel').text('Add Designation');
            $('#name').val('');
            $('#designation_id').val('');
            $('#designationModal').modal('show');
        }

        function openEditModal(designation) {
            $('#designationForm').attr('action', '/designation/' + designation.id);
            $('#formMethod').val('PUT');
            $('#designationModalLabel').text('Edit Designation');
            $('#name').val(designation.name);
            $('#designation_id').val(designation.id);
            $('#designationModal').modal('show');
        }
    </script>
@endsection

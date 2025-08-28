@extends('layouts.app')

@section('title')
    project Index
@endsection

@section('body')
    <div class="container-fluid">
        <!-- PAGE HEADER -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">project </li>
                </ol>
            </nav>
            <button class="btn btn-primary btn-sm" onclick="openAddModal()">Add project</button>
        </div>

        <!-- TABLE -->
        <div class="col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All project</h6>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Sr#</th>
                                    <th scope="col">project Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project as $index => $project)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <form action="{{ route('project.destroy', $project->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="openEditModal({{ $project }})">
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
    <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="projectForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="id" id="project_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectModalLabel">Add project</h5>
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
            $('#projectForm').attr('action', '{{ route('project.store') }}');
            $('#formMethod').val('POST');
            $('#projectModalLabel').text('Add project');
            $('#name').val('');
            $('#project_id').val('');
            $('#projectModal').modal('show');
        }

        function openEditModal(project) {
            $('#projectForm').attr('action', '/project/' + project.id);
            $('#formMethod').val('PUT');
            $('#projectModalLabel').text('Edit project');
            $('#name').val(project.name);
            $('#project_id').val(project.id);
            $('#projectModal').modal('show');
        }
    </script>
@endsection

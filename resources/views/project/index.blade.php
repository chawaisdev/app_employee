@extends('layouts.app')

@section('title')
    Project Index
@endsection

@section('body')
<div class="container-fluid">
    <!-- PAGE HEADER -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Project</li>
            </ol>
        </nav>
        <div>
            <button class="btn btn-primary btn-sm" onclick="openAddModal()">Add Project</button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="col-xl-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title">All Projects</h6>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="example" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Project Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project as $index => $proj)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $proj->name }}</td>
                                    <td>{{ $proj->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <form action="{{ route('project.destroy', $proj->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>

                                        <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $proj }})">
                                            <i class="fa fa-pen-to-square"></i>
                                        </button>

                                        <button class="btn btn-sm btn-info" onclick="openAssignModal({{ $proj->id }})">
                                            <i class="fa fa-user-plus"></i> Assign Employees
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

<!-- Add/Edit Project Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="projectForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" value="POST" id="formMethod">
            <input type="hidden" name="id" id="project_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalLabel">Add Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Project Name</label>
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

<!-- Assign Employees Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="assignForm" method="POST" action="">
            @csrf
            <input type="hidden" name="project_id" id="assign_project_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Employees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="employees">Select Employees</label>
                        <select name="employees[]" id="employees" class="form-select select2" multiple required>
                            @foreach (\App\Models\Employee::all() as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    $('#projectForm').attr('action', '{{ route('project.store') }}');
    $('#formMethod').val('POST');
    $('#projectModalLabel').text('Add Project');
    $('#name').val('');
    $('#project_id').val('');
    $('#projectModal').modal('show');
}

function openEditModal(project) {
    $('#projectForm').attr('action', '/project/' + project.id);
    $('#formMethod').val('PUT');
    $('#projectModalLabel').text('Edit Project');
    $('#name').val(project.name);
    $('#project_id').val(project.id);
    $('#projectModal').modal('show');
}

function openAssignModal(projectId) {
    $('#assign_project_id').val(projectId);
    $('#assignForm').attr('action', '/project/' + projectId + '/assign');
    $('#assignModal').modal('show');
}
</script>
@endsection

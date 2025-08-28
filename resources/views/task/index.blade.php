@extends('layouts.app')

@section('title', 'Task Index')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Task Index</li>
                </ol>
            </nav>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                Add Notes
            </a>
        </div>
        <div class="col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Task</h6>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Task Title</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                    <th>Assigned Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{!! Str::limit(strip_tags($task->description), 50) !!}</td>
                                        <td>{{ $task->user->name ?? 'N/A' }}</td>

                                        <td>
                                            @foreach ($task->users as $assigned)
                                                <div><strong>{{ $assigned->name }}</strong></div>
                                            @endforeach
                                        </td>

                                        <td class="d-flex flex-column gap-1">
                                            {{-- Status Dropdowns --}}
                                            @foreach ($task->users as $assigned)
                                                <form action="{{ route('tasks.updateStatus', [$task->id, $assigned->id]) }}"
                                                    method="POST" class="mb-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" class="form-select form-select-sm"
                                                        onchange="this.form.submit()">
                                                        <option value="pending"
                                                            {{ $assigned->pivot->status == 'pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="doing"
                                                            {{ $assigned->pivot->status == 'doing' ? 'selected' : '' }}>
                                                            Doing</option>
                                                        <option value="complete"
                                                            {{ $assigned->pivot->status == 'complete' ? 'selected' : '' }}>
                                                            Complete</option>
                                                    </select>
                                                </form>
                                            @endforeach

                                            {{-- Action Buttons --}}
                                            <div class="d-flex gap-1">
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this task?')" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>

                                                <a href="{{ route('tasks.edit', $task->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pen-to-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No tasks found</td>
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

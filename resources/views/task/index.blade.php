@extends('layouts.app')

@section('title', 'Task Index')

@section('body')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Task Index</li>
                </ol>
            </nav>
        </div>

        <!-- Filters (only date + project) -->
        <form method="GET" action="{{ route('tasks.index') }}" class="row g-2 mb-4">
            <div class="col-md-3">
                <input type="date" name="date" value="{{ request('date') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <select name="project_id" class="form-select">
                    <option value="">All Projects</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-success w-100">Filter</button>
            </div>
        </form>

        <div class="row">
            @forelse ($tasks as $task)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">

                        {{-- Main Image (First from task_assets) --}}
                        @if ($task->assets->count())
                            <img src="{{ asset('storage/' . $task->assets->first()->image_path) }}" class="card-img-top"
                                style="height:200px;object-fit:cover;" alt="Task Main Image">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="text-muted mb-1">
                                <strong>Project:</strong> {{ $task->project->name ?? 'N/A' }}
                            </p>
                            <p class="text-muted mb-1">
                                <strong>Employee:</strong> {{ $task->employee->full_name ?? 'N/A' }}
                            </p>
                            <p>{{ Str::limit(strip_tags($task->description), 100) }}</p>

                            {{-- Other Images (Below Main Image) --}}
                            @if ($task->assets->count() > 1)
                                <div class="mt-3 d-flex flex-wrap gap-2">
                                    @foreach ($task->assets->skip(1) as $asset)
                                        <img src="{{ asset('storage/' . $asset->image_path) }}" alt="Task Image"
                                            style="height:60px;width:60px;object-fit:cover;" class="rounded border">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No tasks found.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection

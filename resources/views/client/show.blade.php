@extends('layouts.app')

@section('title', 'Task Detail Show')

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Task Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card custom-card p-3">
                    <h5><strong>Task Title:</strong> {{ $task->title }}</h5>
                    <p><strong>Project:</strong> {{ $task->project->name ?? 'N/A' }}</p>
                    <p><strong>Assigned Employee:</strong> {{ $task->employee->full_name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Description -->
            <div class="col-6">
                <div class="card custom-card p-3">
                    <h6><strong>Description:</strong></h6>
                    <p>{{ $task->description ?? 'No description available.' }}</p>
                </div>
            </div>

            <!-- Image -->
            <div class="col-6">
                <div class="card custom-card p-3 text-center">
                    <h6><strong>Image:</strong></h6>
                    @if ($task->images)
                        @php
                            $images = json_decode($task->images, true, 512, JSON_INVALID_UTF8_IGNORE) ?? [
                                $task->images,
                            ];
                            $images = is_array($images) ? $images : [$images];
                        @endphp

                        @foreach ($images as $img)
                            @php
                                $cleanImg = str_replace(['tasks\/', 'tasks\\'], '', $img);
                            @endphp
                            <img src="{{ asset('storage/' . $cleanImg) }}" alt="Task Image"
                                style="" class="rounded mb-2">
                        @endforeach
                    @else
                        <p>No image uploaded.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

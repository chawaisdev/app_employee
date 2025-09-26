@extends('layouts.app')

@section('title')
    Client Task Index
@endsection

@section('body')
    <div class="container-fluid">
        <!-- PAGE HEADER AND ADD BUTTON -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Client Task Index</li>
                </ol>
            </nav>
        </div>

        <!-- USER TABLE -->
        <div class="col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Client Task Index</h6>
                    <form action="{{ route('client.tasklist') }}" method="GET" class="d-flex align-items-center">
                        <div class="me-2">
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
                <!-- TABLE DATA -->
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Project</th>
                                    <th>Employee</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $index => $task)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->project->name ?? 'N/A' }}</td>
                                        <td>{{ $task->employee->full_name ?? 'N/A' }}</td>
                                        <td>{{ Str::limit(strip_tags($task->description), 50) }}</td>
                                        <td>
                                            @if ($task->images)
                                                @php
                                                    $images = json_decode(
                                                        $task->images,
                                                        true,
                                                        512,
                                                        JSON_INVALID_UTF8_IGNORE,
                                                    ) ?? [$task->images];
                                                    $images = is_array($images) ? $images : [$images];
                                                    $mainImage = $images[0] ?? null;
                                                    if ($mainImage) {
                                                        $mainImage = str_replace(
                                                            ['tasks\/', 'tasks\\'],
                                                            '',
                                                            $mainImage,
                                                        );
                                                    }
                                                @endphp
                                                @if ($mainImage)
                                                    <img src="{{ asset('storage/' . $mainImage) }}" alt="Task Image"
                                                        style="height:50px;width:50px;object-fit:cover;" class="rounded">
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('client.tasks.show', $task->id) }}"
                                                class="btn btn-sm btn-info">View</a>
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
@endsection

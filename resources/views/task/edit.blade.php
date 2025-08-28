@extends('layouts.app')

@section('title', 'Edit Task')

@section('body')
    <style>
        .image-preview {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 14px;
            cursor: pointer;
            line-height: 18px;
            text-align: center;
        }
    </style>

    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Task</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Task Title</label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $task->title) }}" placeholder="Enter task title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="assigned_users" class="form-label">Assign Users</label>
                                <select name="assigned_users[]" id="assigned_users"
                                    class="form-select select2 @error('assigned_users') is-invalid @enderror" multiple
                                    required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ in_array($user->id, old('assigned_users', $task->users->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_users')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <select name="project_id" class="form-select">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ $task->project_id == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>



                            <div class="form-group mb-3">
                                <label for="editor">Write Your Note</label>
                                <div id="editor" style="height: 250px;">{!! old('description', $task->description) !!}</div>
                                <input type="hidden" name="description" id="description"
                                    value="{{ old('description', $task->description) }}">
                            </div>

                            <div class="col-md-12">
                                <label for="images" class="form-label">Upload Images</label>
                                <input type="file" name="images[]" id="images"
                                    class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">

                                {{-- Existing images --}}
                                <div id="preview-container" class="d-flex flex-wrap gap-2 mt-2">
                                    @php
                                        $images = $task->images ? json_decode($task->images, true) : [];
                                    @endphp

                                    @foreach ($images as $index => $path)
                                        <div class="image-preview">
                                            <img src="{{ asset('storage/' . $path) }}" alt="existing image">
                                            <button type="button" class="remove-btn existing-remove-btn"
                                                data-id="{{ $index }}">&times;</button>
                                        </div>
                                    @endforeach

                                </div>

                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Update Task</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Quill & JS --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        var fonts = ['poppins'];
        var Font = Quill.import('formats/font');
        Font.whitelist = fonts;
        Quill.register(Font, true);

        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'font': fonts
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }]
                ]
            }
        });

        // sync with hidden input
        var hiddenDescription = document.getElementById('description');
        if (hiddenDescription.value) {
            quill.root.innerHTML = hiddenDescription.value;
        }
        quill.on('text-change', function() {
            hiddenDescription.value = quill.root.innerHTML;
        });
        document.querySelector('form').addEventListener('submit', function() {
            hiddenDescription.value = quill.root.innerHTML;
        });

        // Image previews
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('preview-container');
        let filesArray = [];

        imageInput.addEventListener('change', (e) => {
            const newFiles = Array.from(e.target.files);
            filesArray = filesArray.concat(newFiles);
            renderPreviews();
        });

        function renderPreviews() {
            filesArray.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement("div");
                    div.classList.add("image-preview");
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="preview">
                        <button type="button" class="remove-btn" data-index="${index}">&times;</button>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
            updateInputFiles();
        }

        previewContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("existing-remove-btn")) {
                const index = e.target.dataset.id;
                e.target.parentElement.remove();

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "remove_images[]";
                input.value = index;
                document.querySelector("form").appendChild(input);
            }

            // Handle removal of existing images
            if (e.target.classList.contains("existing-remove-btn")) {
                const imgId = e.target.dataset.id;
                e.target.parentElement.remove();

                // append hidden input to mark for deletion
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "remove_images[]";
                input.value = imgId;
                document.querySelector("form").appendChild(input);
            }
        });

        function updateInputFiles() {
            const dataTransfer = new DataTransfer();
            filesArray.forEach((file) => dataTransfer.items.add(file));
            imageInput.files = dataTransfer.files;
        }
    </script>
@endsection

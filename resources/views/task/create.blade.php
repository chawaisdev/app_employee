@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Create Task')

@section('body')
    <style>
        .image-preview {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
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
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            line-height: 18px;
            font-size: 14px;
            cursor: pointer;
        }

        #editor {
            height: 250px;
            max-height: 400px;
            overflow-y: auto;
        }
    </style>

    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ isset($task) ? 'Edit Task' : 'Create Task' }}</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                    <form action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($task))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <!-- Task Title -->
                            <div class="col-md-6">
                                <label for="title" class="form-label">Task Title</label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $task->title ?? '') }}"
                                    placeholder="Enter task title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Project Select -->
                            <div class="col-md-6">
                                <label for="project_id" class="form-label">Select Project</label>
                                <select name="project_id" id="project_id"
                                    class="form-select @error('project_id') is-invalid @enderror" required>
                                    <option value="">-- Select Project --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id', $task->project_id ?? '') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Quill Editor -->
                            <div class="form-group mb-3">
                                <label for="editor">Write Your Note</label>
                                <div id="editor">{!! old('description', $task->description ?? '') !!}</div>
                                <input type="hidden" name="description" id="description"
                                    value="{{ old('description', $task->description ?? '') }}">
                            </div>

                            <!-- Upload Images -->
                            <div class="col-md-12">
                                <label for="images" class="form-label">Upload Images</label>
                                <input type="file" name="images[]" id="images"
                                    class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                                <div id="preview-container" class="d-flex flex-wrap gap-2 mt-2"></div>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Existing Images -->
                            @if(isset($task) && $task->assets->count())
                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Existing Images</label>
                                    <div id="existing-images" class="d-flex flex-wrap gap-2">
                                        @foreach ($task->assets as $asset)
                                            <div class="image-preview" data-id="{{ $asset->id }}">
                                                <img src="{{ asset('storage/' . $asset->image_path) }}" alt="task-image">
                                                <button type="button" class="remove-btn" data-id="{{ $asset->id }}">&times;</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12 mt-3 text-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($task) ? 'Update Task' : 'Create Task' }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quill CSS & JS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Quill Init
        var fonts = ['poppins'];
        var Font = Quill.import('formats/font');
        Font.whitelist = fonts;
        Quill.register(Font, true);

        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{'font': fonts}],
                    [{'header': [1, 2, 3, 4, 5, 6, false]}],
                    ['bold', 'italic', 'underline'],
                    [{'list': 'ordered'}, {'list': 'bullet'}]
                ]
            }
        });

        var hiddenDescription = document.getElementById('description');
        quill.on('text-change', function() {
            hiddenDescription.value = quill.root.innerHTML;
        });

        // Multiple Image Preview (New Uploads)
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('preview-container');
        let filesArray = [];

        imageInput.addEventListener('change', (e) => {
            const newFiles = Array.from(e.target.files);
            filesArray = filesArray.concat(newFiles);
            renderPreviews();
        });

        function renderPreviews() {
            previewContainer.innerHTML = "";
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
            if (e.target.classList.contains("remove-btn")) {
                const index = e.target.dataset.index;
                filesArray.splice(index, 1);
                renderPreviews();
            }
        });

        function updateInputFiles() {
            const dataTransfer = new DataTransfer();
            filesArray.forEach((file) => dataTransfer.items.add(file));
            imageInput.files = dataTransfer.files;
        }

        // Remove Existing Image (AJAX)
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-btn") && e.target.dataset.id) {
                let assetId = e.target.dataset.id;
                fetch(`/tasks/assets/${assetId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Accept": "application/json"
                    }
                }).then(res => res.json())
                  .then(data => {
                      if (data.success) {
                          e.target.closest(".image-preview").remove();
                      }
                  });
            }
        });
    </script>
@endsection

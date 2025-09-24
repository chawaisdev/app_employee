@extends('layouts.app')

@section('title', 'Create Task')

@section('body')
    <style>
        .image-preview {
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
    </style>

    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow p-4">
                    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Task Title</label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                    placeholder="Enter task title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="is_status" class="form-label">Task Status</label>
                                <select name="is_status" id="is_status"
                                    class="form-select @error('is_status') is-invalid @enderror" required>
                                    <option value="pending"
                                        {{ old('is_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ongoing" {{ old('is_status') == 'ongoing' ? 'selected' : '' }}>Ongoing
                                    </option>
                                    <option value="complete" {{ old('is_status') == 'complete' ? 'selected' : '' }}>Complete
                                    </option>
                                </select>
                                @error('is_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="project_id" class="form-label">Select Project</label>
                                <select name="project_id" id="project_id"
                                    class="form-select @error('project_id') is-invalid @enderror" required>
                                    <option value="">-- Select Project --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="editor">Write Your Note</label>
                                <div id="editor" style="height: 250px;">{!! old('description') !!}</div>
                                <input type="hidden" name="description" id="description" value="{{ old('description') }}">
                            </div>

                            <div class="col-md-12">
                                <label for="images" class="form-label">Upload Images</label>
                                <input type="file" name="images[]" id="images"
                                    class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                                <div id="preview-container" class="d-flex flex-wrap gap-2 mt-2"></div>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Create Task</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
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

        // Populate editor with old description if available
        var hiddenDescription = document.getElementById('description');
        if (hiddenDescription.value) {
            quill.root.innerHTML = hiddenDescription.value;
        }

        // Update hidden input on text change
        quill.on('text-change', function() {
            hiddenDescription.value = quill.root.innerHTML;
        });

        // Also ensure value is set before submit (safety)
        document.querySelector('form').addEventListener('submit', function() {
            hiddenDescription.value = quill.root.innerHTML;
        });

        // Image previews remain same
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
    </script>

@endsection

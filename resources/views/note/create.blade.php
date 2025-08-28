@extends('layouts.app')

@section('title')
    Note Create
@endsection

@section('body')
    <style>
        .ql-font span[data-label="poppins"]::before {
            font-family: 'Poppins', sans-serif;
        }

        .ql-font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        #upload-box {
            transition: all 0.3s ease;
        }

        #upload-box:hover {
            background: #f8f9fa;
            border-color: #0d6efd;
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .image-preview {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 14px;
            cursor: pointer;
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
                    <form id="note-form" action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="editor">Write Your Note</label>
                            <div id="editor" style="height: 250px;"></div>
                            <input type="hidden" name="content" id="content">
                        </div>

                        <div class="form-group mb-3">
                            <label for="images">Upload Images</label>
                            <input type="file" class="form-control d-none" id="images" name="images[]" multiple
                                accept="image/*">

                            <div id="upload-box"
                                class="border border-2 border-dashed rounded-3 p-4 text-center cursor-pointer">
                                <p class="mb-1">Click or Drag & Drop Images Here</p>
                                <small class="text-muted">Supported: JPG, PNG, JPEG</small>
                            </div>
                        </div>

                        <div id="preview-container" class="image-preview-container"></div>

                        <button type="submit" class="btn btn-primary mt-3">Add Note</button>
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
                        'font': ['poppins']
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

        // Sync content to hidden input before submission
        var form = document.getElementById('note-form');
        form.addEventListener('submit', function(event) {
            var content = quill.root.innerHTML;
            var contentInput = document.getElementById('content');
            contentInput.value = content;
            console.log('Submitting form with content:', content); // Debug
            console.log('Hidden input value:', contentInput.value); // Debug
        });

        // Debug: Log content changes in real-time
        quill.on('text-change', function() {
            console.log('Quill content changed:', quill.root.innerHTML);
        });

        const imageInput = document.getElementById('images');
        const uploadBox = document.getElementById('upload-box');
        const previewContainer = document.getElementById('preview-container');
        let filesArray = [];

        uploadBox.addEventListener("click", () => imageInput.click());

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
                        <button class="remove-btn" data-index="${index}">&times;</button>
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

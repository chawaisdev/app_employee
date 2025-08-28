@extends('layouts.app')

@section('title')
    Note Edit
@endsection

@section('body')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">Edit Note</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white shadow p-4">
                <form id="note-form" action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Quill Editor --}}
                    <div class="form-group mb-3">
                        <label for="editor">Edit Your Note</label>
                        <div id="editor" style="height: 250px;"></div>
                        <input type="hidden" name="content" id="content">
                    </div>

                    {{-- Upload Images --}}
                    <div class="form-group mb-3">
                        <label for="images">Upload Images</label>
                        <input type="file" class="form-control d-none" id="images" name="images[]" multiple accept="image/*">
                        <div id="upload-box" class="border border-2 border-dashed rounded-3 p-4 text-center cursor-pointer">
                            <p class="mb-1">Click or Drag & Drop Images Here</p>
                            <small class="text-muted">Supported: JPG, PNG, JPEG</small>
                        </div>
                    </div>

                    {{-- Image Preview --}}
                    <div id="preview-container" class="d-flex flex-wrap gap-2 mb-3"></div>

                    <button type="submit" class="btn btn-primary mt-3">Update Note</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Google Fonts & Quill --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<style>
    body { font-family: 'Poppins', sans-serif; }

    .ql-container {
        max-height: 300px;
        overflow-y: auto; /* Scrollbar if content is long */
    }

    #upload-box { transition: all 0.3s ease; cursor: pointer; }
    #upload-box:hover { background: #f8f9fa; border-color: #0d6efd; }

    .image-preview-container { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px; }
    .image-preview {
        position: relative;
        width: 120px; height: 120px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .image-preview img { width: 100%; height: 100%; object-fit: cover; }
    .remove-btn {
        position: absolute; top: 5px; right: 5px;
        background: rgba(0,0,0,0.7); color: white;
        border: none; border-radius: 50%;
        width: 24px; height: 24px; font-size: 14px; cursor: pointer;
    }
</style>

<script>
    // Initialize Quill
    var fonts = ['poppins'];
    var Font = Quill.import('formats/font');
    Font.whitelist = fonts;
    Quill.register(Font, true);

    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{'font': ['poppins']}],
                [{'header': [1,2,3,4,5,6,false]}],
                ['bold','italic','underline'],
                [{'list':'ordered'},{'list':'bullet'}]
            ]
        }
    });

    // Set existing content
    quill.root.innerHTML = `{!! addslashes($note->content) !!}`;

    // Handle form submit
    var form = document.getElementById('note-form');
    form.addEventListener('submit', function(){
        document.getElementById('content').value = quill.root.innerHTML;
    });

    // Image Preview & Handling
    const imageInput = document.getElementById('images');
    const uploadBox = document.getElementById('upload-box');
    const previewContainer = document.getElementById('preview-container');

    let filesArray = [];

    // Load existing images from DB
    @php
        $existingImages = json_decode($note->images, true) ?? [];
    @endphp
    filesArray = @json($existingImages);
    renderPreviews();

    uploadBox.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', e => {
        const newFiles = Array.from(e.target.files);
        filesArray = filesArray.concat(newFiles);
        renderPreviews();
    });

    function renderPreviews() {
        previewContainer.innerHTML = '';
        filesArray.forEach((file, index) => {
            const div = document.createElement('div');
            div.classList.add('image-preview');

            if(file instanceof File){
                const reader = new FileReader();
                reader.onload = e => {
                    div.innerHTML = `<img src="${e.target.result}" alt="preview">
                                     <button type="button" class="remove-btn" data-index="${index}">&times;</button>
                                     <input type="hidden" name="existing_images[]" value="">`;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            } else {
                div.innerHTML = `<img src="{{ asset('storage/') }}/${file}" alt="preview">
                                 <button type="button" class="remove-btn" data-index="${index}">&times;</button>
                                 <input type="hidden" name="existing_images[]" value="${file}">`;
                previewContainer.appendChild(div);
            }
        });
        updateInputFiles();
    }

    previewContainer.addEventListener('click', e => {
        if(e.target.classList.contains('remove-btn')){
            const index = e.target.dataset.index;
            filesArray.splice(index, 1);
            renderPreviews();
        }
    });

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => {
            if(file instanceof File) dataTransfer.items.add(file);
        });
        imageInput.files = dataTransfer.files;
    }
</script>
@endsection

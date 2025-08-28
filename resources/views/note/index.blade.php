@extends('layouts.app')

@section('title')
    Notes Index
@endsection

@section('body')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .note-content {
            font-size: 1rem;
            color: #333;
        }

        .note-image {
            border-radius: 5px;
            border: 1px solid #e9ecef;
            transition: transform 0.2s ease;
        }

        .note-image:hover {
            transform: scale(1.05);
        }
    </style>
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notes Index</li>
                </ol>
            </nav>
            <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">
                Add Notes
            </a>
        </div>

        @if ($notes->isEmpty())
            <div class="alert alert-info text-center">
                No notes found. <a href="{{ route('notes.create') }}" class="alert-link">Create a new note</a>.
            </div>
        @else
            <div class="row justify-content-center g-4">
                @foreach ($notes as $note)
                    <div class="col-md-6">
                        <div class="card p-3 border">
                            {{-- Note Content --}}
                            <div class="note-content mb-3">{!! $note->content !!}</div>

                            {{-- Note Images --}}
                            @php
                                $images = [];
                                if (!empty($note->images)) {
                                    $images = is_array($note->images)
                                        ? $note->images
                                        : json_decode($note->images, true) ?? [];
                                }
                            @endphp

                            @if (count($images) > 0)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Note Image" class="note-image"
                                            style="width:100px; height:100px; object-fit:cover; cursor:pointer;"
                                            onclick="previewImage(this.src)">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Image Preview Overlay --}}
    <div id="imagePreviewOverlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
        background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:9999;">
        <img id="previewImg" src="" style="max-width:90%; max-height:90%; border-radius:8px;">
    </div>

    <script>
        function previewImage(src) {
            const overlay = document.getElementById('imagePreviewOverlay');
            const preview = document.getElementById('previewImg');
            preview.src = src;
            overlay.style.display = 'flex';

            overlay.onclick = () => {
                overlay.style.display = 'none';
            }
        }
    </script>
@endsection

@extends('layouts.master')

@section('title', 'Edit Page')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Edit Page</h3>
            <a href="{{ route('admin.storefront.pages') }}" class="select-btn-white">
                <i class="fas fa-arrow-left me-2"></i>Back to Pages
            </a>
        </div>
    </div>

    <form action="{{ route('admin.storefront.pages.update', $page->id) }}" method="POST" id="pageBuilderForm">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Page Builder</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Page Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">/</span>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label mb-0">Quick Insert</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="select-btn-white" id="btnAddHero">Hero Image</button>
                                    <button type="button" class="select-btn-white" id="btnAddImageText">Image + Text</button>
                                    <button type="button" class="select-btn-white" id="btnAddGallery">Gallery</button>
                                    <button type="button" class="select-btn-white" id="btnAddText">Text</button>
                                    <button type="button" class="select-btn-white" id="btnAddBanner">Banner CTA</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="15" id="pageContent">{{ old('content', $page->content) }}</textarea>
                        @if($page->slug === 'terms-and-conditions' && (!$page->content || empty(trim(strip_tags($page->content)))) )
                            <div class="alert alert-info mt-2">
                                <strong>System Terms & Conditions</strong><br>
                                Example: "By using this site, you agree to our terms and conditions. All purchases are subject to our policies. Please review carefully before ordering."
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card border-0 mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0 fw-bold">Publish</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="0" {{ !$page->status ? 'selected' : '' }}>Draft</option>
                                        <option value="1" {{ $page->status ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                                <button type="submit" class="create-btn-base w-100">
                                    <i class="fas fa-save me-2"></i>Update Page
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card border-0 mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0 fw-bold">SEO Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script src="https://cdn.tiny.cloud/1/r2met6mrh50htc9yymzlqn3o0rbrfr511tjh46e0ucvylnq5/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    tinymce.init({
        selector: '#pageContent',
        plugins: 'link image media table lists code',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | table | code',
        menubar: false,
        height: 600,
        automatic_uploads: true,
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function() {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        },
        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
            const fd = new FormData();
            fd.append('image', blobInfo.blob(), blobInfo.filename());
            fetch('{{ route('admin.storefront.pages.upload_image') }}', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: fd
            }).then(r => r.json()).then(d => {
                if (d && d.url) resolve(d.url); else reject('Upload failed');
            }).catch(() => reject('Upload failed'));
        })
    });
    function insert(content) {
        var ed = tinymce.activeEditor;
        if (ed) ed.insertContent(content);
    }
    document.getElementById('btnAddHero')?.addEventListener('click', function() {
        insert('<div class="my-4"><img src="" alt="" style="width:100%;height:auto;"></div>');
    });
    document.getElementById('btnAddImageText')?.addEventListener('click', function() {
        insert('<div class="row g-3 align-items-center my-4"><div class="col-md-6"><img src="" alt="" style="width:100%;height:auto;"></div><div class="col-md-6"><h2>Title</h2><p>Write your text here.</p><a class="btn btn-primary" href="#">Button</a></div></div>');
    });
    document.getElementById('btnAddGallery')?.addEventListener('click', function() {
        insert('<div class="row g-3 my-4"><div class="col-6 col-md-4"><img src="" alt="" style="width:100%;height:auto;"></div><div class="col-6 col-md-4"><img src="" alt="" style="width:100%;height:auto;"></div><div class="col-6 col-md-4"><img src="" alt="" style="width:100%;height:auto;"></div></div>');
    });
    document.getElementById('btnAddText')?.addEventListener('click', function() {
        insert('<div class="my-4"><h2>Heading</h2><p>Write your text here.</p></div>');
    });
    document.getElementById('btnAddBanner')?.addEventListener('click', function() {
        insert('<div class="p-5 my-4 text-center bg-light rounded-3"><h2>Banner Title</h2><p>Banner description text.</p><a class="btn btn-primary" href="#">Shop Now</a></div>');
    });
});
</script>
@endpush
@endsection

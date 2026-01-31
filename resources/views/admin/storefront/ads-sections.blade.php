@extends('layouts.master')

@section('title', 'Ads Sections')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="py-3 mb-0 fw-bold">Ads Sections</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdsModal">
            <i class="bx bx-plus me-1"></i> Add New Ad
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Ads Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Link</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($ads_sections as $banner)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="Ad Image" class="rounded d-block" height="50">
                            </td>
                            <td>
                                @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank">{{ Str::limit($banner->link, 30) }}</a>
                                @else
                                <span class="text-muted">No Link</span>
                                @endif
                            </td>
                            <td>{{ $banner->position }}</td>
                            <td>
                                @if($banner->status)
                                <span class="badge bg-label-success">Active</span>
                                @else
                                <span class="badge bg-label-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-outline-primary" onclick='editAds(@json($banner))' data-bs-toggle="modal" data-bs-target="#editAdsModal">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('admin.storefront.banners.destroy', $banner->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Are you sure you want to delete this ad?')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No ads found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Ads Modal -->
<div class="modal fade" id="addAdsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Ad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.storefront.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="ads_section">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" required accept="image/*">
                            <div class="form-text">Recommended size: Depends on your grid layout.</div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Link</label>
                            <input type="url" name="link" class="form-control" placeholder="https://example.com/collection">
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Position</label>
                            <input type="number" name="position" class="form-control" value="0" min="0">
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label d-block">Status</label>
                            <div class="mt-2 form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Ad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Ads Modal -->
<div class="modal fade" id="editAdsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Ad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAdsForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="ads_section">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label class="form-label">Current Image</label>
                            <div class="mb-2">
                                <img id="editAdsImagePreview" src="" alt="Current Image" class="rounded d-block w-100" style="max-height: 200px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text">Leave empty to keep current image.</div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Link</label>
                            <input type="url" name="link" id="editAdsLink" class="form-control">
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Position</label>
                            <input type="number" name="position" id="editAdsPosition" class="form-control" min="0">
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label d-block">Status</label>
                            <div class="mt-2 form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="editAdsStatus">
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Ad</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editAds(banner) {
        document.getElementById('editAdsForm').action = "{{ route('admin.storefront.banners.update', ':id') }}".replace(':id', banner.id);
        document.getElementById('editAdsImagePreview').src = "{{ asset('storage/') }}/" + banner.image;
        document.getElementById('editAdsLink').value = banner.link || '';
        document.getElementById('editAdsPosition').value = banner.position;
        document.getElementById('editAdsStatus').checked = banner.status;
    }
</script>
@endpush
@endsection

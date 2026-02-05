@extends('layouts.master')

@section('title', 'Banners & Sliders')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Banners & Sliders</h3>
            <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                <span class="material-symbols-outlined fs-14">add</span> Add Banner
            </button>
        </div>
    </div>

    <!-- Hero Sliders -->
    <div class="col-12 mb-4">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Hero Sliders</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($hero_sliders as $slider)
                    <div class="col-md-4">
                        <div class="border rounded p-2 position-relative group-action">
                            <img src="{{ asset('storage/' . $slider->image) }}" class="img-fluid rounded" alt="Slider">
                            <div class="position-absolute top-0 start-0 p-2">
                                <span class="badge bg-dark opacity-75">{{ ucfirst($slider->theme ?? 'all') }}</span>
                            </div>
                            <div class="position-absolute top-0 end-0 p-2 d-none group-action-show">
                                <button class="btn btn-sm btn-light rounded-circle shadow-sm" onclick='editBanner(@json($slider))'><i class="bx bx-edit"></i></button>
                                <form action="{{ route('admin.storefront.banners.destroy', $slider->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-circle shadow-sm" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center d-flex flex-column align-items-center justify-content-center h-100" style="border-style: dashed !important; min-height: 200px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addBannerModal" onclick="$('#bannerType').val('hero_slider')">
                            <span class="material-symbols-outlined fs-1 text-muted d-block mb-2">add_photo_alternate</span>
                            <p class="mb-2 text-muted">Add Slider Image</p>
                            <small class="text-muted">Recommended: 1920x600px</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ads Section -->
    <div class="col-12 mb-4">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Ads Section (Grid Layout)</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($ads_sections as $banner)
                    <div class="col-md-4">
                        <div class="border rounded p-2 position-relative group-action">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid rounded" alt="Ads Banner">
                            <div class="position-absolute top-0 start-0 p-2">
                                <span class="badge bg-dark opacity-75">{{ ucfirst($banner->theme ?? 'all') }}</span>
                            </div>
                            <div class="position-absolute top-0 end-0 p-2 d-none group-action-show">
                                <button class="btn btn-sm btn-light rounded-circle shadow-sm" onclick='editBanner(@json($banner))'><i class="bx bx-edit"></i></button>
                                <form action="{{ route('admin.storefront.banners.destroy', $banner->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-circle shadow-sm" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
                                </form>
                            </div>
                            <div class="mt-2">
                                <small class="d-block text-muted">Position: {{ $banner->position }}</small>
                                <small class="d-block text-truncate"><a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center d-flex flex-column align-items-center justify-content-center h-100" style="border-style: dashed !important; min-height: 200px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addBannerModal" onclick="$('#bannerType').val('ads_section')">
                            <span class="material-symbols-outlined fs-1 text-muted d-block mb-2">add_photo_alternate</span>
                            <p class="mb-2 text-muted">Add Ads Banner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotional Banners -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Promotional Banners</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Preview</th>
                                <th>Title</th>
                                <th>Theme</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Clicks</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($promotional_banners as $banner)
                            <tr>
                                <td class="ps-3">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner" style="height: 50px; width: auto;" class="rounded">
                                </td>
                                <td>{{ $banner->title ?? 'N/A' }}</td>
                                <td><span class="badge bg-info text-dark">{{ ucfirst($banner->theme ?? 'all') }}</span></td>
                                <td>{{ $banner->position }}</td>
                                <td>
                                    @if($banner->status)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $banner->clicks }}</td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-light" onclick='editBanner(@json($banner))'><i class="bx bx-edit"></i></button>
                                    <form action="{{ route('admin.storefront.banners.destroy', $banner->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">image</span>
                                        <p class="mb-0">No banners found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Sections -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Store Sections (Homepage)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Preview</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Theme</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($store_sections as $section)
                            <tr>
                                <td class="ps-3">
                                    <img src="{{ asset('storage/' . $section->image) }}" alt="Section" style="height: 50px; width: auto;" class="rounded">
                                </td>
                                <td><strong>{{ $section->title ?? 'N/A' }}</strong></td>
                                <td>
                                    @if($section->link)
                                        <small class="text-muted">{{ substr($section->link, 0, 40) }}...</small>
                                    @else
                                        <small class="text-danger">No link</small>
                                    @endif
                                </td>
                                <td><span class="badge bg-info text-dark">{{ ucfirst($section->theme ?? 'all') }}</span></td>
                                <td>{{ $section->position }}</td>
                                <td>
                                    @if($section->status)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-light" onclick='editBanner(@json($section))'><i class="bx bx-edit"></i></button>
                                    <form action="{{ route('admin.storefront.banners.destroy', $section->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">image</span>
                                        <p class="mb-0">No store sections yet. <a href="#addBannerModal" data-bs-toggle="modal" class="text-primary">Add one</a></p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addBannerModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="bannerForm" action="{{ route('admin.storefront.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Add Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" id="bannerType" class="form-select" onchange="updateImageRecommendation()">
                            <option value="hero_slider">Hero Slider</option>
                            <option value="promotional_banner">Promotional Banner</option>
                            <option value="store_section">Store Section</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="bannerTitle" class="form-control" placeholder="e.g. Summer Sale">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link (Optional)</label>
                        <input type="url" name="link" id="bannerLink" class="form-control" placeholder="https://...">
                                            <small class="text-muted">Leave empty if you don't want a link</small>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="bannerStatus" name="status" value="1" checked>
                        <label class="form-check-label" for="bannerStatus">Active</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Theme</label>
                        <select name="theme" id="bannerTheme" class="form-select">
                            <option value="all">All Themes</option>
                            <option value="theme1">Theme 1 (Default)</option>
                            <option value="theme2">Theme 2 (Red/Gold)</option>
                        </select>
                        <small class="text-muted">Select which theme this banner should appear on</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <input type="number" name="position" id="bannerPosition" class="form-control" value="0">
                                            <small class="text-muted">Lower numbers appear first</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" id="bannerImage" class="form-control" accept="image/*" required>
                        <small class="text-muted d-block mt-1" id="imageRecommendation">Recommended size: 1920x600px for Sliders, 800x400px for Banners</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="create-btn-base">Save Banner</button>
                </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.edit-banner-btn', function() {
        const banner = $(this).data('banner');
        editBanner(banner);
    });

    function editBanner(banner) {
        $('#modalTitle').text('Edit Banner');
        $('#bannerForm').attr('action', '{{ url("admin/storefront/banners") }}' + '/' + banner.id);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        $('#bannerType').val(banner.type);
        $('#bannerTitle').val(banner.title);
        $('#bannerLink').val(banner.link);
        $('#bannerTheme').val(banner.theme || 'all');
        $('#bannerPosition').val(banner.position);

        // Handle Status
        if (banner.status) {
            $('#bannerStatus').prop('checked', true);
        } else {
            $('#bannerStatus').prop('checked', false);
        }

        // Image is optional on update
        $('#bannerImage').removeAttr('required');

        $('#addBannerModal').modal('show');
        updateImageRecommendation();
    }

    $('#addBannerModal').on('hidden.bs.modal', function () {
        $('#modalTitle').text('Add Banner');
        $('#bannerForm').attr('action', '{{ route("admin.storefront.banners.store") }}');
        $('#methodField').empty();
        $('#bannerForm')[0].reset();
        $('#bannerImage').attr('required', 'required');
        $('#bannerType').val('hero_slider');
        updateImageRecommendation();
    });

    function updateImageRecommendation() {
        const type = $('#bannerType').val();
        let recommendation = '';

        if (type === 'hero_slider') {
            recommendation = 'Recommended size: 1920x600px';
        } else if (type === 'promotional_banner') {
            recommendation = 'Recommended size: 800x400px';
        } else if (type === 'store_section') {
            recommendation = 'Recommended size: 600x400px (Square or nearly square images work best)';
        }

        $('#imageRecommendation').text(recommendation);
    }
</script>
<style>
    .group-action:hover .group-action-show {
        display: block !important;
    }
</style>
@endpush

@extends('layouts.master')
@section('title', 'All Products')

@push('styles')
<style>
    /* Products Card - Using base card styling */
    .products-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .products-card .card-header {
        background: linear-gradient(135deg, #7367f0 0%, #4A2A85 100%);
        padding: 20px 25px;
        border: none;
    }
    
    .products-card .card-header h4 {
        color: #fff;
        font-weight: 600;
        margin: 0;
    }
    
    .products-card .card-header p {
        color: rgba(255, 255, 255, 0.8);
        margin: 5px 0 0;
        font-size: 13px;
    }
    
    /* Products Table */
    .products-table { margin: 0; }
    .products-table thead { background: #f8f9fc; }
    .products-table thead th {
        border: none;
        padding: 15px 20px;
        font-weight: 600;
        color: #5a5c69;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .products-table tbody tr { transition: all 0.2s ease; }
    .products-table tbody tr:hover { background: #f8f9fc; }
    .products-table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #eaecf4;
    }
    
    /* Product Info - Using qbit-bms-style classes */
    .product-info { display: flex; align-items: center; gap: 12px; }
    .product-thumb {
        width: 50px; height: 50px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #eaecf4;
    }
    .product-thumb-placeholder {
        width: 50px; height: 50px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        display: flex; align-items: center; justify-content: center;
        color: #b0b5c0;
    }
    .product-name {
        font-weight: 600; color: #2d3748;
        margin-bottom: 2px; max-width: 200px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .product-sku { font-size: 11px; color: #a0aec0; }
    
    /* Badge Styles - Using qbit-badge classes from qbit-bms-style.css */
    
    /* Status Toggle */
    .status-toggle-wrapper { display: flex; align-items: center; gap: 8px; }
    .product-toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; }
    .product-toggle-switch input { opacity: 0; width: 0; height: 0; }
    .product-slider {
        position: absolute; cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #e2e8f0;
        transition: .3s; border-radius: 24px;
    }
    .product-slider:before {
        position: absolute; content: "";
        height: 18px; width: 18px; left: 3px; bottom: 3px;
        background-color: white; transition: .3s;
        border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    input:checked + .product-slider { background: linear-gradient(135deg, #7367f0 0%, #4A2A85 100%); }
    input:checked + .product-slider:before { transform: translateX(20px); }
    
    /* Info Badges - Media counts */
    .info-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 8px;
        font-size: 12px; font-weight: 500;
        cursor: pointer; transition: all 0.2s; border: none;
    }
    .info-badge-images {
        background: rgba(27, 132, 255, 0.1);
        color: #1B84FF;
        border: 1px solid rgba(27, 132, 255, 0.2);
    }
    .info-badge-images:hover { background: rgba(27, 132, 255, 0.2); }
    .info-badge-variants {
        background: rgba(115, 103, 240, 0.1);
        color: #7367f0;
        border: 1px solid rgba(115, 103, 240, 0.2);
    }
    .info-badge-variants:hover { background: rgba(115, 103, 240, 0.2); }
    
    /* Search Box */
    .search-box { position: relative; }
    .search-box input {
        padding: 12px 20px 12px 45px;
        border: 2px solid #eaecf4;
        border-radius: 12px; width: 300px;
        transition: all 0.3s;
    }
    .search-box input:focus {
        border-color: #7367f0;
        box-shadow: 0 0 0 4px rgba(115, 103, 240, 0.1);
        outline: none;
    }
    .search-box .search-icon {
        position: absolute; left: 15px; top: 50%;
        transform: translateY(-50%); color: #a0aec0;
    }
    
    /* Empty State */
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state-icon {
        width: 80px; height: 80px; border-radius: 50%;
        background: #f8f9fc;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
    .empty-state-icon i { font-size: 36px; color: #a0aec0; }
    .empty-state h5 { color: #2d3748; font-weight: 600; margin-bottom: 8px; }
    .empty-state p { color: #718096; margin-bottom: 20px; }
    
    /* Modal Styles */
    .modal-content { border: none; border-radius: 15px; }
    .modal-header {
        background: linear-gradient(135deg, #7367f0 0%, #4A2A85 100%);
        border-radius: 15px 15px 0 0; padding: 20px 25px;
    }
    .modal-header .modal-title { color: #fff; font-weight: 600; }
    .modal-header .btn-close { filter: brightness(0) invert(1); }
    
    #productImagesContainer img {
        width: 120px; height: 120px;
        object-fit: cover; border-radius: 12px;
        border: 2px solid #eaecf4; transition: all 0.3s;
    }
    #productImagesContainer img:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    /* Product Details Modal */
    .product-details-modal .modal-body { max-height: 70vh; overflow-y: auto; }
    .product-detail-wrapper { display: grid; grid-template-columns: 400px 1fr; gap: 0; }
    @media (max-width: 992px) { .product-detail-wrapper { grid-template-columns: 1fr; } }
    .product-gallery { background: #f8f9fc; padding: 30px; border-right: 1px solid #eaecf4; }
    .product-main-image {
        width: 100%; aspect-ratio: 1; border-radius: 15px;
        overflow: hidden; background: #fff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); margin-bottom: 15px;
    }
    .product-main-image img { width: 100%; height: 100%; object-fit: contain; }
    .product-thumbnails { display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; }
    .product-thumb-item {
        width: 70px; height: 70px; border-radius: 10px;
        overflow: hidden; cursor: pointer;
        border: 2px solid transparent; transition: all 0.3s;
    }
    .product-thumb-item:hover, .product-thumb-item.active {
        border-color: #7367f0;
        box-shadow: 0 4px 12px rgba(115, 103, 240, 0.3);
    }
    .product-thumb-item img { width: 100%; height: 100%; object-fit: cover; }
    .product-info-section { padding: 30px; }
    .product-badges { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
    .product-detail-title { font-size: 24px; font-weight: 700; color: #2d3748; margin-bottom: 10px; line-height: 1.3; }
    .product-sku-detail { font-size: 14px; color: #718096; margin-bottom: 20px; }
    .product-sku-detail code { background: #f1f5f9; padding: 4px 10px; border-radius: 5px; color: #7367f0; }
    .product-price-section {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef2ff 100%);
        border-radius: 12px; padding: 20px; margin-bottom: 25px;
    }
    .product-price-current { font-size: 32px; font-weight: 800; color: #7367f0; }
    .product-price-original { font-size: 18px; color: #a0aec0; text-decoration: line-through; margin-left: 10px; }
    .product-price-discount { background: #ef4444; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-left: 15px; }
    .product-meta-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px; }
    .product-meta-item { background: #f8f9fc; padding: 15px; border-radius: 10px; }
    .product-meta-label { font-size: 12px; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
    .product-meta-value { font-size: 16px; font-weight: 600; color: #2d3748; }
    .product-description-section { margin-bottom: 25px; }
    .product-description-section h6 { font-size: 14px; font-weight: 600; color: #5a5c69; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .product-description-section h6 i { color: #7367f0; }
    .product-description-text { color: #4a5568; line-height: 1.7; font-size: 14px; }
    .product-variants-section { border-top: 1px solid #eaecf4; padding-top: 20px; }
    .variant-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 15px; background: #f8f9fc; border-radius: 8px; margin-bottom: 10px; }
    .variant-name { font-weight: 600; color: #2d3748; }
    .variant-details { display: flex; gap: 20px; font-size: 14px; color: #718096; }
    .product-loading { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 80px 20px; }
    .product-loading .spinner-border { width: 50px; height: 50px; border-width: 4px; }
    .no-image-placeholder { width: 100%; height: 300px; background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 15px; }
    .no-image-placeholder i { font-size: 60px; color: #b0b5c0; margin-bottom: 15px; }
    .no-image-placeholder p { color: #718096; }
</style>
@endpush

@section('content')
<div class="row">
    <!-- Page Header -->
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">All Products</h3>
                <p class="text-muted mb-0">Manage and organize your product catalog</p>
            </div>
            <a href="{{ route('admin.product-create.index') }}" class="create-btn-base d-flex align-items-center gap-2">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </div>
    </div>

    <!-- Stats Row - Using custom counter styles -->
    @php
        $totalCount = is_countable($products) ? count($products) : 0;
        $activeCount = 0;
        $inactiveCount = 0;
        if ($products) {
            foreach ($products as $prod) {
                if (isset($prod->status) && strtolower($prod->status) === 'active') {
                    $activeCount++;
                } else {
                    $inactiveCount++;
                }
            }
        }
    @endphp
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="custom-counter-inner counter-bg-1">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(75, 137, 220, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="fas fa-box fs-20" style="color: #4B89DC;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $totalCount }}</h3>
                    <p class="mb-0 fs-13 text-muted">Total Products</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="custom-counter-inner counter-bg-2">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(140, 192, 82, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="fas fa-check-circle fs-20" style="color: #8CC052;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $activeCount }}</h3>
                    <p class="mb-0 fs-13 text-muted">Active Products</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="custom-counter-inner counter-bg-3">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(59, 174, 218, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="fas fa-times-circle fs-20" style="color: #3BAEDA;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $inactiveCount }}</h3>
                    <p class="mb-0 fs-13 text-muted">Inactive Products</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="col-12">
        <div class="card products-card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h4><i class="fas fa-boxes me-2"></i>Product List</h4>
                    <p class="mb-0">View and manage all your products</p>
                </div>
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Search products..." id="productTitleSearch">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table products-table" id="productsTable">
                        <thead>
                            <tr>
                                <th style="width: 60px;">SL</th>
                                <th>Product</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Media</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $p)
                            <tr>
                                <td>
                                    <span class="qbit-badge-gray">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="product-info">
                                        @php
                                            $coverImg = null;
                                            if (isset($p->id)) {
                                                $images = \DB::table('product_images')
                                                    ->where('product_id', $p->id)
                                                    ->get();
                                                $coverImg = $images->where('is_cover', 1)->first() ?? $images->first();
                                            }
                                        @endphp
                                        @if($coverImg && $coverImg->path)
                                            <img src="{{ asset('storage/' . $coverImg->path) }}" alt="{{ $p->title }}" class="product-thumb">
                                        @else
                                            <div class="product-thumb-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="product-name" title="{{ $p->title }}">{{ $p->title }}</div>
                                            <div class="product-sku">SKU: {{ $p->sku ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($p->brand_name)
                                        <span class="qbit-badge-purple"><i class="bx bx-tag"></i> {{ $p->brand_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->category_name)
                                        <span class="qbit-badge-info"><i class="bx bx-folder"></i> {{ $p->category_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="status-toggle-wrapper">
                                        <label class="product-toggle-switch">
                                            <input type="checkbox" class="product-status-toggle"
                                                data-product-id="{{ $p->id }}"
                                                {{ strtolower($p->status) === 'active' ? 'checked' : '' }}>
                                            <span class="product-slider"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="info-badge info-badge-images btn-view-images" data-product-id="{{ $p->id }}">
                                            <i class="fas fa-image"></i>
                                            <span>{{ $p->images_count ?? 0 }}</span>
                                        </button>
                                        <button class="info-badge info-badge-variants btn-view-variants" data-product-id="{{ $p->id }}">
                                            <i class="fas fa-layer-group"></i>
                                            <span>{{ $p->variants_count ?? 0 }}</span>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <button type="button" class="action-btn-info btn-view-product" data-product-id="{{ $p->id }}" title="View Product">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.product.edit', $p->id) }}" class="action-btn-success" title="Edit Product">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.product.destroy', $p->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="action-btn-danger btn-delete" title="Delete Product">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <h5>No Products Found</h5>
                                        <p>Start by adding your first product to the catalog</p>
                                        <a href="{{ route('admin.product-create.index') }}" class="create-btn-base">
                                            <i class="fas fa-plus me-2"></i>Add Product
                                        </a>
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

<!-- Modal for Viewing Images -->
<div class="modal fade" id="productImagesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-images me-2"></i>Product Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="productImagesContainer" class="d-flex flex-wrap justify-content-center gap-3">
                    <!-- Images will load dynamically here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Variants -->
<div class="modal fade" id="productVariantsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-layer-group me-2"></i>Product Variants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="productVariantsContainer" class="table-responsive">
                    <!-- Variants will load dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Product Details -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content product-details-modal">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-box-open me-2"></i>Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="productDetailsContainer">
                    <!-- Product details will load dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="create-btn-white" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <a href="#" id="editProductBtn" class="create-btn-base">
                    <i class="fas fa-edit me-2"></i>Edit Product
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // DataTable Initialization
    var table = $('#productsTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Search products...",
            lengthMenu: "Show _MENU_ products",
            info: "Showing _START_ to _END_ of _TOTAL_ products",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        },
        dom: '<"top"l>rt<"bottom d-flex justify-content-between align-items-center"ip><"clear">',
        order: [[0, 'asc']]
    });

    // Custom search
    $('#productTitleSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Toggle Status
    document.querySelectorAll('.product-status-toggle').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const productId = this.dataset.productId;
            const status = this.checked ? 'active' : 'inactive';
            const token = "{{ csrf_token() }}";

            fetch(`/admin/product/update-status/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.ok) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message || 'Status updated successfully',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    // Reload the DataTable to update status display
                    $('#productsTable').DataTable().ajax.reload();
                } else {
                    this.checked = !this.checked;
                }
            })
            .catch(() => {
                this.checked = !this.checked;
            });
        });
    });

    // Delete Button
    document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            const productId = this.dataset.id;
            const token = "{{ csrf_token() }}";

            Swal.fire({
                title: "Delete Product?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#6b7280",
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Yes, delete it!',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/admin/delete-product/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message || 'Product deleted successfully', 'success');
                            $('#productsTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to delete product', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error!', 'Failed to delete product', 'error');
                    });
                }
            });
        });
    });

    // View Images Modal
    $(document).on('click', '.btn-view-images', function() {
        const productId = $(this).data('product-id');
        const modal = new bootstrap.Modal(document.getElementById('productImagesModal'));
        const container = $('#productImagesContainer');
        container.html('<div class="text-center w-100 py-5"><div class="spinner-border text-primary"></div><p class="mt-3 text-muted">Loading images...</p></div>');

        fetch(`/admin/product/${productId}/images`)
            .then(res => res.json())
            .then(data => {
                container.empty();
                if (data.images && data.images.length > 0) {
                    data.images.forEach(img => {
                        container.append(`<img src="${img.url}" alt="Product Image" class="m-2">`);
                    });
                } else {
                    container.html('<div class="text-center py-5"><i class="fas fa-image fa-3x text-muted mb-3"></i><p class="text-muted">No images available for this product.</p></div>');
                }
            })
            .catch(() => {
                container.html('<div class="text-center py-5 text-danger"><i class="fas fa-exclamation-circle fa-2x mb-3"></i><p>Failed to load images.</p></div>');
            });

        modal.show();
    });

    // View Variants Modal
    $(document).on('click', '.btn-view-variants', function() {
        const productId = $(this).data('product-id');
        const modal = new bootstrap.Modal(document.getElementById('productVariantsModal'));
        const container = $('#productVariantsContainer');
        container.html('<div class="text-center w-100 py-5"><div class="spinner-border text-primary"></div><p class="mt-3 text-muted">Loading variants...</p></div>');

        fetch(`/admin/product/${productId}/variants`)
            .then(res => res.json())
            .then(data => {
                container.empty();
                if (data.variants && data.variants.length > 0) {
                    let html = `
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Variant Name</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.variants.map(v => `
                                    <tr>
                                        <td class="fw-medium">${v.name}</td>
                                        <td><code>${v.sku ?? '-'}</code></td>
                                        <td>${v.price ? '৳' + v.price : '-'}</td>
                                        <td>${v.stock ?? '-'}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                    container.html(html);
                } else {
                    container.html('<div class="text-center py-5"><i class="fas fa-layer-group fa-3x text-muted mb-3"></i><p class="text-muted">No variants available for this product.</p></div>');
                }
            })
            .catch(() => {
                container.html('<div class="text-center py-5 text-danger"><i class="fas fa-exclamation-circle fa-2x mb-3"></i><p>Failed to load variants.</p></div>');
            });

        modal.show();
    });

    // View Product Details Modal
    $(document).on('click', '.btn-view-product', function() {
        const productId = $(this).data('product-id');
        const modal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
        const container = $('#productDetailsContainer');
        const editBtn = $('#editProductBtn');
        
        // Set edit button URL
        editBtn.attr('href', `/admin/product/${productId}/edit`);
        
        // Show loading state
        container.html(`
            <div class="product-loading">
                <div class="spinner-border text-primary mb-3"></div>
                <p class="text-muted">Loading product details...</p>
            </div>
        `);

        fetch(`/admin/product/${productId}/details`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.product) {
                    const p = data.product;
                    const images = data.images || [];
                    const variants = data.variants || [];
                    
                    let imagesHtml = '';
                    if (images.length > 0) {
                        imagesHtml = `
                            <div class="product-main-image" style="position: relative;">
                                <img src="${images[0].url}" alt="${p.title}" id="mainProductImage">
                                <button class="btn btn-sm btn-danger delete-image-btn" data-image-id="${images[0].id}" data-product-id="${p.id}" style="position: absolute; top: 10px; right: 10px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            ${images.length > 1 ? `
                                <div class="product-thumbnails">
                                    ${images.map((img, index) => `
                                        <div class="product-thumb-item ${index === 0 ? 'active' : ''}" data-image="${img.url}" style="position: relative;">
                                            <img src="${img.url}" alt="Thumbnail ${index + 1}">
                                            <button class="btn btn-sm btn-danger delete-image-btn" data-image-id="${img.id}" data-product-id="${p.id}" style="position: absolute; top: 2px; right: 2px; padding: 2px 4px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    `).join('')}
                                </div>
                            ` : ''}
                        `;
                    } else {
                        imagesHtml = `
                            <div class="no-image-placeholder">
                                <i class="fas fa-image"></i>
                                <p>No images available</p>
                            </div>
                        `;
                    }
                    
                    let variantsHtml = '';
                    if (variants.length > 0) {
                        variantsHtml = `
                            <div class="product-variants-section">
                                <h6><i class="fas fa-layer-group"></i> Product Variants (${variants.length})</h6>
                                ${variants.map(v => `
                                    <div class="variant-item">
                                        <span class="variant-name">${v.name}</span>
                                        <div class="variant-details">
                                            <span><i class="fas fa-barcode me-1"></i>${v.sku || 'N/A'}</span>
                                            <span><i class="fas fa-tag me-1"></i>৳${v.price || '0'}</span>
                                            <span><i class="fas fa-boxes me-1"></i>${v.stock || '0'} in stock</span>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        `;
                    }
                    
                    let priceHtml = '';
                    if (p.discount_price && p.discount_price < p.price) {
                        const discountPercent = Math.round((1 - p.discount_price / p.price) * 100);
                        priceHtml = `
                            <span class="product-price-current">৳${parseFloat(p.discount_price).toLocaleString()}</span>
                            <span class="product-price-original">৳${parseFloat(p.price).toLocaleString()}</span>
                            <span class="product-price-discount">${discountPercent}% OFF</span>
                        `;
                    } else {
                        priceHtml = `<span class="product-price-current">৳${parseFloat(p.price || 0).toLocaleString()}</span>`;
                    }
                    
                    const html = `
                        <div class="product-detail-wrapper">
                            <div class="product-gallery">
                                ${imagesHtml}
                            </div>
                            <div class="product-info-section">
                                <div class="product-badges">
                                    ${p.brand_name ? `<span class="qbit-badge-purple"><i class="bx bx-tag"></i> ${p.brand_name}</span>` : ''}
                                    ${p.category_name ? `<span class="qbit-badge-info"><i class="bx bx-folder"></i> ${p.category_name}</span>` : ''}
                                    <span class="qbit-badge-${(p.status && p.status.toLowerCase() === 'active') ? 'success' : 'warning'}">
                                        <i class="bx bx-${(p.status && p.status.toLowerCase() === 'active') ? 'check-circle' : 'x-circle'}"></i> ${p.status || 'Draft'}
                                    </span>
                                </div>
                                
                                <h2 class="product-detail-title">${p.title}</h2>
                                <p class="product-sku-detail">SKU: <code>${p.sku || 'N/A'}</code></p>
                                
                                <div class="product-price-section">
                                    ${priceHtml}
                                </div>
                                
                                <div class="product-meta-grid">
                                    <div class="product-meta-item">
                                        <div class="product-meta-label">Stock Quantity</div>
                                        <div class="product-meta-value">${p.stock_quantity || p.quantity || 0} units</div>
                                    </div>
                                    <div class="product-meta-item">
                                        <div class="product-meta-label">Status</div>
                                        <div class="product-meta-value">${p.status ? p.status.charAt(0).toUpperCase() + p.status.slice(1) : 'Draft'}</div>
                                    </div>
                                    <div class="product-meta-item">
                                        <div class="product-meta-label">Created</div>
                                        <div class="product-meta-value">${p.created_at ? new Date(p.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' }) : 'N/A'}</div>
                                    </div>
                                    <div class="product-meta-item">
                                        <div class="product-meta-label">Total Images</div>
                                        <div class="product-meta-value">${images.length} images</div>
                                    </div>
                                </div>
                                
                                ${p.short_description ? `
                                    <div class="product-description-section">
                                        <h6><i class="fas fa-align-left"></i> Short Description</h6>
                                        <p class="product-description-text">${p.short_description}</p>
                                    </div>
                                ` : ''}
                                
                                ${p.description ? `
                                    <div class="product-description-section">
                                        <h6><i class="fas fa-file-alt"></i> Full Description</h6>
                                        <div class="product-description-text">${p.description}</div>
                                    </div>
                                ` : ''}
                                
                                ${variantsHtml}
                            </div>
                        </div>
                    `;
                    
                    container.html(html);
                    
                    // Handle thumbnail clicks
                    $(document).on('click', '.product-thumb-item', function() {
                        const newImage = $(this).data('image');
                        $('#mainProductImage').attr('src', newImage);
                        $('.product-thumb-item').removeClass('active');
                        $(this).addClass('active');
                    });
                    
                } else {
                    container.html(`
                        <div class="product-loading">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <p class="text-muted">Product not found</p>
                        </div>
                    `);
                }
            })
            .catch(err => {
                console.error('Error:', err);
                container.html(`
                    <div class="product-loading">
                        <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                        <p class="text-danger">Failed to load product details</p>
                    </div>
                `);
            });

        modal.show();
    });

    // Delete Image
    $(document).on('click', '.delete-image-btn', function() {
        const imageId = $(this).data('image-id');
        const productId = $(this).data('product-id');
        const token = "{{ csrf_token() }}";

        Swal.fire({
            title: 'Delete Image?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/product/${productId}/image/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Deleted!', data.message, 'success');
                        // Reload the modal
                        $('.btn-view-product[data-product-id="' + productId + '"]').click();
                        // Reload the DataTable to update counts
                        $('#productsTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', data.message || 'Failed to delete image', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'Failed to delete image', 'error');
                });
            }
        });
    });
});
@endpush


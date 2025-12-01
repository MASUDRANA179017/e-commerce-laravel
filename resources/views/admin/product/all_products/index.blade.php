@extends('layouts.master')
@section('title', 'All Products')

@push('styles')
<style>
    /* Product Table Styles */
    .products-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .products-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    
    .products-table {
        margin: 0;
    }
    
    .products-table thead {
        background: #f8f9fc;
    }
    
    .products-table thead th {
        border: none;
        padding: 15px 20px;
        font-weight: 600;
        color: #5a5c69;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .products-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .products-table tbody tr:hover {
        background: #f8f9fc;
    }
    
    .products-table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #eaecf4;
    }
    
    /* Product Info Cell */
    .product-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .product-thumb {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #eaecf4;
    }
    
    .product-thumb-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b0b5c0;
    }
    
    .product-name {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 2px;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .product-sku {
        font-size: 11px;
        color: #a0aec0;
    }
    
    /* Badge Styles */
    .badge-brand {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
    }
    
    .badge-category {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
    }
    
    /* Status Toggle */
    .status-toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .status-label {
        font-size: 12px;
        font-weight: 500;
        color: #718096;
    }
    
    .product-toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    
    .product-toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .product-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e2e8f0;
        transition: .3s;
        border-radius: 24px;
    }
    
    .product-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    input:checked + .product-slider {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    input:checked + .product-slider:before {
        transform: translateX(20px);
    }
    
    /* Info Badges */
    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .info-badge-images {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .info-badge-images:hover {
        background: rgba(59, 130, 246, 0.2);
    }
    
    .info-badge-variants {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }
    
    .info-badge-variants:hover {
        background: rgba(139, 92, 246, 0.2);
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .action-btn i {
        font-size: 16px;
    }
    
    .action-btn-view {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    
    .action-btn-view:hover {
        background: #3b82f6;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    .action-btn-edit {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .action-btn-edit:hover {
        background: #10b981;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }
    
    .action-btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .action-btn-delete:hover {
        background: #ef4444;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }
    
    /* Search Box */
    .search-box {
        position: relative;
    }
    
    .search-box input {
        padding: 12px 20px 12px 45px;
        border: 2px solid #eaecf4;
        border-radius: 12px;
        width: 300px;
        transition: all 0.3s;
    }
    
    .search-box input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .search-box .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
    }
    
    /* Stats Cards */
    .stats-row {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .stat-card {
        flex: 1;
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    
    .stat-icon-total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
    }
    
    .stat-icon-active {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    
    .stat-icon-inactive {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    
    .stat-info h3 {
        font-size: 24px;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }
    
    .stat-info p {
        font-size: 13px;
        color: #718096;
        margin: 0;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f8f9fc;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .empty-state-icon i {
        font-size: 36px;
        color: #a0aec0;
    }
    
    .empty-state h5 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: #718096;
        margin-bottom: 20px;
    }
    
    /* Modal Improvements */
    .modal-content {
        border: none;
        border-radius: 15px;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px 15px 0 0;
        padding: 20px 25px;
    }
    
    .modal-header .modal-title {
        color: #fff;
        font-weight: 600;
    }
    
    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }
    
    #productImagesContainer img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #eaecf4;
        transition: all 0.3s;
    }
    
    #productImagesContainer img:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
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
            <a href="{{ route('admin.product-create.index') }}" class="btn btn-primary d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px 24px; border-radius: 10px;">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    @php
        $totalCount = is_countable($products) ? count($products) : 0;
        $activeCount = 0;
        $inactiveCount = 0;
        if ($products) {
            foreach ($products as $prod) {
                if (isset($prod->status) && $prod->status === 'active') {
                    $activeCount++;
                } else {
                    $inactiveCount++;
                }
            }
        }
    @endphp
    <div class="col-12">
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon stat-icon-total">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalCount }}</h3>
                    <p>Total Products</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-active">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $activeCount }}</h3>
                    <p>Active Products</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-inactive">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $inactiveCount }}</h3>
                    <p>Inactive Products</p>
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
                                    <span class="badge bg-light text-dark fw-bold">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="product-info">
                                        @php
                                            $coverImg = null;
                                            if (isset($p->id)) {
                                                $coverImg = \DB::table('product_images')
                                                    ->where('product_id', $p->id)
                                                    ->where('is_cover', true)
                                                    ->first();
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
                                        <span class="badge-brand">{{ $p->brand_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->category_name)
                                        <span class="badge-category">{{ $p->category_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="status-toggle-wrapper">
                                        <label class="product-toggle-switch">
                                            <input type="checkbox" class="product-status-toggle"
                                                data-product-id="{{ $p->id }}"
                                                {{ $p->status === 'active' ? 'checked' : '' }}>
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
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.product-create.index', ['edit' => $p->id]) }}" class="action-btn action-btn-view" title="View Product">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.product-create.index', ['edit' => $p->id]) }}" class="action-btn action-btn-edit" title="Edit Product">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.product.destroy', $p->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="action-btn action-btn-delete btn-delete" title="Delete Product">
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
                                        <a href="{{ route('admin.product-create.index') }}" class="btn btn-primary">
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
            const form = this.closest(".delete-form");

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
                if (result.isConfirmed) form.submit();
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
});
</script>
@endpush

@extends('layouts.master')
@section('title', 'All Products')

@section('content')
    <div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h4 class="qb-card-title-sm mb-1">All Products</h4>
            <p class="fs-12 fw-300 lh-1 qb-text-light mb-0">
                Create, view, and manage all products in the system.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.product-create.index') }}" class="btn btn-info d-flex align-items-center">
                <i class="bx bx-plus bx-tada me-1"></i> Create New Product
            </a>
        </div>
    </div>
</div>


    <div class="col-md-3 mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-search"></i></span>
            <input type="text" class="form-control" placeholder="Search by product title..." id="productTitleSearch">
        </div>
    </div>

    <div class="table">
        <table class="display table table-hover" id="productsTable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>Brand Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Images</th>
                    <th>Variants</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->title }}</td>
                        <td>{{ $p->brand_name ?? 'N/A' }}</td>
                        <td>{{ $p->category_name ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold">Active</span>
                                <label class="product-toggle-switch">
                                    <input type="checkbox" class="product-status-toggle"
                                        data-product-id="{{ $p->id }}"
                                        {{ $p->status === 'active' ? 'checked' : '' }}>
                                    <span class="product-slider"></span>
                                </label>
                            </div>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-primary btn-view-images"
                                data-product-id="{{ $p->id }}">
                                {{ $p->images_count ?? 0 }} Images
                            </button>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-secondary btn-view-variants"
                                data-product-id="{{ $p->id }}">
                                {{ $p->variants_count ?? 0 }} Variants
                            </button>
                        </td>

                        <td class="text-end">
                            <form action="{{ route('admin.product.destroy', $p->id) }}" method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- ===== Modal for Viewing Images ===== -->
    <div class="modal fade" id="productImagesModal" tabindex="-1" aria-labelledby="productImagesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="productImagesModalLabel">Product Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="productImagesContainer" class="d-flex flex-wrap justify-content-center gap-3">
                        <!-- Images will load dynamically here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Modal for Viewing Variants ===== -->
    <div class="modal fade" id="productVariantsModal" tabindex="-1" aria-labelledby="productVariantsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="productVariantsModalLabel">Product Variants</h5>
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



    {{-- Toggle Switch & SweetAlert CSS --}}
    <style>
        .product-toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
            margin-left: 8px;
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
            background-color: #ccc;
            transition: .4s;
            border-radius: 25px;
        }

        .product-slider:before {
            position: absolute;
            content: "";
            height: 19px;
            width: 19px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        input:checked+.product-slider {
            background-color: #7841f8ff;
        }

        input:checked+.product-slider:before {
            transform: translateX(25px);
        }

        .swal2-confirm-btn,
        .swal2-cancel-btn {
            min-width: 120px !important;
        }

        #productTitleSearch {
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
        }

        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
        }

        #productImagesContainer img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ===== DataTable Initialization =====
            var table = $('#productsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "",
                    searchPlaceholder: "Search products..."
                },
                dom: 'lrtip'
            });

            // ===== Custom search =====
            $('#productTitleSearch').on('keyup', function() {
                table.column(2).search(this.value).draw();
            });

            // ===== Toggle Status =====
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
                            body: JSON.stringify({
                                status
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            // ✅ Success হলে success toast দেখাবে
                            if (data.ok) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                // ❌ Error হলে শুধু toggle টা inactive হবে, কোনো popup না
                                this.checked = false;
                            }
                        })
                        .catch(() => {
                            // ❌ Error হলেও popup না, শুধু toggle টা inactive করো
                            this.checked = false;
                        });
                });
            });


            // ===== Delete Button =====
            document.querySelectorAll(".btn-delete").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const form = this.closest(".delete-form");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this action!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            confirmButton: 'swal2-confirm-btn',
                            cancelButton: 'swal2-cancel-btn'
                        }
                    }).then(result => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // ===== View Images (Modal) =====
            $(document).on('click', '.btn-view-images', function() {
                const productId = $(this).data('product-id');
                const modal = new bootstrap.Modal(document.getElementById('productImagesModal'));
                const container = $('#productImagesContainer');
                container.html(
                    '<div class="text-center w-100 py-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading...</p></div>'
                );

                fetch(`/admin/product/${productId}/images`)
                    .then(res => res.json())
                    .then(data => {
                        container.empty();
                        if (data.images && data.images.length > 0) {
                            data.images.forEach(img => {
                                container.append(`<img src="${img.url}" alt="Product Image">`);
                            });
                        } else {
                            container.html(
                                '<p class="text-muted">No images available for this product.</p>');
                        }
                    })
                    .catch(() => {
                        container.html('<p class="text-danger">Failed to load images.</p>');
                    });

                modal.show();
            });
        });

        // ===== View Variants (Modal) =====
        $(document).on('click', '.btn-view-variants', function() {
            const productId = $(this).data('product-id');
            const modal = new bootstrap.Modal(document.getElementById('productVariantsModal'));
            const container = $('#productVariantsContainer');
            container.html(
                '<div class="text-center w-100 py-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading...</p></div>'
            );

            fetch(`/admin/product/${productId}/variants`)
                .then(res => res.json())
                .then(data => {
                    container.empty();
                    if (data.variants && data.variants.length > 0) {
                        let html = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Variant Name</th>
                                <th>SKU</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            ${data.variants.map(v => `
                                        <tr>
                                            <td>${v.name}</td>
                                            <td>${v.sku ?? '-'}</td>
                                            
                                        </tr>
                                    `).join('')}
                        </tbody>
                    </table>
                `;
                        container.html(html);
                    } else {
                        container.html('<p class="text-muted">No variants available for this product.</p>');
                    }
                })
                .catch(() => {
                    container.html('<p class="text-danger">Failed to load variants.</p>');
                });

            modal.show();
        });
    </script>
@endsection

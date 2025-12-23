@extends('layouts.master')
@section('title', 'Barcode Generator')

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
</style>
@endpush

@section('content')
<div class="row">
    <!-- Page Header -->
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">Barcode Generator</h3>
                <p class="text-muted mb-0">Select a product to generate and print barcodes</p>
            </div>
            
            <div class="d-flex gap-2 align-items-center">
                <!-- Print All Form -->
                <form action="{{ route('admin.product.barcode.print_all') }}" method="POST" target="_blank" class="d-flex align-items-center gap-2 bg-white p-2 rounded shadow-sm border">
                    @csrf
                    <div class="d-flex align-items-center">
                        <span class="small fw-bold me-2 text-nowrap">Qty per Product:</span>
                        <input type="number" name="quantity" class="form-control form-control-sm" style="width: 70px;" value="1" min="1" max="100">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm text-nowrap">
                        <i class="fas fa-print me-1"></i> Print All Active
                    </button>
                </form>

                <a href="{{ route('admin.product.all') }}" class="btn btn-light d-flex align-items-center gap-2" style="height: fit-content;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="col-12">
        <div class="card products-card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h4><i class="fas fa-barcode me-2"></i>Product List</h4>
                    <p class="mb-0">Search for a product to generate barcode</p>
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
                                <th scope="col">ID</th>
                                <th scope="col">Product</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables will populate this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded!');
        alert('Critical Error: jQuery is missing.');
        return;
    }

    // Check if DataTables is loaded
    if (!$.fn.DataTable) {
        console.error('DataTables is not loaded!');
        alert('Critical Error: DataTables library is missing.');
        return;
    }
    
    // Global error handler for DataTables to prevent alerts
    $.fn.dataTable.ext.errMode = 'none';
    
    const ajaxUrl = "{{ route('admin.product.all.data') }}";

    var table = $('#productsTable')
        .DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: ajaxUrl,
                type: 'GET',
                data: function(d) {
                    d.barcode_mode = true; // Request barcode mode buttons
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables Ajax Error:', error);
                    toastr.error('Server error loading products: ' + (xhr.statusText || error));
                }
            },
            responsive: true,
            width: "100%",
            language: {
                search: "",
                searchPlaceholder: "Search products...",
                emptyTable: "No products found",
                zeroRecords: "No matching products found",
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'product_info', name: 'title' },
                { data: 'brand_name', name: 'brand.name', orderable: false },
                { data: 'category_name', name: 'category_name', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            dom: '<"top"l>rt<"bottom d-flex justify-content-between align-items-center"ip><"clear">',
            order: [[1, 'asc']]
        });

    // Custom search
    $('#productTitleSearch').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>
@endpush
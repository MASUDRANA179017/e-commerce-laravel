@extends('layouts.master')

@section('title', 'Stock Management')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Stock Management</h3>
            <div class="d-flex gap-2">
                <button class="create-btn-white" id="btnExportStock">
                    <span class="material-symbols-outlined fs-14">download</span> Export
                </button>
                <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#adjustStockModal">
                    <span class="material-symbols-outlined fs-14">tune</span> Adjust Stock
                </button>
            </div>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="in_stock">In Stock</option>
                            <option value="low_stock">Low Stock</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" placeholder="Search products..." style="width: 200px;">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>SKU</th>
                                <th>Current Stock</th>
                                <th>Reserved</th>
                                <th>Available</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                            <tr data-product-id="{{ $product->id }}" class="product-row" style="cursor: pointer;">
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="expand-variants" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;" data-product-id="{{ $product->id }}" title="View variants">
                                            <i class="bx bx-chevron-right" style="font-size: 20px; transition: transform 0.2s;"></i>
                                        </div>
                                        <div class="wh-40 rounded bg-light overflow-hidden">
                                            @if($product->coverImage)
                                                <img src="{{ asset('storage/' . $product->coverImage->path) }}" class="w-100 h-100 object-fit-cover">
                                            @endif
                                        </div>
                                        <span class="fw-medium">{{ Str::limit($product->title, 30) }}</span>
                                    </div>
                                </td>
                                <td><code>{{ $product->sku ?? '-' }}</code></td>
                                <td class="cell-stock">{{ $product->stock_quantity ?? 0 }}</td>
                                <td>0</td>
                                <td class="cell-available">{{ $product->stock_quantity ?? 0 }}</td>
                                <td>
                                    @if(($product->stock_quantity ?? 0) > 10)
                                        <span class="qbit-badge-success"><i class="bx bx-check-circle"></i> In Stock</span>
                                    @elseif(($product->stock_quantity ?? 0) > 0)
                                        <span class="qbit-badge-warning"><i class="bx bx-error"></i> Low Stock</span>
                                    @else
                                        <span class="qbit-badge-danger"><i class="bx bx-x-circle"></i> Out of Stock</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-info" data-adjust data-product-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#adjustStockModal" onclick="event.stopPropagation();">Adjust</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No products found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(isset($products) && $products->hasPages())
            <div class="card-footer bg-white">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Adjust Stock Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Adjust Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select class="form-select" id="adjustProductSelect" name="product_id" required>
                            <option value="">Select Product</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Adjustment Type</label>
                            <select class="form-select" id="adjustTypeSelect" name="type" required>
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                                <option value="set">Set to</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="adjustQtyInput" name="quantity" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" rows="2" placeholder="Optional note..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="create-btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="create-btn-base" id="adjustStockSubmit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Adjust Variant Stock Modal -->
<div class="modal fade" id="adjustVariantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Adjust Variant Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <input type="hidden" id="adjustVariantId">
                    <div class="mb-3">
                        <label class="form-label">Variant</label>
                        <input type="text" class="form-control" id="adjustVariantLabel" readonly>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Adjustment Type</label>
                            <select class="form-select" id="adjustVariantType" required>
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                                <option value="set">Set to</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="adjustVariantQty" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="create-btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="create-btn-base" id="adjustVariantSubmit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var exportBtn = document.getElementById('btnExportStock');
    if (exportBtn) {
        exportBtn.addEventListener('click', function () {
            window.location.href = '/admin/reports/export/inventory';
        });
    }
    var productSelect = document.getElementById('adjustProductSelect');
    var qtyInput = document.getElementById('adjustQtyInput');
    var typeSelect = document.getElementById('adjustTypeSelect');
    var csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

    fetch('/admin/inventory/stock/data')
        .then(function (res) { return res.json(); })
        .then(function (json) {
            var data = (json && json.data) ? json.data : [];
            productSelect.innerHTML = '<option value="">Select Product</option>';
            data.forEach(function (p) {
                var opt = document.createElement('option');
                opt.value = p.id;
                var sku = p.sku ? (' [' + p.sku + ']') : '';
                opt.textContent = p.title + sku + ' — Stock: ' + (p.stock_quantity || 0);
                productSelect.appendChild(opt);
            });
        })
        .catch(function () {});

    document.querySelectorAll('[data-adjust]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var pid = btn.getAttribute('data-product-id');
            if (pid) productSelect.value = pid;
            qtyInput.value = '';
            typeSelect.value = 'add';
        });
    });

    document.getElementById('adjustStockSubmit').addEventListener('click', function (e) {
        e.preventDefault();
        var pid = productSelect.value;
        var qty = parseInt(qtyInput.value || '0', 10);
        var typ = typeSelect.value;
        if (!pid || !typ || isNaN(qty)) return;
        fetch('/admin/inventory/stock/adjust', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ product_id: pid, quantity: qty, type: typ })
        })
        .then(function (res) { return res.json(); })
        .then(function (json) {
            if (json && json.success) {
                var tr = document.querySelector('tr[data-product-id="' + pid + '"]');
                if (tr) {
                    var s = tr.querySelector('.cell-stock');
                    var a = tr.querySelector('.cell-available');
                    if (s) s.textContent = json.new_stock;
                    if (a) a.textContent = json.new_stock;
                }
                var modalEl = document.getElementById('adjustStockModal');
                if (modalEl) {
                    var mdl = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    mdl.hide();
                }
                productSelect.value = '';
                qtyInput.value = '';
                typeSelect.value = 'add';
                var reason = document.querySelector('#adjustStockModal textarea');
                if (reason) reason.value = '';
            }
        })
        .catch(function () {});
    });
});
</script>
 
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
    
    // Step 1: Create variant rows FIRST
    document.querySelectorAll('tr[data-product-id]').forEach(function (row) {
        var pid = row.getAttribute('data-product-id');
        var variants = @json($products->mapWithKeys(function($p) { return [$p->id => $p->variants]; }));
        var list = variants[pid] || [];
        if (list && list.length) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-variants-container', pid);
            tr.style.display = 'none'; // Initially hidden
            var td = document.createElement('td');
            td.colSpan = 7;
            var inner = document.createElement('div');
            inner.className = 'p-3 bg-light';
            var heading = document.createElement('h6');
            heading.className = 'mb-3 fw-600';
            heading.textContent = 'Available Variants';
            inner.appendChild(heading);
            var tbl = document.createElement('table');
            tbl.className = 'table table-sm mb-0 bg-white';
            var thead = document.createElement('thead');
            thead.className = 'bg-light';
            thead.innerHTML = '<tr><th style="width: 120px;">Variant SKU</th><th>Attributes</th><th style="width: 100px;">Stock</th><th style="width: 100px;">Status</th><th style="width: 100px;" class="text-end pe-3">Actions</th></tr>';
            var tbody = document.createElement('tbody');
            list.forEach(function(v){
                var attrs = (v.options || []).map(function(o){ return (o.term && o.term.name) ? o.term.name : ''; }).filter(Boolean).join(', ');
                var stock = v.stock_quantity || 0;
                var status = stock > 10 ? '<span class="qbit-badge-success"><i class="bx bx-check-circle"></i> In Stock</span>' : 
                             stock > 0 ? '<span class="qbit-badge-warning"><i class="bx bx-error"></i> Low Stock</span>' : 
                             '<span class="qbit-badge-danger"><i class="bx bx-x-circle"></i> Out</span>';
                var trv = document.createElement('tr');
                trv.setAttribute('data-variant-id', v.id);
                trv.innerHTML = '<td><code>' + (v.sku || '-') + '</code></td>' +
                                '<td>' + attrs + '</td>' +
                                '<td class="cell-variant-stock"><strong>' + stock + '</strong></td>' +
                                '<td>' + status + '</td>' +
                                '<td class="text-end pe-3"><button class="action-btn-info btn-sm" data-adjust-variant data-variant-id="'+v.id+'" data-variant-label="'+((v.sku||'-') + (attrs?(' — '+attrs):''))+'" data-product-id="'+pid+'" data-bs-toggle="modal" data-bs-target="#adjustVariantModal">Adjust</button></td>';
                tbody.appendChild(trv);
            });
            tbl.appendChild(thead);
            tbl.appendChild(tbody);
            inner.appendChild(tbl);
            td.appendChild(inner);
            tr.appendChild(td);
            row.parentNode.insertBefore(tr, row.nextSibling);
        }
    });

    document.querySelectorAll('[data-adjust-variant]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var vid = btn.getAttribute('data-variant-id');
            var lbl = btn.getAttribute('data-variant-label');
            document.getElementById('adjustVariantId').value = vid;
            document.getElementById('adjustVariantLabel').value = lbl;
            document.getElementById('adjustVariantQty').value = '';
            document.getElementById('adjustVariantType').value = 'add';
        });
    });

    document.getElementById('adjustVariantSubmit').addEventListener('click', function (e) {
        e.preventDefault();
        var vid = document.getElementById('adjustVariantId').value;
        var qty = parseInt(document.getElementById('adjustVariantQty').value || '0', 10);
        var typ = document.getElementById('adjustVariantType').value;
        if (!vid || !typ || isNaN(qty)) return;
        fetch('/admin/inventory/stock/adjust-variant', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ variant_id: vid, quantity: qty, type: typ })
        })
        .then(function (res) { return res.json(); })
        .then(function (json) {
            if (json && json.success) {
                var trv = document.querySelector('tr[data-variant-id="' + vid + '"]');
                if (trv) {
                    var s = trv.querySelector('.cell-variant-stock');
                    if (s) s.innerHTML = '<strong>' + json.new_variant_stock + '</strong>';
                }
                var modalEl = document.getElementById('adjustVariantModal');
                if (modalEl) {
                    var mdl = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    mdl.hide();
                }
            }
        })
        .catch(function () {});
    });

    // Step 2: Add click handlers AFTER variant rows are created
    document.querySelectorAll('.product-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            // Don't toggle if clicking on action buttons
            if (e.target.closest('button') || e.target.closest('.action-btn-info')) {
                return;
            }
            
            var pid = row.getAttribute('data-product-id');
            var variantRow = document.querySelector('tr[data-variants-container="' + pid + '"]');
            var chevron = row.querySelector('.expand-variants i');
            
            if (variantRow) {
                // Check if currently visible
                var isVisible = variantRow.style.display !== 'none';
                
                if (isVisible) {
                    // Close it
                    variantRow.style.display = 'none';
                    if (chevron) {
                        chevron.style.transform = 'rotate(0deg)';
                    }
                    row.style.backgroundColor = '';
                } else {
                    // Open it
                    variantRow.style.display = '';
                    if (chevron) {
                        chevron.style.transform = 'rotate(90deg)';
                    }
                    row.style.backgroundColor = '#f8f9fa';
                }
            }
        });
        
        // Add hover effect
        row.addEventListener('mouseenter', function() {
            if (!this.querySelector('tr[data-variants-container]') || 
                document.querySelector('tr[data-variants-container="' + this.getAttribute('data-product-id') + '"]').style.display === 'none') {
                this.style.backgroundColor = '#f8f9fa';
            }
        });
        
        row.addEventListener('mouseleave', function() {
            var pid = this.getAttribute('data-product-id');
            var variantRow = document.querySelector('tr[data-variants-container="' + pid + '"]');
            if (!variantRow || variantRow.style.display === 'none') {
                this.style.backgroundColor = '';
            }
        });
    });
});
</script>
@endpush
@endsection


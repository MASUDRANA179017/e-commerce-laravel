@extends('layouts.master')

@section('title', 'Create Purchase Order')

@section('content')
<form action="{{ route('admin.inventory.purchases.store') }}" method="POST" id="purchaseForm">
    @csrf
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h3 class="fw-bold mb-0">Create Purchase Order</h3>
                <a href="{{ route('admin.inventory.purchases') }}" class="select-btn-white">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Vendor Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Vendor <span class="text-danger">*</span></label>
                            <select name="vendor_id" class="form-select" required>
                                <option value="">Select a vendor</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expected Delivery Date</label>
                            <input type="date" name="expected_delivery_date" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Notes</label>
                            <input type="text" name="notes" class="form-control" placeholder="Optional notes">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Order Items</h5>
                    <button type="button" class="create-btn-base" id="addItemBtn">
                        <i class="fas fa-plus me-1"></i>Add Item
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="itemsTable">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 30%">Product</th>
                                    <th style="width: 25%">Variant</th>
                                    <th style="width: 15%">Quantity</th>
                                    <th style="width: 15%">Unit Cost</th>
                                    <th style="width: 15%">Sell Price</th>
                                    <th style="width: 10%">Total</th>
                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Items:</span>
                        <span id="totalItems">0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Amount:</span>
                        <span id="grandTotal">৳0.00</span>
                    </div>
                    <button type="submit" class="create-btn-base w-100 mt-3">
                        <i class="fas fa-save me-2"></i>Create Purchase Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const products = @json($products);
    const tbody = document.querySelector('#itemsTable tbody');
    let itemIndex = 0;

    function addItem() {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="items[${itemIndex}][product_id]" class="form-select product-select" required>
                    <option value="">Select Product</option>
                    ${products.map(p => `<option value="${p.id}">${p.title} (${p.sku || '-'})</option>`).join('')}
                </select>
            </td>
            <td>
                <select name="items[${itemIndex}][variant_id]" class="form-select variant-select" disabled>
                    <option value="">Select Variant (optional)</option>
                </select>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity-input" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][unit_cost]" class="form-control cost-input" min="0" step="0.01" value="0" required>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][sell_price]" class="form-control sell-input" min="0" step="0.01" value="0" required>
            </td>
            <td>
                <span class="row-total">৳0.00</span>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-row">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        itemIndex++;
        updateTotals();
    }

    tbody.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
            updateTotals();
        }
    });

    tbody.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const row = e.target.closest('tr');
            const variantSelect = row.querySelector('.variant-select');
            const pid = parseInt(e.target.value || '0', 10);
            variantSelect.innerHTML = '<option value="">Select Variant (optional)</option>';
            variantSelect.disabled = true;
            const p = products.find(x => x.id === pid);
            if (p && Array.isArray(p.variants) && p.variants.length) {
                p.variants.forEach(v => {
                    const terms = Array.isArray(v.options) ? v.options.map(o => (o.term && o.term.name) ? o.term.name : '').filter(Boolean) : [];
                    const label = (v.sku || '-') + (terms.length ? (' — ' + terms.join(', ')) : '');
                    const opt = document.createElement('option');
                    opt.value = v.id;
                    opt.textContent = label;
                    variantSelect.appendChild(opt);
                });
                variantSelect.disabled = false;
            }
        }
    });

    tbody.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('cost-input') || e.target.classList.contains('sell-input')) {
            const row = e.target.closest('tr');
            const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
            const total = qty * cost;
            row.querySelector('.row-total').textContent = '৳' + total.toFixed(2);
            updateTotals();
        }
    });

    function updateTotals() {
        let totalQty = 0;
        let grandTotal = 0;
        
        document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
            totalQty += qty;
            grandTotal += qty * cost;
        });

        document.getElementById('totalItems').textContent = totalQty;
        document.getElementById('grandTotal').textContent = '৳' + grandTotal.toFixed(2);
    }

    document.getElementById('addItemBtn').addEventListener('click', addItem);
    
    // Add first item by default
    addItem();
});
</script>
@endpush
@endsection

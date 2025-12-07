@extends('layouts.master')

@section('title', 'Flash Sales')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Flash Sales</h3>
            <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addFlashSaleModal">
                <span class="material-symbols-outlined fs-14">add</span> Create Flash Sale
            </button>
        </div>
    </div>

    <!-- Active Flash Sale -->
    <div class="col-12 mb-4">
        <div class="card border-0 {{ isset($activeFlashSale) && $activeFlashSale ? 'bg-success' : 'bg-primary' }} bg-opacity-10">
            <div class="card-body">
                @if(isset($activeFlashSale) && $activeFlashSale)
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold text-success mb-1">
                            <span class="material-symbols-outlined align-middle me-1">flash_on</span>
                            {{ $activeFlashSale->title }}
                        </h5>
                        <p class="mb-2 text-muted">{{ $activeFlashSale->description ?? 'No description' }}</p>
                        <div class="d-flex gap-4 flex-wrap">
                            <small class="text-muted">
                                <i class="bx bx-package me-1"></i> {{ $activeFlashSale->products->count() }} Products
                            </small>
                            <small class="text-muted">
                                <i class="bx bx-time me-1"></i> Ends: {{ $activeFlashSale->end_time->format('M d, Y h:i A') }}
                            </small>
                            @if($activeFlashSale->discount_percent > 0)
                            <small class="text-danger fw-bold">
                                <i class="bx bx-purchase-tag me-1"></i> {{ $activeFlashSale->discount_percent }}% OFF
                            </small>
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="countdown-admin mb-2" id="activeCountdown" data-end="{{ $activeFlashSale->end_time->timestamp * 1000 }}">
                            <span class="badge bg-dark p-2 me-1"><span id="ad-days">00</span>d</span>
                            <span class="badge bg-dark p-2 me-1"><span id="ad-hours">00</span>h</span>
                            <span class="badge bg-dark p-2 me-1"><span id="ad-mins">00</span>m</span>
                            <span class="badge bg-dark p-2"><span id="ad-secs">00</span>s</span>
                        </div>
                        <button class="btn btn-sm btn-outline-danger" onclick="toggleStatus({{ $activeFlashSale->id }})">
                            <i class="bx bx-stop-circle me-1"></i> Stop Sale
                        </button>
                    </div>
                </div>
                @else
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold text-primary mb-1">No Active Flash Sale</h5>
                        <p class="mb-0 text-muted">Create a flash sale to boost your sales with limited-time offers</p>
                    </div>
                    <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addFlashSaleModal">
                        <span class="material-symbols-outlined fs-14">flash_on</span> Start Flash Sale
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Sales List -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">All Flash Sales</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Title</th>
                                <th>Products</th>
                                <th>Discount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($flashSales ?? [] as $sale)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        @if($sale->is_featured)
                                        <span class="badge bg-warning text-dark me-2">Featured</span>
                                        @endif
                                        <strong>{{ $sale->title }}</strong>
                                    </div>
                                </td>
                                <td>{{ $sale->products_count ?? 0 }} products</td>
                                <td>
                                    @if($sale->discount_percent > 0)
                                    <span class="text-danger fw-bold">{{ $sale->discount_percent }}%</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $sale->start_time->format('M d, Y H:i') }}</td>
                                <td>{{ $sale->end_time->format('M d, Y H:i') }}</td>
                                <td>
                                    @switch($sale->status)
                                        @case('active')
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @case('scheduled')
                                            <span class="badge bg-info">Scheduled</span>
                                            @break
                                        @case('ended')
                                            <span class="badge bg-secondary">Ended</span>
                                            @break
                                        @default
                                            <span class="badge bg-warning text-dark">Draft</span>
                                    @endswitch
                                </td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editFlashSale({{ $sale->id }})" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    @if($sale->status !== 'active')
                                    <button class="btn btn-sm btn-outline-success me-1" onclick="toggleStatus({{ $sale->id }})" title="Activate">
                                        <i class="bx bx-play"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-sm btn-outline-warning me-1" onclick="toggleStatus({{ $sale->id }})" title="Pause">
                                        <i class="bx bx-pause"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteFlashSale({{ $sale->id }})" title="Delete">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">flash_on</span>
                                        <p class="mb-0">No flash sales found</p>
                                        <small>Create your first flash sale to boost sales!</small>
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

<!-- Add/Edit Flash Sale Modal -->
<div class="modal fade" id="addFlashSaleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flashSaleModalTitle">Create Flash Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="flashSaleForm">
                <div class="modal-body">
                    <input type="hidden" id="flashSaleId" name="id">
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="flashSaleTitle" required placeholder="e.g., Weekend Super Sale">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <textarea class="form-control" name="description" id="flashSaleDescription" rows="2" placeholder="Describe your flash sale..."></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="start_time" id="flashSaleStart" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="end_time" id="flashSaleEnd" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Default Discount %</label>
                            <input type="number" class="form-control" name="discount_percent" id="flashSaleDiscount" min="0" max="100" step="0.01" placeholder="e.g., 20">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">&nbsp;</label>
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" name="is_featured" id="flashSaleFeatured" value="1">
                                <label class="form-check-label" for="flashSaleFeatured">
                                    <strong>Featured</strong> - Show on homepage
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Select Products</label>
                            <select class="form-select" name="products[]" id="flashSaleProducts" multiple style="height: 200px;">
                                @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->title }} - ৳{{ number_format($product->sale_price ?? $product->price, 0) }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="flashSaleSubmitBtn">
                        <i class="bx bx-save me-1"></i> Save Flash Sale
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Active countdown timer
@if(isset($activeFlashSale) && $activeFlashSale)
(function() {
    const endTime = {{ $activeFlashSale->end_time->timestamp * 1000 }};
    
    function updateAdminCountdown() {
        const now = Date.now();
        const distance = endTime - now;
        
        if (distance <= 0) {
            document.getElementById('ad-days').textContent = '00';
            document.getElementById('ad-hours').textContent = '00';
            document.getElementById('ad-mins').textContent = '00';
            document.getElementById('ad-secs').textContent = '00';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const secs = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('ad-days').textContent = String(days).padStart(2, '0');
        document.getElementById('ad-hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('ad-mins').textContent = String(mins).padStart(2, '0');
        document.getElementById('ad-secs').textContent = String(secs).padStart(2, '0');
    }
    
    setInterval(updateAdminCountdown, 1000);
    updateAdminCountdown();
})();
@endif

// Form submission
document.getElementById('flashSaleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('flashSaleId').value;
    const url = id ? `/admin/marketing/flash-sales/${id}` : '/admin/marketing/flash-sales';
    const method = id ? 'PUT' : 'POST';
    
    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
        if (key === 'products[]') {
            if (!data.products) data.products = [];
            data.products.push(value);
        } else if (key === 'is_featured') {
            data[key] = true;
        } else {
            data[key] = value;
        }
    });
    
    // Get selected products
    const productsSelect = document.getElementById('flashSaleProducts');
    data.products = Array.from(productsSelect.selectedOptions).map(opt => opt.value);
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert(result.message || 'Error saving flash sale');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error saving flash sale');
    });
});

// Edit flash sale
function editFlashSale(id) {
    fetch(`/admin/marketing/flash-sales/${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.flash_sale) {
                const sale = data.flash_sale;
                document.getElementById('flashSaleId').value = sale.id;
                document.getElementById('flashSaleTitle').value = sale.title;
                document.getElementById('flashSaleDescription').value = sale.description || '';
                document.getElementById('flashSaleStart').value = sale.start_time.slice(0, 16);
                document.getElementById('flashSaleEnd').value = sale.end_time.slice(0, 16);
                document.getElementById('flashSaleDiscount').value = sale.discount_percent;
                document.getElementById('flashSaleFeatured').checked = sale.is_featured;
                
                // Select products
                const productsSelect = document.getElementById('flashSaleProducts');
                Array.from(productsSelect.options).forEach(opt => {
                    opt.selected = sale.products.some(p => p.id == opt.value);
                });
                
                document.getElementById('flashSaleModalTitle').textContent = 'Edit Flash Sale';
                new bootstrap.Modal(document.getElementById('addFlashSaleModal')).show();
            }
        });
}

// Toggle status
function toggleStatus(id) {
    if (!confirm('Are you sure you want to change the status?')) return;
    
    fetch(`/admin/marketing/flash-sales/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            location.reload();
        } else {
            alert(result.message || 'Error updating status');
        }
    });
}

// Delete flash sale
function deleteFlashSale(id) {
    if (!confirm('Are you sure you want to delete this flash sale?')) return;
    
    fetch(`/admin/marketing/flash-sales/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            location.reload();
        } else {
            alert(result.message || 'Error deleting flash sale');
        }
    });
}

// Reset form when modal opens for new sale
document.getElementById('addFlashSaleModal').addEventListener('show.bs.modal', function(e) {
    if (!document.getElementById('flashSaleId').value) {
        document.getElementById('flashSaleForm').reset();
        document.getElementById('flashSaleModalTitle').textContent = 'Create Flash Sale';
        
        // Set default start time to now
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('flashSaleStart').value = now.toISOString().slice(0, 16);
        
        // Set default end time to 3 days from now
        const end = new Date(now.getTime() + 3 * 24 * 60 * 60 * 1000);
        document.getElementById('flashSaleEnd').value = end.toISOString().slice(0, 16);
    }
});

document.getElementById('addFlashSaleModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('flashSaleId').value = '';
    document.getElementById('flashSaleForm').reset();
});
</script>
@endpush

@extends('layouts.master')

@section('title', 'All Orders')

@push('styles')
<style>
    .orders-table thead th {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #5a5c69;
        white-space: nowrap;
    }
    .orders-table tbody td {
        vertical-align: middle;
    }
    .order-id {
        font-weight: 600;
        color: var(--qbit-purple);
    }
    .customer-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--qbit-primary) 0%, var(--qbit-purple) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
    }
    .product-count {
        font-size: 12px;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">All Orders</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Order Stats -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-1">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(251, 110, 82, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-time-five fs-20" style="color: #FB6E52;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['pending'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Pending Orders</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-2">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(27, 132, 255, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-package fs-20" style="color: #1B84FF;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['processing'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Processing</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-3">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(140, 192, 82, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-check-circle fs-20" style="color: #8CC052;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['completed'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Completed</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%); border: 1px solid rgba(235, 84, 99, 0.2);">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(235, 84, 99, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon" style="background: rgba(235, 84, 99, 0.15);">
                    <i class="bx bx-x-circle fs-20" style="color: #EB5463;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['cancelled'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Cancelled</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">Order List</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <select class="form-select form-select-sm" style="width: auto;" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <input type="text" class="form-control form-control-sm" placeholder="Search orders..." style="width: 200px;" id="searchOrder">
                    <button class="create-btn-white" id="exportBtn">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 orders-table" id="ordersTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3" style="width: 40px;">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Products</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="ps-3">
                                    <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="order-id">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="customer-avatar">
                                            {{ strtoupper(substr($order->first_name ?? 'C', 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-medium d-block">{{ $order->full_name }}</span>
                                            <small class="text-muted">{{ $order->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="qbit-badge-info"><i class="bx bx-package"></i> {{ $order->items->count() }} items</span>
                                </td>
                                <td>
                                    <span class="fw-bold">৳{{ number_format($order->total, 2) }}</span>
                                </td>
                                <td>
                                    @if($order->payment_status == 'paid')
                                        <span class="qbit-badge-success"><i class="bx bx-check"></i> Paid</span>
                                    @elseif($order->payment_status == 'failed')
                                        <span class="qbit-badge-danger"><i class="bx bx-x"></i> Failed</span>
                                    @else
                                        <span class="qbit-badge-warning"><i class="bx bx-time"></i> Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger',
                                            'returned' => 'gray',
                                            default => 'gray'
                                        };
                                        $statusIcon = match($order->status) {
                                            'pending' => 'bx-time-five',
                                            'processing' => 'bx-loader-circle',
                                            'shipped' => 'bx-car',
                                            'delivered' => 'bx-check-circle',
                                            'cancelled' => 'bx-x-circle',
                                            'returned' => 'bx-undo',
                                            default => 'bx-help-circle'
                                        };
                                    @endphp
                                    <span class="qbit-badge-{{ $statusClass }}">
                                        <i class="bx {{ $statusIcon }}"></i> {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $order->created_at->format('M d, Y') }}</span>
                                    <br><small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn-info" title="View">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="action-btn-success" title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="action-btn-purple" title="Invoice">
                                            <i class="bx bx-receipt"></i>
                                        </a>
                                        <button type="button" class="action-btn-danger btn-delete" data-id="{{ $order->id }}" title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-cart bx-lg d-block mb-2"></i>
                                        <p class="mb-0 fw-medium">No orders found</p>
                                        <small>Orders will appear here when customers make purchases</small>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($orders->hasPages())
            <div class="card-footer bg-white d-flex align-items-center justify-content-between">
                <div class="text-muted fs-13">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                </div>
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm">
                <div class="modal-body">
                    <input type="hidden" id="statusOrderId">
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select class="form-select" id="newStatus">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="returned">Returned</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" rows="3" id="statusNotes" placeholder="Add any notes about this status change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="create-btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="create-btn-base">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.order-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }
    
    // Delete order
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.dataset.id;
            
            Swal.fire({
                title: 'Delete Order?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EB5463',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="bx bx-trash me-1"></i> Yes, delete it!',
                cancelButtonText: '<i class="bx bx-x me-1"></i> Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/orders/${orderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Order has been deleted.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    });
    
    // Filter by status
    document.getElementById('filterStatus')?.addEventListener('change', function() {
        const status = this.value;
        const url = new URL(window.location);
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        window.location = url;
    });
    
    // Search orders
    let searchTimeout;
    document.getElementById('searchOrder')?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const search = this.value;
        searchTimeout = setTimeout(() => {
            const url = new URL(window.location);
            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            window.location = url;
        }, 500);
    });
});
</script>
@endpush

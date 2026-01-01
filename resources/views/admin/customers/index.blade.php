@extends('layouts.master')

@section('title', 'All Customers')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">All Customers</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-primary">group</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $customers->total() ?? 0 }}</h4>
                        <span class="text-muted">Total Customers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-success">person_add</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">New This Month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-info">shopping_cart</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">With Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5 class="mb-0 fw-bold">Customer List</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search customers..." style="width: 200px;">
                    <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <span class="material-symbols-outlined fs-14">add</span> Add Customer
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers ?? [] as $customer)
                            <tr>
                                <td class="ps-3">
                                    <input type="checkbox" class="form-check-input">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="wh-40 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                            <span class="text-primary fw-bold">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                        </div>
                                        <span class="fw-medium">{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td>0</td>
                                <td>৳0.00</td>
                                <td>
                                    <span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Active</span>
                                </td>
                                <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="action-btn-info" title="View Details"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="action-btn-success btn-edit" data-id="{{ $customer->id }}" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="delete-customer-form" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn-danger btn-delete btn btn-link p-0" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">group</span>
                                        <p class="mb-0">No customers found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(isset($customers) && $customers->hasPages())
            <div class="card-footer bg-white">
                {{ $customers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Customer Modal (loads create page in iframe) -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf
                    <div class="p-3">
                        @include('admin.customers._form_fields')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal (reuse form partial) -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-3">
                        @include('admin.customers._form_fields')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    var baseUrl = "{{ url('admin/customers') }}";

    // Edit button opens modal and populates fields
    document.querySelectorAll('.btn-edit').forEach(function(btn){
        btn.addEventListener('click', function(e){
            e.preventDefault();
            var id = this.getAttribute('data-id');
            if(!id) return;
            fetch(baseUrl + '/' + id, { headers: { 'Accept': 'application/json' } })
                .then(function(resp){ return resp.json(); })
                .then(function(json){
                    var c = json.customer;
                    var form = document.getElementById('editCustomerForm');
                    form.action = baseUrl + '/' + id;
                    ['name','email','phone','address','zipcode','note','total_spent'].forEach(function(f){
                        var el = form.querySelector('[name="'+f+'"]'); if(el) el.value = c[f] ?? '';
                    });
                    var pw = form.querySelector('[name="password"]'); if(pw) pw.value = '';
                    var isActive = form.querySelector('[name="is_active"]'); if(isActive) isActive.checked = !!c.is_active;
                    var modal = new bootstrap.Modal(document.getElementById('editCustomerModal'));
                    modal.show();
                }).catch(function(){ alert('Could not load customer data.'); });
        });
    });

    // Delete using SweetAlert2
    document.querySelectorAll('.delete-customer-form').forEach(function(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();
            var frm = this;
            if (typeof Swal === 'undefined') {
                if (confirm('Are you sure you want to delete this customer?')) frm.submit();
                return;
            }
            Swal.fire({
                title: 'Are you sure?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it'
            }).then(function(result){ if(result.isConfirmed) frm.submit(); });
        });
    });
});
</script>
@endpush


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
                        <h4 class="mb-0 fw-bold">{{ $newThisMonth ?? 0 }}</h4>
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
                        <h4 class="mb-0 fw-bold">{{ $withOrders ?? 0 }}</h4>
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
                    <form action="{{ route('admin.customers.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search customers..." style="width: 200px;">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <span class="material-symbols-outlined fs-14">add</span> Add Customer
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="customers-table" class="table table-hover mb-0" style="width:100%">
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
                        <tbody></tbody>
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

<script>
    (function(){
        var csrf = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            : '';

        function clearErrors(form){
            form.querySelectorAll('.ajax-error').forEach(function(el){ el.remove(); });
            form.querySelectorAll('.is-invalid').forEach(function(el){ el.classList.remove('is-invalid'); });
        }

        function showFieldErrors(form, errors){
            Object.keys(errors).forEach(function(field){
                var input = form.querySelector('[name="'+field+'"]') || form.querySelector('[name="'+field+'[]"]');
                if (!input) return;
                input.classList.add('is-invalid');
                var err = document.createElement('div');
                err.className = 'invalid-feedback ajax-error';
                err.innerText = errors[field][0];
                if (input.parentNode) input.parentNode.appendChild(err);
            });
        }

        async function ajaxSubmit(form){
            clearErrors(form);
            var btn = form.querySelector('button[type=submit]');
            if (btn) btn.disabled = true;
            var formData = new FormData(form);
            var method = (form.getAttribute('method') || 'POST').toUpperCase();
            var action = form.getAttribute('action');

            var opts = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf
                },
                body: formData
            };

            try {
                var res = await fetch(action, opts);
                if (res.status === 422) {
                    var json = await res.json();
                    if (json.errors) showFieldErrors(form, json.errors);
                } else if (res.ok) {
                    // success
                    var modalEl = form.closest('.modal');
                    if (modalEl) {
                        try { // Bootstrap 5
                            if (typeof bootstrap !== 'undefined') {
                                var inst = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                inst.hide();
                            } else if (window.jQuery) {
                                $(modalEl).modal('hide');
                            }
                        } catch (e) { console.warn(e); }
                    }
                    form.reset();
                    try {
                        if (window.customersTable && typeof window.customersTable.ajax.reload === 'function') {
                            window.customersTable.ajax.reload(null, false);
                        } else if (window.$ && window.$.fn && window.$('#customers-table').DataTable) {
                            window.$('#customers-table').DataTable().ajax.reload(null, false);
                        }
                    } catch (e) { console.warn('Could not reload DataTable', e); }
                } else {
                    var txt = await res.text();
                    console.error('Unexpected response', res.status, txt);
                }
            } catch (err) {
                console.error('Request failed', err);
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        // Intercept submits inside customer modals (add/edit). Works for dynamically-loaded edit form too.
        document.addEventListener('submit', function(e){
            var form = e.target;
            if (!form) return;
            if (form.closest('#addCustomerModal') || form.closest('#editCustomerModal')) {
                e.preventDefault();
                ajaxSubmit(form);
            }
        });

        // optional: attach to add form directly if present on page
        var addForm = document.getElementById('addCustomerForm');
        if (addForm) addForm.setAttribute('data-ajax', '1');
    })();
</script>
<!-- Add Customer Modal (loads create page in iframe) -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form id="addCustomerForm" action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf
                    <div class="p-3">
                        @include('admin.customers._form_fields', ['isEdit' => false])
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
                        @include('admin.customers._form_fields', ['isEdit' => true])
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

    // Initialize DataTable (Yajra server-side)
    var customersTable = $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: baseUrl + '/data',
        columns: [
            { data: null, orderable: false, searchable: false, render: function(){ return '<input type="checkbox" class="form-check-input">'; } },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'orders', orderable: false, searchable: false },
            { data: 'total_spent', name: 'total_spent' },
            { data: 'is_active', name: 'is_active', render: function(data){ return data ? '<span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Active</span>' : '<span class="qbit-badge-danger">Inactive</span>'; } },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', orderable: false, searchable: false }
        ],
        order: [[7, 'desc']],
        drawCallback: function(){
            // reattach handlers for edit/delete after table draw
            attachRowHandlers();
        }
    });

    // attach handlers for edit/delete (will be called after draw)
    function attachRowHandlers(){
        document.querySelectorAll('.btn-edit').forEach(function(btn){
            btn.removeEventListener('click', editHandler);
            btn.addEventListener('click', editHandler);
        });

        document.querySelectorAll('.delete-customer-form').forEach(function(form){
            form.removeEventListener('submit', deleteHandler);
            form.addEventListener('submit', deleteHandler);
        });
    }

    function editHandler(e){
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
    }

    function deleteHandler(e){
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
    }

    // initial attach
    attachRowHandlers();
});
</script>
@endpush


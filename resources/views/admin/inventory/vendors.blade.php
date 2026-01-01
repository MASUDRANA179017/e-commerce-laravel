@extends('layouts.master')

@section('title', 'Vendors')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Vendors</h3>
            <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addVendorModal">
                <span class="material-symbols-outlined fs-14">add</span> Add Vendor
            </button>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Vendor Name</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $vendor)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $vendor->name }}</td>
                                <td>{{ $vendor->contact_person ?? 'N/A' }}</td>
                                <td>{{ $vendor->email ?? 'N/A' }}</td>
                                <td>{{ $vendor->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $vendor->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($vendor->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-light text-primary edit-vendor-btn" 
                                            data-id="{{ $vendor->id }}"
                                            data-name="{{ $vendor->name }}"
                                            data-contact="{{ $vendor->contact_person }}"
                                            data-email="{{ $vendor->email }}"
                                            data-phone="{{ $vendor->phone }}"
                                            data-address="{{ $vendor->address }}"
                                            data-status="{{ $vendor->status }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editVendorModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.inventory.vendors.destroy', $vendor->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">business</span>
                                        <p class="mb-0">No vendors found</p>
                                        <small>Add your first vendor to start managing suppliers</small>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-3 py-3">
                    {{ $vendors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Vendor Modal -->
<div class="modal fade" id="addVendorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.inventory.vendors.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="create-btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="create-btn-base">Add Vendor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

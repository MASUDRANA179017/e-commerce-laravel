@extends('layouts.master')

@section('title', 'Customer Groups')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Customer Groups</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Groups</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Group List</h5>
                <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                    <span class="material-symbols-outlined fs-14">add</span> Add Group
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Group Name</th>
                                <th>Discount</th>
                                <th>Members</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($groups as $group)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-medium">{{ $group->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $group->discount_percentage }}%</td>
                                <td>0</td> <!-- Placeholder for members count if needed -->
                                <td>
                                    @if($group->is_active)
                                        <span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Active</span>
                                    @else
                                        <span class="qbit-badge-danger"><i class="bx bx-x-circle"></i> Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-success me-1 edit-group-btn" 
                                        data-id="{{ $group->id }}"
                                        data-name="{{ $group->name }}"
                                        data-discount="{{ $group->discount_percentage }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editGroupModal"
                                        title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.customers.groups.destroy', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-danger" title="Delete"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">No groups found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


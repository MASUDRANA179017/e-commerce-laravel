@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

@include('admin.user_management.partials.manage-user-css')
<div class="container-fluid">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="qb-wizard">
                    <div class="qb-wizard-nav" id="gs-nav">
                        <div class="qb-wizard-tab is-active" data-tab="gs-1">
                            <div class="qb-wizard-tab-icon"><i class="bx bxs-user-account"></i></div>
                            <div>
                                <h6 class="mb-0">User Management</h6>
                                <span class="text-secondary">Create & Manage Users</span>
                            </div>
                        </div>
                        <div class="qb-wizard-tab" data-tab="gs-2">
                            <div class="qb-wizard-tab-icon"><i class="bx bxs-shield-alt-2"></i></div>
                            <div>
                                <h6 class="mb-0">Role Management</h6>
                                <span class="text-secondary">Create & Manage Roles</span>
                            </div>
                        </div>
                        <div class="qb-wizard-tab" data-tab="gs-3">
                            <div class="qb-wizard-tab-icon"><i class="bx bx-list-check"></i></div>
                            <div>
                                <h6 class="mb-0">Permission Matrix</h6>
                                <span class="text-secondary">Assign Permissions</span>
                            </div>
                        </div>
                        <div class="qb-wizard-tab" data-tab="gs-4">
                            <div class="qb-wizard-tab-icon"><i class="bx bx-user-check"></i></div>
                            <div>
                                <h6 class="mb-0">Role Assignment</h6>
                                <span class="text-secondary">Assign Roles to Users</span>
                            </div>
                        </div>
                    </div>
                    <div class="qb-wizard-content">
                        <div class="qb-wizard-pane is-active" id="gs-1">
                            <div class="card card-light-primary">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="qb-card-title-sm mb-0">User List</h4>
                                        <p class="fs-12 fw-300 lh-1 qb-text-light mb-0">Create, view, and manage all
                                            system users.</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="create-btn-info" data-bs-toggle="modal"
                                            data-bs-target="#createUserModal"><i
                                                class="bx bx-user-plus bx-tada me-1"></i> Create New User</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="search-filter-container">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="input-group"><span class="input-group-text"><i
                                                            class="bx bx-search"></i></span><input type="text"
                                                        class="form-control"
                                                        placeholder="Search users by name, email..." id="userSearch">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-select" id="roleFilter">
                                                    <option value="">Filter by Role</option>
                                                    @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-select" id="statusFilter">
                                                    <option value="">Filter by Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2"><button class="btn btn-outline-secondary w-100"
                                                    id="clearFilters"><i class="bx bx-refresh"></i> Clear</button></div>
                                        </div>
                                    </div>
                                    <div class="table">
                                        <table class="display table table-hover" id="usersTable">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="selectAllUsers"></th>
                                                    <th>User</th>
                                                    <th>Contact</th>
                                                    <th>Role(s)</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                    <th>Joined</th>
                                                    <th class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="qb-wizard-pane" id="gs-2">
                            <div class="card card-light-info">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="qb-card-title-sm mb-0">Role List</h4>
                                        <p class="fs-12 fw-300 lh-1 qb-text-light mb-0">Define user roles and their
                                            high-level purpose.</p>
                                    </div>
                                    <a href="#" class="create-btn-info" data-bs-toggle="modal"
                                        data-bs-target="#createRoleModal"><i class="bx bx-plus-circle bx-tada me-1"></i>
                                        Create New Role</a>
                                </div>
                                <div class="card-body">
                                    <table class="display table table-hover" id="rolesTable">
                                        <thead>
                                            <tr>
                                                <th>Role Name</th>
                                                <th>Description</th>
                                                <th>Users Assigned</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="qb-wizard-pane" id="gs-3">
                            <div class="card card-light-warning">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="qb-card-title-sm mb-0">Permission Matrix</h4>
                                        <p class="fs-12 fw-300 lh-1 qb-text-light mb-0">Assign detailed permissions to
                                            roles for each module.</p>
                                    </div>
                                    <button class="create-btn-info" id="savePermissionsBtn"><i
                                            class="bx bx-save me-1"></i> Save
                                        Permissions</button>
                                </div>
                                <div class="card-body">
                                    <div class="search-filter-container">
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="bx bx-shield-alt-2"></i></span>
                                                    <select class="form-select" id="roleSelect">
                                                        <option value="">Select a Role to Configure</option>
                                                        @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group"><span class="input-group-text"><i
                                                            class="bx bx-search"></i></span><input type="text"
                                                        class="form-control" placeholder="Search for a permission...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="permissionMatrix">
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="qb-card-light-purple h-100">
                                                <div
                                                    class="card-header p-2 px-3  d-flex justify-content-between align-items-center">
                                                    <h4 class="qb-card-title-sm"><i
                                                            class="bx bx-briefcase-alt-2"></i>Projects</h4>
                                                    <div class="form-check mb-0 d-flex align-items-center"> <input
                                                            class="form-check-input module-select-all" type="checkbox"
                                                            id="Projects0All"> <label
                                                            class="form-check-label d-block mb-0"
                                                            for="Projects0All">Select All</label> </div>
                                                </div>
                                                <div class="permission-group">
                                                    <div class="permission-item p-0 px-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input perm-checkbox"
                                                                type="checkbox" id="Projects0Create">
                                                            <label class="form-check-label d-block mb-0"
                                                                for="Projects0Create">
                                                                <span>Create Projects</span>
                                                                <div class="permission-description">Allow user to
                                                                    create projects</div>
                                                            </label>
                                                        </div>
                                                        <span class="state-badge qbit-badge-danger"><i
                                                                class="bx bx-x-circle me-1"></i>Denied</span>
                                                    </div>
                                                    <div class="permission-item p-0 px-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input perm-checkbox"
                                                                type="checkbox" id="Projects0View">
                                                            <label class="form-check-label d-block mb-0"
                                                                for="Projects0View">
                                                                <span>View Projects</span>
                                                                <div class="permission-description">Allow user to view
                                                                    projects</div>
                                                            </label>
                                                        </div>
                                                        <span class="state-badge qbit-badge-danger"><i
                                                                class="bx bx-x-circle me-1"></i>Denied</span>
                                                    </div>
                                                    <div class="permission-item p-0 px-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input perm-checkbox"
                                                                type="checkbox" id="Projects0Update">
                                                            <label class="form-check-label d-block mb-0"
                                                                for="Projects0Update">
                                                                <span>Update Projects</span>
                                                                <div class="permission-description">Allow user to
                                                                    update projects</div>
                                                            </label>
                                                        </div>
                                                        <span class="state-badge qbit-badge-danger"><i
                                                                class="bx bx-x-circle me-1"></i>Denied</span>
                                                    </div>
                                                    <div class="permission-item p-0 px-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input perm-checkbox"
                                                                type="checkbox" id="Projects0Delete">
                                                            <label class="form-check-label d-block mb-0"
                                                                for="Projects0Delete">
                                                                <span>Delete Projects</span>
                                                                <div class="permission-description">Allow user to
                                                                    delete projects</div>
                                                            </label>
                                                        </div>
                                                        <span class="state-badge qbit-badge-danger"><i
                                                                class="bx bx-x-circle me-1"></i>Denied</span>
                                                    </div>
                                                    <div class="permission-item p-0 px-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input perm-checkbox"
                                                                type="checkbox" id="Projects0ShowSideBar">
                                                            <label class="form-check-label d-block mb-0"
                                                                for="Projects0ShowSideBar">
                                                                <span>Show in Sidebar</span>
                                                                <div class="permission-description">Allow user to
                                                                    showsidebar projects</div>
                                                            </label>
                                                        </div>
                                                        <span class="state-badge qbit-badge-danger"><i
                                                                class="bx bx-x-circle me-1"></i>Denied</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="qb-wizard-pane" id="gs-4">
                            <div class="card card-light-success">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="qb-card-title-sm mb-0">Role Assignment</h4>
                                        <p class="fs-12 fw-300 lh-1 qb-text-light mb-0">Assign one or more roles to
                                            system users.</p>
                                    </div>
                                    <a href="#" class="create-btn-info" data-bs-toggle="modal"
                                        data-bs-target="#assignRoleModal"><i class="bx bx-plus-circle bx-tada me-1"></i>
                                        Assign Role to User</a>
                                </div>
                                <div class="card-body">
                                    <table class="display table table-hover" id="assignmentTable">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Current Role(s)</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Last Updated</th>
                                                <!-- <th class="text-end">Actions</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.user_management.modals.create-user-modal')
@include('admin.user_management.modals.create-role-modal')
@include('admin.user_management.modals.edit-role-modal')
@include('admin.user_management.modals.assign-role-modal')
@include('admin.user_management.modals.edit-user-modal')


@push('scripts')
{{-- External Libraries --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
                // ------------------- GLOBAL SETUP -------------------
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Initialize Select2 dropdowns
                $('#roleFilter, #statusFilter, #permissionRoleSelect, #assignUser, #assignRole').select2({
                    theme: "bootstrap-5",
                    width: '100%'
                });

                // Keep references for DataTables
                let usersTable, rolesTable, assignmentTable;

                // ------------------- WIZARD TAB LOGIC -------------------
                $('.qb-wizard-tab').on('click', function() {
                    const targetPaneId = $(this).data('tab');

                    $('.qb-wizard-tab').removeClass('is-active');
                    $(this).addClass('is-active');
                    $('.qb-wizard-pane').removeClass('is-active');
                    $('#' + targetPaneId).addClass('is-active');

                    // Lazy load only when tab is clicked the first time
                    if (targetPaneId === 'gs-1' && !usersTable) {
                        usersTable = $('#usersTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                    url: "{{ route('admin.users.index') }}",
                                    data: function (d) {
                                        d.customSearch = $('#userSearch').val(); // send our custom search
                                        d.roleId = $('#roleFilter').val();
                                        d.status = $('#statusFilter').val();
                                    }
                                },
                            columns: [{
                                    data: 'id',
                                    render: data =>
                                        `<input type="checkbox" value="${data}" class="user-checkbox">`,
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'user_info',
                                    name: 'name'
                                },
                                {
                                    data: 'contact',
                                    name: 'email'
                                },
                                {
                                    data: 'roles',
                                    name: 'roles.name',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'department',
                                    name: 'department'
                                },
                                {
                                    data: 'status',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'created_at',
                                    render: data => new Date(data).toLocaleDateString('en-US', {
                                        month: 'short',
                                        day: 'numeric',
                                        year: 'numeric'
                                    })
                                },
                                {
                                    data: 'action',
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-end'
                                }
                            ],
                            searching: false,
                        });
                    }

                    if (targetPaneId === 'gs-2' && !rolesTable) {
                        rolesTable = $('#rolesTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('admin.roles.index') }}",
                            columns: [{
                                    data: 'name'
                                },
                                {
                                    data: 'description',
                                    defaultContent: 'N/A'
                                },
                                {
                                    data: 'users_count',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'status',
                                    defaultContent: '<span class="qbit-badge-success">Active</span>'
                                },
                                {
                                    data: 'created_at',
                                    render: data => new Date(data).toLocaleDateString('en-US', {
                                        month: 'short',
                                        day: 'numeric',
                                        year: 'numeric'
                                    })
                                },
                                {
                                    data: 'action',
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-end'
                                }
                            ]
                        });
                    }

                    if (targetPaneId === 'gs-4' && !assignmentTable) {
                        assignmentTable = $('#assignmentTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('admin.users.index') }}",
                            columns: [{
                                    data: 'user_info',
                                    name: 'name'
                                },
                                {
                                    data: 'roles',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'department',
                                    name: 'department'
                                },
                                {
                                    data: 'status',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'updated_at',
                                    render: data => new Date(data).toLocaleDateString()
                                },
                                // {
                                //     data: 'action',
                                //     orderable: false,
                                //     searchable: false,
                                //     className: 'text-end',
                                //     render: (data, type, row) => `
                                //     <a href="javascript:void(0)" class="assign-role-btn"
                                //        data-user-id="${row.id}" data-bs-toggle="modal"
                                //        data-bs-target="#assignRoleModal" title="Change Role">

                                //     </a>`
                                // }
                            ]
                        });
                    }
                });

                // After initializing usersTable
                $('#userSearch').on('keyup', function () {
                    usersTable.ajax.reload();
                });

                $('#roleFilter').on('change', function () {
                    usersTable.ajax.reload();
                });

                $('#statusFilter').on('change', function () {
                    usersTable.ajax.reload();
                });

                $('#clearFilters').on('click', function () {
                    $('#userSearch').val('');
                    $('#roleFilter').val('').trigger('change');
                    $('#statusFilter').val('').trigger('change');
                    usersTable.ajax.reload();
                });




                // Auto trigger Users tab on page load
                $('.qb-wizard-tab[data-tab="gs-1"]').trigger('click');


                // =================== USER CREATE ===================
                $('#createUserModal').on('show.bs.modal', function() {
                    $('#createUserForm').trigger("reset");
                    $('#createUserForm').find('input[name="user_id"]').remove();
                    $('.modal-title').html('<i class="bx bx-user-plus me-2"></i>Create New User');
                    $('#createUserBtn').html('<i class="bx bx-user-plus me-1"></i>Create User');
                });

                $('#createUserBtn').on('click', function(e) {
                    e.preventDefault();

                    let form = $('#createUserForm')[0];
                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('admin.users.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.success,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $('#createUserModal').modal('hide');
                                $('#createUserForm')[0].reset();
                                if (usersTable) usersTable.ajax.reload(null, false);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let errorMsg = "";
                                $.each(errors, function(key, value) {
                                    errorMsg += value[0] + "<br>";
                                });

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: errorMsg
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!'
                                });
                            }
                        }
                    });
                });

                // Trigger file input when clicking the Upload button
                $('#uploadImageBtn').on('click', function() {
                    $('#profileImageInput').click();
                });


                $('#profileImageInput').on('change', function() {
                    const reader = new FileReader();
                    reader.onload = e => $('#profileImagePreview').attr('src', e.target.result);
                    reader.readAsDataURL(this.files[0]);
                });
                // Reset to default image
                $('#resetImageBtn').on('click', function() {
                    $('#profileImagePreview').attr('src', 'assets/img/avatar-1.jpg');
                    $('#profileImageInput').val('');
                });

                // Delete user
                $(document).on('click', '.delete-user', function() {
                    var userId = $(this).data('id');
                    var token = "{{ csrf_token() }}";

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: '/admin/users/' + userId,
                                type: 'DELETE',
                                data: {
                                    "_token": token
                                },
                                success: function(response) {
                                    if(response.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.success,
                                            'success'
                                        );

                                        // Reload datatable after deletion
                                        $('#usersTable').DataTable().ajax.reload();
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire(
                                        'Error!',
                                        'Something went wrong while deleting user.',
                                        'error'
                                    );
                                }
                            });

                        }
                    });
                });



                // =================== ROLE CREATE/EDIT ===================
                $('#createRoleModal').on('show.bs.modal', function() {
                    $('#createRoleForm').trigger("reset");
                    $('#role_id').val('');
                    $('#createRoleModal .modal-title').html(
                        '<i class="bx bx-shield-alt-2 me-2"></i>Create New Role');
                    $('#createRoleBtn').html('<i class="bx bx-shield-alt-2 me-1"></i>Create Role');
                });

                $('#createRoleForm').on('submit', function(e) {
                    e.preventDefault();

                    const roleId = $('#role_id').val();
                    let url = roleId ? `/admin/roles/${roleId}` : "{{ route('admin.roles.store') }}";
                    let method = roleId ? 'PUT' : 'POST';

                    $('#createRoleBtn').prop('disabled', true).html('Saving...');

                    $.ajax({
                        url: url,
                        method: method,
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#createRoleModal').modal('hide');
                            if (rolesTable) rolesTable.ajax.reload();
                            if (usersTable) usersTable.ajax.reload();
                            Swal.fire('Success!', response.success, 'success');
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = 'An unexpected error occurred.';
                            if (errors && errors.name) {
                                errorMsg = errors.name[0];
                            }
                            Swal.fire('Error!', errorMsg, 'error');
                        },
                        complete: function() {
                            $('#createRoleBtn').prop('disabled', false).html(roleId ?
                                'Save Changes' : 'Create Role');
                        }
                    });
                });

                $('#createRoleBtn').on('click', function() {
                    $('#createRoleForm').submit();
                });

                // role edit
                $(document).on('click', '.edit-role', function () {
                    var roleId = $(this).data('id');

                    // Fetch role data
                    $.get('/admin/roles/' + roleId + '/show', function (data) {
                        $('#edit_role_id').val(data.id);
                        $('#edit_role_name').val(data.name);
                        $('#edit_role_description').val(data.description || '');
                        $('#edit_role_status').val(data.status || 'active');

                        $('#editRoleModal').modal('show');
                    });
                });

                // Update role via AJAX
                $('#updateRoleBtn').click(function () {
                    var id = $('#edit_role_id').val();
                    var formData = $('#editRoleForm').serialize();

                    $.ajax({
                        url: '/admin/roles/' + id,
                        method: 'PUT',
                        data: formData,
                        success: function (response) {
                            $('#editRoleModal').modal('hide');
                            $('#rolesTable').DataTable().ajax.reload(); // reload datatable
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.success,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            // show validation errors
                            console.log(errors);
                        }
                    });
                });


                // Delete role
                $(document).on('click', '.delete-role', function () {
                    var id = $(this).data('id');

                    // SweetAlert2 confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: '/admin/roles/' + id,  // matches Route::delete('/{role}', 'destroy')
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    $('#rolesTable').DataTable().ajax.reload(); // refresh table
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.success,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!'
                                    });
                                    console.log(xhr.responseText);
                                }
                            });

                        }
                    });
                });


                // search  Permission Matrix
                $(document).ready(function() {
                    // Search input select
                    var $searchInput = $('.search-filter-container input[type="text"]');

                    $searchInput.on('keyup', function() {
                        var filter = $(this).val().toLowerCase();

                        $('#permissionMatrix > .col-lg-4').each(function() {
                            var title = $(this).find('.qb-card-title-sm').text().toLowerCase();

                            if (title.indexOf(filter) > -1) {
                                $(this).show(); // Show card
                            } else {
                                $(this).hide(); // Hide card
                            }
                        });
                    });
                });


                // =================== ROLE ASSIGNMENT ===================
                $('#assignRoleModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var userId = button.data('user-id');
                    var modal = $(this);

                    modal.find('form').trigger('reset');
                    modal.find('#assignUser').val(null).trigger('change');
                    modal.find('#assignRole').val(null).trigger('change');

                    if (userId) {
                        $.get(`/admin/users/${userId}/show`, function(data) {
                            var userOption = new Option(data.name, data.id, true, true);
                            modal.find('#assignUser').append(userOption).trigger('change');
                            var roleIds = data.roles.map(role => role.id);
                            modal.find('#assignRole').val(roleIds).trigger('change');
                        });
                    }
                });

                $('#assignRoleBtn').on('click', function(e) {
                    e.preventDefault();

                    var userId = $('#assignUser').val();
                    var role = $('#assignRole').val(); // single role ID

                    if (!userId || !role) {
                        Swal.fire('Error', 'Please select a user and a role.', 'error');
                        return;
                    }

                    $.ajax({
                        url: `/admin/users/assign-roles`,
                        method: 'POST',
                        data: {
                            user_id: userId,
                            role: role, // single role
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#assignRoleModal').modal('hide');
                            if (assignmentTable) assignmentTable.ajax.reload();
                            if (usersTable) usersTable.ajax.reload();
                            Swal.fire('Success', response.success, 'success');
                        },
                        error: function(xhr) {
                            let errorMsg = 'Failed to assign role.';
                            if (xhr.responseJSON?.errors) {
                                errorMsg = Object.values(xhr.responseJSON.errors).flat().join(
                                    '<br>');
                            }
                            Swal.fire('Error', errorMsg, 'error');
                        }
                    });
                });


            });

            // --- Global function to switch tabs from outside ---
            function switchToPermissionsTab(roleId) {
                document.querySelector('.qb-wizard-tab[data-tab="gs-3"]').click();
                $('#permissionRoleSelect').val(roleId).trigger('change');
            }

            let permissionsLoaded = false;
            let allPermissionsCache = null; // store all_permissions globally

            // Load all permissions when tab is opened first time
            $('.qb-wizard-tab').on('click', function() {
                const targetPaneId = $(this).data('tab');

                if (targetPaneId === 'gs-3' && !permissionsLoaded) {
                    $.get("/admin/permissions", function(response) {
                        allPermissionsCache = response.all_permissions; // cache
                        renderPermissions(allPermissionsCache, []); // initially no role selected
                        permissionsLoaded = true;
                    });
                }
            });

            // Handle role change
            $('#roleSelect').on('change', function() {
                const roleId = $(this).val();
                console.log("Selected Role ID:", roleId);

                if (!roleId) {
                    $('.perm-checkbox').prop('checked', false)
                        .closest('.permission-item')
                        .find('.state-badge')
                        .removeClass('qbit-badge-success')
                        .addClass('qbit-badge-danger')
                        .html('<i class="bx bx-x-circle me-1"></i>Denied');
                    return;
                }

                $.get(`/admin/roles/${roleId}/show`, function(response) {
                    console.log("Role response:", response);

                    // Extract role permission IDs
                    const rolePermissionIds = response.permissions.map(p => p.id);

                    // Re-render using cached allPermissions
                    if (allPermissionsCache) {
                        renderPermissions(allPermissionsCache, rolePermissionIds);
                    } else {
                        // fallback: load again if cache is empty
                        $.get("/admin/permissions", function(allResp) {
                            allPermissionsCache = allResp.all_permissions;
                            renderPermissions(allPermissionsCache, rolePermissionIds);
                        });
                    }
                });
            });

            // RENDER PERMISSIONS GRID
            function renderPermissions(allPermissions, rolePermissions) {
                let html = '';
                let moduleIndex = 0;

                $.each(allPermissions, function(module, permissions) {
                    html += `
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="qb-card-light-purple h-100">
                    <div class="card-header p-2 px-3 d-flex justify-content-between align-items-center">
                        <h4 class="qb-card-title-sm"><i class="bx bx-folder"></i> ${capitalize(module)}</h4>
                        <div class="form-check mb-0 d-flex align-items-center">
                            <input class="form-check-input module-select-all" type="checkbox" id="${module}${moduleIndex}All">
                            <label class="form-check-label d-block mb-0" for="${module}${moduleIndex}All">Select All</label>
                        </div>
                    </div>
                    <div class="permission-group">
        `;

                    permissions.forEach(perm => {
                        const checked = rolePermissions.includes(perm.id) ? 'checked' : '';
                        const badge = rolePermissions.includes(perm.id) ?
                            `<span class="state-badge qbit-badge-success"><i class="bx bx-check-circle me-1"></i>Allowed</span>` :
                            `<span class="state-badge qbit-badge-danger"><i class="bx bx-x-circle me-1"></i>Denied</span>`;

                        html += `
                <div class="permission-item p-0 px-3">
                    <div class="form-check">
                        <input class="form-check-input perm-checkbox" type="checkbox"
                               data-id="${perm.id}" id="${module}${moduleIndex}${perm.id}" ${checked}>
                        <label class="form-check-label d-block mb-0" for="${module}${moduleIndex}${perm.id}">
                            <span>${formatLabel(perm.name)}</span>
                            <div class="permission-description">${perm.guard_name || ''}</div>
                        </label>
                    </div>
                    ${badge}
                </div>
            `;
                    });

                    html += `
                    </div>
                </div>
            </div>
        `;
                    moduleIndex++;
                });

                $('#permissionMatrix').html(html);

                // Bind checkbox events after rendering
                bindPermissionEvents();
            }

            // ✅ Bind events (select all + individual checkbox updates)
            function bindPermissionEvents() {
                // Select all inside a module
                $('.module-select-all').on('change', function() {
                    const group = $(this).closest('.qb-card-light-purple').find('.perm-checkbox');
                    const checked = $(this).is(':checked');
                    group.prop('checked', checked).trigger('change');
                });

                // Update badge when individual permission checkbox is toggled
                $('.perm-checkbox').on('change', function() {
                    const badge = $(this).closest('.permission-item').find('.state-badge');
                    if ($(this).is(':checked')) {
                        badge.removeClass('qbit-badge-danger').addClass('qbit-badge-success')
                            .html('<i class="bx bx-check-circle me-1"></i>Allowed');
                    } else {
                        badge.removeClass('qbit-badge-success').addClass('qbit-badge-danger')
                            .html('<i class="bx bx-x-circle me-1"></i>Denied');
                    }
                });
            }

            // Helpers
            function capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            function formatLabel(name) {
                return name.split('.').pop().replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase());
            }
            // SAVE PERMISSIONS
            $('#savePermissionsBtn').on('click', function() {
                const roleId = $('#roleSelect').val();

                if (!roleId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Role Selected',
                        text: 'Please select a role before saving permissions.',
                    });
                    return;
                }

                // collect all checked permissions
                const selectedPermissions = $('.perm-checkbox:checked')
                    .map(function() {
                        return $(this).data('id');
                    })
                    .get();


                $.ajax({
                    url: `/admin/roles/${roleId}/permissions`, // adjust route if needed
                    method: "POST", // or PUT depending on your backend
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for Laravel
                        permissions: selectedPermissions
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Permissions Updated',
                            text: 'The role permissions have been saved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Saving Permissions',
                            text: xhr.responseJSON?.message ||
                                "Something went wrong. Please try again.",
                        });
                    }
                });
            });
</script>

{{-- edit and update user --}}
<script>
    $(document).ready(function() {

                // Show image preview when selecting new image
                $('#editProfileImageInput').on('change', function() {
                    const reader = new FileReader();
                    reader.onload = e => $('#editProfileImagePreview').attr('src', e.target.result);
                    reader.readAsDataURL(this.files[0]);
                });

                // Reset image button
                $('#editResetImageBtn').on('click', function() {
                    $('#editProfileImagePreview').attr('src', 'assets/img/avatar-1.jpg');
                    $('#editProfileImageInput').val('');
                });

                // Click edit button
                $(document).on('click', '.edit-user', function() {
                    let userId = $(this).data('id');

                    $.ajax({
                        url: `/admin/users/${userId}/show`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(user) {
                            $('#editUserId').val(user.id);
                            $('#editFullName').val(user.name);
                            $('#editEmail').val(user.email);
                            $('#editPhone').val(user.phone);
                            $('#editUsername').val(user.username);
                            $('#editDepartment').val(user.department);
                            $('#editDesignation').val(user.designation);
                            $('#editRole').val(user.roles.length ? user.roles[0].id : '');
                            $('#editStatus').val(user.status);
                            $('#editAddress').val(user.address);

                            // Profile image
                            let avatar = user.image ? `/storage/${user.image}` :
                                'assets/img/avatar-1.jpg';
                            console.log(avatar);
                            $('#editProfileImagePreview').attr('src', avatar);

                            $('#editUserModal').modal('show');
                        },
                        error: function(err) {
                            console.error(err);
                            alert('Failed to load user data');
                        }
                    });
                });

                // Update user
                // $('#updateUserBtn').on('click', function() {
                //     let userId = $('#editUserId').val();
                //     let formData = new FormData($('#editUserForm')[0]);

                //     $.ajax({
                //         url: `/admin/user/${userId}`,
                //         type: 'POST',
                //         data: formData,
                //         contentType: false,
                //         processData: false,
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         },
                //         success: function(res) {
                //             $('#editUserModal').modal('hide');
                //             $('#usersTable').DataTable().ajax.reload();
                //             alert('User updated successfully');
                //         },
                //         error: function(err) {
                //             console.error(err);
                //             alert('Failed to update user');
                //         }
                //     });
                // });

                $('#updateUserBtn').on('click', function() {
                    let userId = $('#editUserId').val();
                    let formData = new FormData($('#editUserForm')[0]);
                    
                    let imageFile = $('#editProfileImageInput')[0].files[0]; // get file
                    if (imageFile) {
                        formData.append('profile_image', imageFile); // manually add it
                    }
                    // Add _method for PUT request
                    formData.append('_method', 'PUT');

                    $.ajax({
                        url: `/admin/users/${userId}`, // match your route
                        type: 'POST', // still POST but _method=PUT
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            console.log(formData);
                            $('#editUserModal').modal('hide');
                            $('#usersTable').DataTable().ajax.reload(null, false); // reload table without resetting pagination
                            Swal.fire('Success!', res.success, 'success');
                        },
                        error: function(err) {
                            console.error(err);
                            if(err.status === 422){
                                let errors = err.responseJSON.errors;
                                let errorText = Object.values(errors).flat().join('<br>');
                                Swal.fire('Validation Error', errorText, 'error');
                            } else {
                                Swal.fire('Error', 'Failed to update user', 'error');
                            }
                        }
                    });
                });

            });
</script>

{{-- status toggle --}}
<script>
    $(document).on('change', '.status-toggle', function (e) {
                let checkbox = $(this);
                let userId = checkbox.data('id');
                let newStatus = checkbox.is(':checked') ? 1 : 0;

                // সঙ্গে সঙ্গে checkbox revert করো
                checkbox.prop('checked', !newStatus);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to change this user's status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/users/status/${userId}`,
                            type: 'POST',
                            data: {
                                status: newStatus,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (res) {
                                Swal.fire('Updated!', res.message, 'success');
                                checkbox.prop('checked', newStatus === 1);
                                if ($.fn.DataTable.isDataTable('#usersTable')) {
                                    $('#usersTable').DataTable().ajax.reload(null, false);
                                }
                                if ($.fn.DataTable.isDataTable('#assignmentTable')) {
                                    $('#assignmentTable').DataTable().ajax.reload(null, false);
                                }
                            },
                            error: function () {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });

</script>
@endpush

@endsection

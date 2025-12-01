    <div class="modal fade" id="createRoleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-shield-alt-2 me-2"></i>Create New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createRoleForm">
                        {{-- This hidden input is for handling updates. Leave it here. --}}
                        <input type="hidden" name="role_id" id="role_id">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                                    {{-- Added name="name" --}}
                                    <input type="text" class="form-control custom-input" placeholder="Enter role name"
                                        name="name" required>
                                    <div class="form-text">Choose a descriptive name for this role</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    {{-- Added name="description" --}}
                                    <textarea class="form-control custom-input" rows="3" name="description" placeholder="Enter role description"></textarea>
                                    <div class="form-text">Describe what this role is responsible for</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    {{-- Added name="status" --}}
                                    <select class="form-select custom-input" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-outline-primary me-2">
                        <i class="bx bx-reset me-1"></i>Reset Form
                    </button>
                    <button type="button" class="btn btn-primary" id="createRoleBtn">
                        <i class="bx bx-shield-alt-2 me-1"></i>Create Role
                    </button>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script >
            // Reset Create Role Form
            $(document).on('click', '.btn-outline-primary', function() {
                $('#createRoleForm')[0].reset(); // reset all fields
                $('#role_id').val(''); // clear hidden input just in case
            });
        </script>
    @endpush
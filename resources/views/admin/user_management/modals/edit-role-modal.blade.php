<div class="modal fade" id="editRoleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-edit-alt me-2"></i>Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm" >
                    {{-- Hidden input for role ID --}}
                    <input type="hidden" name="role_id" id="edit_role_id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control custom-input" placeholder="Enter role name"
                                    name="name" id="edit_role_name" required>
                                <div class="form-text">Update the name of this role</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea class="form-control custom-input" rows="3" name="description" 
                                    id="edit_role_description" placeholder="Enter role description"></textarea>
                                <div class="form-text">Update the responsibilities of this role</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-select custom-input" name="status" id="edit_role_status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="create-btn-white" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Cancel
                </button>
                <button type="button" class="create-btn-info-alt me-2" id="resetEditRoleForm">
                    <i class="bx bx-reset me-1"></i>Reset Form
                </button>
                <button type="button" class="create-btn-base" id="updateRoleBtn">
                    <i class="bx bx-edit-alt me-1"></i>Update Role
                </button>
            </div>
        </div>
    </div>
</div>

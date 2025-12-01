    <div class="modal fade" id="assignRoleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-user-check me-2"></i>Assign Role to User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="assignRoleForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select User <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select custom-input" id="assignUser" required>
                                        <option value="">Choose User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select Role(s) <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select custom-input" id="assignRole" required>
                                        <option value="">Choose Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
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

                    <button type="button" class="btn btn-primary" id="assignRoleBtn">
                        <i class="bx bx-user-check me-1"></i>Assign Role(s)
                    </button>
                </div>
            </div>
        </div>
    </div>
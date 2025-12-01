    <div class="modal fade" id="editUserModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-edit me-2"></i>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column - User Information -->
                    <div class="col-md-8">
                        <div class="card card-light-purple mb-3">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bx bx-info-circle me-2"></i>Basic Information</h6>
                            </div>
                            <div class="card-body">
                                <form id="editUserForm" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" id="editUserId">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control custom-input"
                                                    name="name" id="editFullName" placeholder="Enter full name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control custom-input"
                                                    name="email" id="editEmail" placeholder="Enter email address" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Phone Number</label>
                                                <input type="text" class="form-control custom-input"
                                                    name="phone" id="editPhone" placeholder="Enter phone number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Role</label>
                                                <select name="role" id="editRole" class="form-select">
                                                    <option value="">Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control custom-input"
                                                        name="password" id="editPassword" placeholder="Enter new password (leave blank to keep current)">
                                                    <button class="btn btn-outline-secondary" type="button" id="toggleEditPassword">
                                                        <i class="bx bx-hide"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Confirm Password</label>
                                                <input type="password" class="form-control custom-input"
                                                    name="password_confirmation" id="editPasswordConfirm" placeholder="Confirm new password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Department</label>
                                                <select name="department" id="editDepartment" class="form-select">
                                                    <option value="">Select Department</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Designation</label>
                                                <select name="designation" id="editDesignation" class="form-select">
                                                    <option value="">Select Designation</option>
                                                    @foreach ($designations as $designation)
                                                        <option value="{{ $designation->id }}">{{ $designation->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status</label>
                                                <select class="form-select custom-input" name="status" id="editStatus">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Address</label>
                                                <textarea class="form-control custom-input" name="address" id="editAddress" rows="2" placeholder="Enter complete address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Profile Image & Settings -->
                    <div class="col-md-4">
                        <div class="card card-light-primary mb-3">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bx bx-image me-2"></i>Profile Image</h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="profile-image-upload mx-auto mb-3">
                                    <img src="assets/img/avatar-1.jpg" alt="Profile Image" id="editProfileImagePreview">
                                </div>
                                <input type="file" name="profile_image" id="editProfileImageInput" accept="image/*" style="display: none;">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm me-2"
                                        onclick="document.getElementById('editProfileImageInput').click()">
                                        <i class="bx bx-upload me-1"></i> Upload Image
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="editResetImageBtn">
                                        <i class="bx bx-reset"></i> Reset
                                    </button>
                                </div>
                                <p class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="updateUserBtn">
                    <i class="bx bx-edit me-1"></i>Update User
                </button>
            </div>
        </div>
    </div>
</div>

    
    
    {{--   
    <div class="modal fade" id="editUserModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-edit me-2"></i>Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" id="editUserId">

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Full Name</label>
                                        <input type="text" name="full_name" class="form-control" id="editFullName">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" id="editEmail">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" id="editPhone">
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" id="editUsername">
                                    </div> -->
                                    <div class="col-md-6">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" id="editPassword"
                                            placeholder="Leave blank to keep current">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="editPasswordConfirm">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Department</label>
                                        <select name="department_id" class="form-select" id="editDepartment">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Designation</label>
                                        <select name="designation_id" class="form-select" id="editDesignation">
                                            <option value="">Select Designation</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}">{{ $designation->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Role</label>
                                        <select name="role" class="form-select" id="editRole">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select name="status" class="form-select" id="editStatus">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control" id="editAddress" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Image & Upload -->
                            <div class="col-md-4">
                                <div class="card card-light-primary mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="bx bx-image me-2"></i>Profile Image</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <!-- Preview Image -->
                                        <img src="assets/img/avatar-1.jpg" alt="Profile Image" id="profileImagePreview"
                                            style="width:150px;height:150px;object-fit:cover;"
                                            class="mb-3 rounded-circle">

                                        <!-- Hidden File Input -->
                                        <input type="file" id="profileImageInput" name="profile_image"
                                            accept="image/*" style="display: none;">

                                        <!-- Buttons -->
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-outline-primary btn-sm me-2"
                                                id="uploadImageBtn">
                                                <i class="bx bx-upload me-1"></i> Upload Image
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                id="resetImageBtn">
                                                <i class="bx bx-reset"></i> Reset
                                            </button>
                                        </div>
                                        <p class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateUserBtn">Update User</button>
                </div>
            </div>
        </div>
    </div>
    --}}
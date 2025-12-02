    <div class="modal fade" id="createUserModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-user-plus me-2"></i>Create New User</h5>
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
                                    <form id="createUserForm" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Full Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control custom-input"
                                                        name="full_name" placeholder="Enter full name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Email Address <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" class="form-control custom-input"
                                                        name="email" placeholder="Enter email address" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Phone Number</label>
                                                    <input type="text" class="form-control custom-input"
                                                        name="phone" placeholder="Enter phone number">
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Username <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control custom-input"
                                                        name="username" placeholder="Enter username" required>
                                                </div>
                                            </div> -->

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Role</label>
                                                    <select name="role" class="form-select">
                                                        <option value="">Select Role</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Password <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control custom-input"
                                                            name="password" placeholder="Enter password"
                                                            id="userPassword" required>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="togglePassword">
                                                            <i class="bx bx-hide"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Confirm Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="password" class="form-control custom-input"
                                                        name="password_confirmation" placeholder="Confirm password"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Department</label>
                                                    <select name="department" class="form-select">
                                                        <option value="">Select Department</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}">{{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Designation</label>
                                                    <select name="designation" class="form-select">
                                                        <option value="">Select Designation</option>
                                                        @foreach ($designations as $designation)
                                                            <option value="{{ $designation->id }}">
                                                                {{ $designation->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Status</label>
                                                    <select class="form-select custom-input" name="status">
                                                        <option value=1>Active</option>
                                                        <option value=0>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Address</label>
                                                    <textarea class="form-control custom-input" name="address" rows="2" placeholder="Enter complete address"></textarea>
                                                </div>
                                            </div>
                                        </div>



                                  

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
                                        <img src="assets/img/avatar-1.jpg" alt="Profile Image" id="profileImagePreview">

                                    </div>
                                    <input type="file"  name="profile_image" id="profileImageInput" accept="image/*"
                                        style="display: none;">
                                    <div class="mb-3">
                                        <button type="button" class="select-btn-primary me-2"
                                            onclick="document.getElementById('profileImageInput').click()">
                                            <i class="bx bx-upload me-1"></i> Upload Image
                                        </button>
                                        <button type="button" class="select-btn-white" id="resetImageBtn">
                                            <i class="bx bx-reset"></i> Reset
                                        </button>
                                    </div>
                                    <p class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                      </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="create-btn-white" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Cancel
                    </button>
                    <button type="button" class="create-btn-info-alt me-2" id="resetFormInputFieldsBtn">
                        <i class="bx bx-reset me-1"></i>Reset Form
                    </button>
                    <button type="button" class="create-btn-base" id="createUserBtn">
                        <i class="bx bx-user-plus me-1"></i>Create User
                    </button>
                </div>
            </div>
        </div>
    </div>







    @push('scripts')
        <script>
            // Default image path
            const defaultImage = "/assets/img/avatar-1.jpg";

            // Image Reset
            $('#resetImageBtn').on('click', function () {
                $('#profileImagePreview').attr('src', defaultImage);  // preview reset
                $('#profileImageInput').val('');                      // file input clear
            });

            // পুরো Form Reset
            $('#resetFormInputFieldsBtn').on('click', function () {
                let form = $('#createUserForm')[0];
                form.reset(); // সব input, select, textarea reset হবে

                // // Image reset করে দাও
                // $('#profileImagePreview').attr('src', defaultImage);
                // $('#profileImageInput').val('');
            });

        </script>
    @endpush
@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
    @include('admin.user_management.partials.user-profile-css')
    <div class="container-fluid">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-4">
                    <div class="custom-border-info-1 custom-bg-info-100 rounded ribbon-box right">
                        <div class="card-body p-3 pt-2">
                            <div class="ribbon-two ribbon-two-primary"><span class="fs-12 fw-400">User</span></div>
                            <a class="align-items-center" data-bs-toggle="collapse" href="#outside-member" role="button"
                                aria-expanded="true" aria-controls="outside-member">
                                <div class="d-flex align-items-center overflow-hidden w-100">
                                    <img src="assets/img/avatar-3.jpg"
                                        class="profile-avatar rounded-circle border avatar avatar-sm border-white me-2" alt="img">
                                    <div>
                                        <p class="client-main-title pb-2 detail-full-name">Name</p>
                                        <p class="m-0 project-semi-details-1 text-start" id="detail-role">Role</p>
                                        <p class="m-0 project-semi-details-1 text-start" id="detail-department">Department</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="collapse show client-details-inner bg-white mb-4" id="outside-member">
                            <div class="pt-2 pb-2 p-3 client-details-inner">
                                <div class="mt-3 pt-2 d-flex align-items-center justify-content-between mb-2">
                                    <span class="client-details-title-2 d-inline-flex align-items-center">
                                        <i class="bx bx-calendar-check me-1"></i> Full Name
                                    </span>
                                    <p class="detail-full-name" class="client-details-title-3 text-dark"></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="client-details-title-2 d-inline-flex align-items-center m-0">
                                        <i class="bx bx-calendar-check me-1"></i> Email Address
                                    </span>
                                    <a id="detail-email" href="#" class="client-details-title-3 text-dark m-0"></a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="client-details-title-2 d-inline-flex align-items-center m-0">
                                        <i class="bx bx-calendar-check me-1"></i> Phone Number
                                    </span>
                                    <a id="detail-phone" href="#" class="client-details-title-3 text-dark m-0"></a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="client-details-title-2 d-inline-flex align-items-center m-0">
                                        <i class="bx bx-calendar-check me-1"></i> WhatsApp
                                    </span>
                                    <a id="detail-whatsapp" href="#" class="client-details-title-3 text-dark m-0"></a>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="client-details-title-2 d-inline-flex align-items-center m-0">
                                        <i class="bx bx-calendar-check me-1"></i> Recovery Email
                                    </span>
                                    <a id="detail-recovery-email" href="#"
                                        class="client-details-title-3 text-dark m-0"></a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="client-details-title-2 d-inline-flex align-items-center m-0">
                                        <i class="bx bx-calendar-check me-1"></i> Recovery Phone
                                    </span>
                                    <a id="detail-recovery-phone" href="#"
                                        class="client-details-title-3 text-dark m-0"></a>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-start w-100 client-details-inner pt-1 mt-2">
                                    <span class="w-45 link-sm"><i class="bx bxl-facebook-circle me-2"></i> Facebook</span>
                                    <a id="detail-facebook" href="#" class="link-sm text-dark text-end w-65"></a>
                                </div>
                                <div class="d-flex align-items-center justify-content-start w-100 pt-2">
                                    <span class="w-45 link-sm"><i class="bx bxl-linkedin-square me-2"></i> LinkedIn</span>
                                    <a id="detail-linkedin" href="#" class="link-sm text-dark text-end w-65"></a>
                                </div>
                                <div class="d-flex align-items-center justify-content-start w-100 pt-2">
                                    <span class="w-45 link-sm"><i class="bx bxl-github me-2"></i> GitHub</span>
                                    <a id="detail-github" href="#" class="link-sm text-dark text-end w-65"></a>
                                </div>
                                <div class="d-flex align-items-center justify-content-start w-100 pt-2">
                                    <span class="w-45 link-sm"><i class="bx bx-mobile-vibration me-2"></i> Portfolio
                                        Website</span>
                                    <a id="detail-portfolio" href="#" class="link-sm text-dark text-end w-65"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="qb-wizard">
                        <div class="qb-wizard-nav">
                            <div class="qb-wizard-tab w-33 is-active" data-tab="step-1">
                                <div class="qb-wizard-tab-icon"><i class='bx bx-user-circle'></i></div>
                                <div>
                                    <h6>User Account</h6>
                                    <span>Step 1</span>
                                </div>
                            </div>
                            <div class="qb-wizard-tab w-33" data-tab="step-2">
                                <div class="qb-wizard-tab-icon"><i class='bx bx-shield-quarter'></i></div>
                                <div>
                                    <h6>Password & Security</h6>
                                    <span>Step 2</span>
                                </div>
                            </div>
                            <div class="qb-wizard-tab w-33" data-tab="step-3">
                                <div class="qb-wizard-tab-icon"><i class='bx bx-bell'></i></div>
                                <div>
                                    <h6>Notification Setting</h6>
                                    <span>Step 3</span>
                                </div>
                            </div>

                        </div>
                        <div class="qb-wizard-content">
                            <div class="qb-wizard-pane is-active" id="step-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-light-purple" id="userAccountCard">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="qb-card-title-sm mb-2">User Account Information</h4>
                                                    <p class="fs-12 fw-300 lh-1 qb-text-light">Update your personal details
                                                        here.</p>
                                                </div>
                                                <div class="card-header-actions">
                                                    <button type="button"
                                                        class="qbit-btn qbit-btn-light-primary btn-sm edit-card-btn"
                                                        data-target-card="#userAccountCard">Edit</button>
                                                </div>
                                            </div>
                                            <form id="userAccountForm" method="POST" enctype="multipart/form-data" class="card-form" data-card-id="userAccountCard">
                                                @csrf
                                                <div class="card-body pt-2">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Full Name</label>
                                                                <input type="text" name="name" id="full_name"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Email Address</label>
                                                                <input type="email" name="email" id="email"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <input type="text" name="phone" id="phone"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>WhatsApp Number</label>
                                                                <input type="text" name="whatsapp" id="whatsapp"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>FaceBook</label>
                                                                <input type="text" name="facebook" id="facebook"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>LinkedIn</label>
                                                                <input type="text" name="linkedin" id="linkedin"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>GitHub</label>
                                                                <input type="text" name="github" id="github"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Portfolio Website</label>
                                                                <input type="text" name="portfolio" id="portfolio"
                                                                    class="form-control custom-input-s" disabled>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Enlisted On</label>
                                                                <input type="date" name="enlisted_on" id="enlisted_on"
                                                                    class="form-control custom-input-s" disabled readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Recovery Email Address</label>
                                                                                <input type="email"
                                                                                    name="recovery_email"
                                                                                    id="recovery_email"
                                                                                    class="form-control custom-input-s"
                                                                                    disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Recovery Phone Number</label>
                                                                                <input type="text"
                                                                                    name="recovery_phone"id="recovery_phone"
                                                                                    class="form-control custom-input-s"
                                                                                    disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div
                                                                        class="custom-card style--light color--light h-auto mt-4">
                                                                        <div class="custom-card__body p-3">
                                                                            <div
                                                                                class="d-flex align-items-center overflow-hidden w-100">
                                                                                <img class="profile-avatar" width="100px" id="profilePreview"
                                                                                    src="assets/images/image-icon.jpg"
                                                                                    alt="img"
                                                                                    class="rounded w-75px h-auto me-2">

                                                                                <div class="w-100 my-auto">
                                                                                    <div class="text-end">
                                                                                        <h4 class="qb-card-title-xs mb-1">
                                                                                            This will be displayed on your
                                                                                            profile.</h4>
                                                                                        <p
                                                                                            class="text-end fs-12 fw-300 lh-1 qb-text-light mb-2">
                                                                                            Change your profile picture from
                                                                                            here
                                                                                        </p>
                                                                                        <input type="file"
                                                                                            name="image"
                                                                                            id="avatarInput"
                                                                                            class="d-none" disabled>
                                                                                        <button type="button"
                                                                                            class="me-2 qbit-btn qbit-btn-light-success btn-sm upload-btn"
                                                                                            disabled>
                                                                                            <i
                                                                                                class="bx bx-upload me-1"></i>
                                                                                            Upload
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            class="qbit-btn qbit-btn-light-danger btn-sm reset-btn"
                                                                                            disabled>
                                                                                            Reset
                                                                                        </button>
                                                                                    </div>
                                                                                    <p
                                                                                        class="text-end m-0 fs-10 fw-300 lh-1 qb-text-danger pt-2">
                                                                                        Allowed JPG, GIF or PNG. Max size of
                                                                                        800K
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer text-end d-none">
                                                    <button type="button"
                                                        class="qbit-btn qbit-btn-light-secondary btn-sm cancel-card-btn">Cancel</button>
                                                    <button type="submit"
                                                        class="qbit-btn qbit-btn-light-success btn-sm save-card-btn">Save</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="qb-wizard-pane" id="step-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-light-danger" id="passwordSecurityCard">
                                            <div
                                                class="card-header bg-white d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="qb-card-title-sm mb-2">Password & Security</h4>
                                                    <p class="fs-12 fw-300 lh-1 qb-text-light">Update your password and
                                                        security settings.</p>
                                                </div>
                                                <div class="card-header-actions">
                                                    <button type="button"
                                                        class="qbit-btn qbit-btn-light-primary btn-sm edit-pass-card-btn"
                                                        data-target-card="#passwordSecurityCard">Edit</button>
                                                </div>
                                            </div>
                                            <form class="card-form" data-card-id="passwordSecurityCard">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Old Password <strong
                                                                        calss="text-danger">*</strong></label>
                                                                <div class="position-relative">
                                                                    <input type="password" name="old_password"
                                                                        id="old_password"
                                                                        class="form-control custom-input-s" disabled>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-light border-0 position-absolute top-50 end-0 translate-middle-y me-2"
                                                                        onclick="togglePassword('old_password', this)"
                                                                        disabled>
                                                                        <i class="bx bx-show"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>New Password <strong
                                                                        calss="text-danger">*</strong></label>
                                                                <div class="position-relative">
                                                                    <input type="password" name="new_password"
                                                                        id="new_password"
                                                                        class="form-control custom-input-s" disabled>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-light border-0 position-absolute top-50 end-0 translate-middle-y me-2"
                                                                        onclick="togglePassword('new_password', this)"
                                                                        disabled>
                                                                        <i class="bx bx-show"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Confirm Password<strong
                                                                        calss="text-danger">*</strong></label>
                                                                <div class="position-relative">
                                                                    <input type="password" name="confirm_password"
                                                                        id="confirm_password"
                                                                        class="form-control custom-input-s" disabled>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-light border-0 position-absolute top-50 end-0 translate-middle-y me-2"
                                                                        onclick="togglePassword('confirm_password', this)"
                                                                        disabled>
                                                                        <i class="bx bx-show"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-end d-none">
                                                    <button type="button"
                                                        class="qbit-btn qbit-btn-light-secondary btn-sm cancel-pass-card-btn">Cancel</button>
                                                    <button type="button"
                                                        class="qbit-btn qbit-btn-light-success btn-sm save-pass-card-btn">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-light-info mt-3" id="loginHistoryCard">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="qb-card-title-sm mb-0">Login History</h4>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-sm mb-0" id="loginHistoryTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Date & Time</th>
                                                                <th>Activity</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-3 card-light-success h-auto card" id="twoFactorAuthCard">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="fs-20 fw-500 qb-text-primary lh-1">Two-factor Authentication
                                                    </p>
                                                    <p class="fs-12 fw-300 lh-1 qb-text-light mb-0">Add an extra layer of
                                                        security to your account</p>
                                                </div>
                                                <div class="card-header-actions">
                                                    <button type="button"
                                                        class="qbit-btn qbit-btn-light-primary btn-sm edit-card-btn"
                                                        data-target-card="#twoFactorAuthCard">Edit</button>
                                                </div>
                                            </div>
                                            <form class="card-form" data-card-id="twoFactorAuthCard">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                                                <div class="d-flex align-items-center">
                                                                    <i
                                                                        class="bx bx-mobile-alt fs-24 qb-text-success me-3"></i>
                                                                    <div>
                                                                        <h6 class="mb-1">SMS Authentication</h6>
                                                                        <small class="qb-text-light" id="sms_auth_phone">+880184****502</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" id="sms_auth" type="checkbox" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="bx bx-envelope fs-24 qb-text-info me-3"></i>
                                                                    <div>
                                                                        <h6 class="mb-1">Email Authentication</h6>
                                                                        <small
                                                                            class="qb-text-light" id="email_auth_email">c***@qbit-tech.com</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" id="email_auth" type="checkbox" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <button type="button"
                                                            class="qbit-btn qbit-btn-light-success btn-sm me-2">
                                                            <i class="bx bx-shield-quarter me-1"></i>Generate Backup Codes
                                                        </button>
                                                        <button type="button"
                                                            class="qbit-btn qbit-btn-light-danger btn-sm">
                                                            <i class="bx bx-x me-1"></i>Disable 2FA
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-end d-none">
                                                    <button type="button"
                                                        class="qbit-btn qbit-btn-light-secondary btn-sm cancel-card-btn">Cancel</button>
                                                    <button type="submit"
                                                        class="qbit-btn qbit-btn-light-success btn-sm save-card-btn">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="qb-wizard-pane" id="step-3">
                                <div class="card card-light-purple" id="notificationSettingCard">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="qb-card-title-sm mb-2">Notification Setting</h4>
                                            <p class="fs-12 fw-300 lh-1 qb-text-light">Configure how and when you receive
                                                notifications</p>
                                        </div>
                                        <div class="card-header-actions">
                                            <button type="button"
                                                class="qbit-btn qbit-btn-light-primary btn-sm edit-card-btn"
                                                data-target-card="#notificationSettingCard">Edit</button>
                                        </div>
                                    </div>
                                    <form class="card-form" data-card-id="notificationSettingCard">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 d-flex flex-column gap-3">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-envelope fs-20 me-2"></i>Email Notifications
                                                        </div>
                                                        <div class="form-check form-switch m-0"><input name="email_notifications" id="email_notifications" 
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-bell fs-20 me-2"></i>Push Notifications</div>
                                                        <div class="form-check form-switch m-0"><input name="push_notifications" id="push_notifications"
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-calendar fs-20 me-2"></i>Meeting Reminders
                                                        </div>
                                                        <div class="form-check form-switch m-0"><input name="meeting_reminders" id="meeting_reminders"
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-task fs-20 me-2"></i>Task Deadlines</div>
                                                        <div class="form-check form-switch m-0"><input name="task_deadlines" id="task_deadlines" 
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex flex-column gap-3">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-dollar-circle fs-20 me-2"></i>Financial
                                                            Updates</div>
                                                        <div class="form-check form-switch m-0"><input name="financial_updates" id="financial_updates"
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-user fs-20 me-2"></i>Team Activity</div>
                                                        <div class="form-check form-switch m-0"><input name="team_activity" id="team_activity" 
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-cog fs-20 me-2"></i>System Updates</div>
                                                        <div class="form-check form-switch m-0"><input name="system_updates" id="system_updates"
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-2 border rounded">
                                                        <div class="d-flex align-items-center"><i
                                                                class="bx bx-file fs-20 me-2"></i>Document Expiry Alerts
                                                        </div> 
                                                        <div class="form-check form-switch m-0"><input name="document_expiry_alerts" id="document_expiry_alerts"
                                                                class="form-check-input" type="checkbox" disabled></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end d-none">
                                            <button type="button"
                                                class="qbit-btn qbit-btn-light-secondary btn-sm cancel-card-btn">Cancel</button>
                                            <button type="submit"
                                                class="qbit-btn qbit-btn-light-success btn-sm save-card-btn">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card card-light-info mb-0" id="notificationPreferencesCard">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="qb-card-title-sm mb-2">Notification Preferences</h4>
                                            <p class="fs-12 fw-300 lh-1 qb-text-light">Configure how and when you receive
                                                notifications</p>
                                        </div>
                                        <div class="card-header-actions">
                                            <button type="button"
                                                class="qbit-btn qbit-btn-light-primary btn-sm edit-card-btn"
                                                data-target-card="#notificationPreferencesCard">Edit</button>
                                        </div>
                                    </div>
                                    <form id="notificationPreferencesForm" class="card-form" data-card-id="notificationPreferencesCard">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Notification Frequency</label>
                                                        <select id="notification_frequency" class="form-select custom-input-s" disabled>
                                                            <option value="instant">Instant</option>
                                                            <option value="hourly_digest">Hourly Digest</option>
                                                            <option value="daily_digest">Daily Digest</option>
                                                            <option value="weekly_summary">Weekly Summary</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Quiet Hours</label>
                                                        <select id="quiet_hours" class="form-select custom-input-s" disabled>
                                                            <option value="10 PM - 7 AM">10 PM - 7 AM</option>
                                                            <option value="11 PM - 8 AM">11 PM - 8 AM</option>
                                                            <option value="9 PM - 6 AM">9 PM - 6 AM</option>
                                                            <option value="none">None</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Notification Channels</label>
                                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                                            <div class="form-check form-check-inline"><input
                                                                    class="form-check-input" type="checkbox"
                                                                    id="channel_email" value="email" checked disabled><label
                                                                    class="form-check-label"
                                                                    for="channel_email">Email</label></div>
                                                            <div class="form-check form-check-inline"><input
                                                                    class="form-check-input" type="checkbox"
                                                                    id="channel_sms" value="sms" checked disabled><label
                                                                    class="form-check-label" for="channel_sms">SMS</label>
                                                            </div>
                                                            <div class="form-check form-check-inline"><input
                                                                    class="form-check-input" type="checkbox"
                                                                    id="channel_app" value="app" checked disabled><label
                                                                    class="form-check-label" for="channel_app">App
                                                                    Notifications</label></div>
                                                            <div class="form-check form-check-inline"><input
                                                                    class="form-check-input" type="checkbox"
                                                                    id="channel_slack" value="slack" disabled><label class="form-check-label"
                                                                    for="channel_slack">Slack</label></div>
                                                            <div class="form-check form-check-inline"><input
                                                                    class="form-check-input" type="checkbox"
                                                                    id="channel_teams" value="teams" disabled><label class="form-check-label"
                                                                    for="channel_teams">Microsoft Teams</label></div>
                                                            <div class="form-check form-check-inline"><input
                                                                    class="form-check-input" type="checkbox"
                                                                    id="channel_whatsapp" value="whatsapp" disabled><label class="form-check-label"
                                                                    for="channel_whatsapp">WhatsApp</label></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Priority Levels</label>
                                                        <select id="priority_level" class="form-select custom-input-s" disabled>
                                                            <option value="all">All Notifications</option>
                                                            <option value="high_priority">High Priority Only</option>
                                                            <option value="critical">Critical Only</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Notification Sound</label>
                                                        <select id="notification_sound" class="form-select custom-input-s" disabled>
                                                            <option value="default">Default</option>
                                                            <option value="minimal">Minimal</option>
                                                            <option value="none">None</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end d-none">
                                            <button type="button"
                                                class="qbit-btn qbit-btn-light-secondary btn-sm cancel-card-btn">Cancel</button>
                                            <button type="submit"
                                                class="qbit-btn qbit-btn-light-success btn-sm save-card-btn">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    @push('scripts')
        {{-- ajaxSetup  --}}
        <script>
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
        </script>
        {{-- tab switch  --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Wizard tab switching logic
                document.querySelectorAll('.qb-wizard-tab').forEach(tab => {
                    tab.addEventListener('click', function() {
                        const targetPaneId = this.dataset.tab;
                        document.querySelectorAll('.qb-wizard-tab').forEach(t => t.classList.remove(
                            'is-active'));
                        this.classList.add('is-active');
                        document.querySelectorAll('.qb-wizard-pane').forEach(p => p.classList.remove(
                            'is-active'));
                        document.getElementById(targetPaneId).classList.add('is-active');
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "/admin/user-profile/data", // adjust route
                    type: "GET",
                    success: function(data) {
                        console.log(data);
                        // ✅ Update Form

                        $(".detail-full-name").text(data.full_name);
                        $("#detail-role").text(data.designation);
                        $("#detail-department").text(data.department);
                        $("#full_name").val(data.full_name);
                        $("#email").val(data.email);
                        $("#phone").val(data.phone);
                        $("#whatsapp").val(data.whatsapp);
                        $("#username").val(data.username);
                        $("#recovery_email").val(data.recovery_email);
                        $("#recovery_phone").val(data.recovery_phone);
                        $("#enlisted_on").val(data.enlisted_on);
                        $(".profile-avatar").attr("src", `/storage/${data.image}`);

                        // ✅ Update Collapsed View
                        // $("#detail-full-name").text(data.full_name);
                        $("#detail-email").text(data.email).attr("href", "mailto:" + data.email);
                        $("#detail-phone").html('<i class="bx bx-phone-outgoing bx-tada me-1"></i>' + data
                            .phone).attr("href", "tel:" + data.phone);
                        $("#detail-whatsapp").html('<i class="bx bxl-whatsapp me-1"></i>' + data.whatsapp)
                            .attr("href", "https://wa.me/" + data.whatsapp);
                        $("#detail-username").text(data.username);
                        $("#detail-recovery-email").text(data.recovery_email).attr("href", "mailto:" + data
                            .recovery_email);
                        $("#detail-recovery-phone").text(data.recovery_phone).attr("href", "tel:" + data
                            .recovery_phone);
                        $("#detail-facebook").text("facebook.com").attr("href", data.facebook);
                        $("#detail-linkedin").text("linkedin.com").attr("href", data.linkedin);
                        $("#detail-github").text("github.com").attr("href", data.github);
                        $("#detail-portfolio").text("portfolio").attr("href", data.portfolio);

                        $("#facebook").val(data.facebook);
                        $("#linkedin").val(data.linkedin);
                        $("#github").val(data.github);
                        $("#portfolio").val(data.portfolio);
                                                
                        // Assuming data.phone = "01840123502"
                        let phone = data.phone;
                        if (!phone.startsWith("+880")) {
                            phone = "+880" + phone.slice(1); 
                        }
                        let maskedPhone = phone.slice(0, 6) + "****" + phone.slice(-3);
                        $("#sms_auth_phone").text(maskedPhone);

                        let email = data.email; 
                        let [username, domain] = email.split("@");
                        let maskedUsername = username[0] + "***";
                        let maskedEmail = maskedUsername + "@" + domain;
                        $("#email_auth_email").text(maskedEmail);

                    }
                });

                // // Edit
                // $(".edit-card-btn").on("click", function() {
                //     $("#userAccountForm input, #userAccountForm button").prop("disabled", false);
                //     $("#userAccountForm .card-footer").removeClass("d-none");
                //     $(this).addClass("d-none");
                // });

                // // Cancel
                // $(".cancel-card-btn").on("click", function() {
                //     $("#userAccountForm input, #userAccountForm button").prop("disabled", true);
                //     $("#userAccountForm .card-footer").addClass("d-none");
                //     $(".edit-card-btn").removeClass("d-none");
                // });

                // Edit button
                $(".edit-card-btn").on("click", function() {
                    const targetCard = $(this).data("target-card"); // e.g. #userAccountCard
                    const $form = $(targetCard).find("form");

                    // Enable inputs and buttons in the target form
                    $form.find("input, select, button").prop("disabled", false);
                    $form.find(".card-footer").removeClass("d-none");

                    // Hide this edit button
                    $(this).addClass("d-none");
                });

                // Cancel button
                $(".cancel-card-btn").on("click", function() {
                    const $form = $(this).closest("form");
                    const cardId = $form.data("card-id");
                    const $card = $(`#${cardId}`);

                    // Disable inputs and buttons
                    $form.find("input, select, button").prop("disabled", true);
                    $form.find(".card-footer").addClass("d-none");

                    // Show the edit button for this card
                    $card.find(".edit-card-btn").removeClass("d-none");
                });

                // Store original image src
                const originalSrc = "/assets/images/image-icon.jpg";

                // Upload button → trigger file input
                $(".upload-btn").on("click", function() {
                    $("#avatarInput").click();
                });

                // File input change → preview
                $("#avatarInput").on("change", function() {
                    const file = this.files[0];
                    if(file){
                        const reader = new FileReader();
                        reader.onload = function(e){
                            $("#profilePreview").attr("src", e.target.result);
                        }
                        reader.readAsDataURL(file);
                    } else {
                        // If file input cleared
                        $("#profilePreview").attr("src", originalSrc);
                    }
                });

                $(".reset-btn").on("click", function() {
                    const $fileInput = $("#avatarInput");

                    // Clear input cache-proof
                    $fileInput.val('');
                    $fileInput.prop('value', ''); 

                    // Restore original image
                    $("#profilePreview").attr("src", originalSrc);
                });

                // Submit form
                $("#userAccountForm").on("submit", function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    $.ajax({
                        url: "/admin/users/account/update",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            console.log(formData);
                            Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated',
                            text: 'Your account information has been saved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                            $("#userAccountForm input, #userAccountForm button").prop("disabled",
                                true);
                            $("#userAccountForm .card-footer").addClass("d-none");
                            $(".edit-card-btn").removeClass("d-none");
                        }
                    });
                });
            });
        </script>

        <!-- Notification Settings -->
        <script>
            $("#notificationSettingCard .save-card-btn").on("click", function(e) {
                e.preventDefault();

                const $form = $(this).closest("form");

                const settings = {};
                $form.find("input[type=checkbox]").each(function () {
                    settings[$(this).attr("name")] = $(this).is(":checked") ? true : false;
                });

                $.ajax({
                    url: "/admin/notification-settings/save",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ...settings
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.success,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Disable form after saving
                        $form.find("input, select, button").prop("disabled", true);
                        $form.find(".card-footer").addClass("d-none");
                        $form.closest(".card").find(".edit-card-btn").removeClass("d-none");
                    }
                });
            });

            // Load settings using IDs
            $.ajax({
                url: '/admin/notification-settings/get',
                type: 'GET',
                success: function(data) {
                    $("#notificationSettingCard input[type=checkbox]").prop("checked", false);

                    if (data.settings) {
                        for (const [key, value] of Object.entries(data.settings)) {
                            const $checkbox = $(`#${key}`); 
                            if ($checkbox.length) {
                                $checkbox.prop("checked", value);
                            }
                        }
                    }
                }
            });



        </script>

        {{-- two factor authentication  --}}
        <script>
            $('#twoFactorAuthCard .save-card-btn').on('click', function(e) {
                e.preventDefault();

                let card = $(this).closest('.card-form'); // get the card form

                let smsAuth = $('#sms_auth').is(':checked') ? 1 : 0;
                let emailAuth = $('#email_auth').is(':checked') ? 1 : 0;

                $.ajax({
                    url: '/admin/two-factor-auth/save', 
                    type: 'POST',
                    data: {
                        sms_auth: smsAuth,
                        email_auth: emailAuth,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        card.find('.save-card-btn').prop('disabled', true);
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                        } else {
                            alert('Failed to update settings.');
                        }
                    },
                    error: function(xhr) {
                        alert('Something went wrong! Check console for details.');
                        console.log(xhr.responseText);
                    },
                    complete: function() {
                        card.find('.save-card-btn').prop('disabled', false);
                    }
                });
            });
        </script>
        
        {{-- Notification Preferences  --}}
        <script>
            $(document).on('submit', '#notificationPreferencesForm', function (e) {
                e.preventDefault();

                let formData = {
                    notification_frequency: $('#notification_frequency').val(),
                    quiet_hours: $('#quiet_hours').val(),
                    notification_channels: [],
                    priority_level: $('#priority_level').val(),
                    notification_sound: $('#notification_sound').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                // collect checked channels
                if ($('#channel_email').is(':checked')) formData.notification_channels.push('email');
                if ($('#channel_sms').is(':checked')) formData.notification_channels.push('sms');
                if ($('#channel_app').is(':checked')) formData.notification_channels.push('app');
                if ($('#channel_slack').is(':checked')) formData.notification_channels.push('slack');
                if ($('#channel_teams').is(':checked')) formData.notification_channels.push('teams');
                if ($('#channel_whatsapp').is(':checked')) formData.notification_channels.push('whatsapp');

                $.ajax({
                    url: "{{ route('admin.notification.preferences.save') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                        } else {
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        }
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON.message, 'error');
                    }
                });
            });


            $.ajax({
                url: "{{ route('admin.notification.preferences.get') }}",
                type: "GET",
                success: function (response) {
                    if (response.success && response.data) {
                        let pref = response.data;

                        // Set dropdown values
                        $('#notification_frequency').val(pref.notification_frequency);
                        $('#quiet_hours').val(pref.quiet_hours);
                        $('#priority_level').val(pref.priority_level);
                        $('#notification_sound').val(pref.notification_sound);

                        // Clear all checkboxes first
                        $('#channel_email, #channel_sms, #channel_app, #channel_slack, #channel_teams, #channel_whatsapp').prop('checked', false);

                        // Set checked checkboxes
                        if (pref.notification_channels && Array.isArray(pref.notification_channels)) {
                            pref.notification_channels.forEach(function (channel) {
                                if (channel === 'email') $('#channel_email').prop('checked', true);
                                if (channel === 'sms') $('#channel_sms').prop('checked', true);
                                if (channel === 'app') $('#channel_app').prop('checked', true);
                                if (channel === 'slack') $('#channel_slack').prop('checked', true);
                                if (channel === 'teams') $('#channel_teams').prop('checked', true);
                                if (channel === 'whatsapp') $('#channel_whatsapp').prop('checked', true);
                            });
                        }
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseJSON);
                }
            });

        </script>

        {{-- for password reset --}}.
        <script>
            function togglePassword(id, btn) {
                const input = document.getElementById(id);
                const icon = btn.querySelector('i');
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace('bx-show', 'bx-hide');
                } else {
                    input.type = "password";
                    icon.classList.replace('bx-hide', 'bx-show');
                }
            }
            document.querySelectorAll('.edit-pass-card-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const card = document.querySelector(this.dataset.targetCard);
                    card.querySelectorAll('input, .position-relative button').forEach(el => el.disabled =
                        false);
                    card.querySelector('.card-footer').classList.remove('d-none');
                });
            });

            document.querySelectorAll('.cancel-pass-card-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    form.querySelectorAll('input, .position-relative button').forEach(el => el.disabled = true);
                    form.querySelector('.card-footer').classList.add('d-none');
                    form.reset();
                });
            });
            $(document).on('click', '.save-pass-card-btn', function() {
                const form = $(this).closest('form');
                const oldPass = form.find('[name="old_password"]').val().trim();
                const newPass = form.find('[name="new_password"]').val().trim();
                const confirmPass = form.find('[name="confirm_password"]').val().trim();

                if (!oldPass || !newPass || !confirmPass) {
                    Swal.fire('Missing fields', 'All password fields are required', 'warning');
                    return;
                }

                if (newPass !== confirmPass) {
                    Swal.fire('Mismatch', 'New password and confirmation do not match', 'error');
                    return;
                }

                $.ajax({
                    url: '/admin/user-profile/change-password',
                    method: 'POST',
                    data: {
                        old_password: oldPass,
                        new_password: newPass,
                        new_password_confirmation: confirmPass,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire('Success', 'Password updated successfully', 'success');
                            form.find('.cancel-card-btn').trigger('click');
                        } else {
                            Swal.fire('Error', data.message || 'Password update failed', 'error');
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Server error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });


            function loadActivityLogs() {
                $.ajax({
                    url: '/admin/user-profile/activity-logs',
                    method: 'GET',
                    success: function (data) {
                        const tbody = $('#loginHistoryTable tbody');
                        tbody.empty();

                        if (data.length === 0) {
                            tbody.append('<tr><td colspan="3" class="text-center">No activity found</td></tr>');
                            return;
                        }

                        data.forEach(log => {
                            let statusClass = log.status === 'success' ? 'qbit-btn-light-success' :
                                            log.status === 'failed' ? 'qbit-btn-light-danger' :
                                            'qbit-btn-light-secondary';

                            tbody.append(`
                                <tr>
                                    <td>${log.datetime}</td>
                                    <td>${log.activity}</td>
                                    <td><span class="qbit-btn ${statusClass} btn-sm">${log.status}</span></td>
                                </tr>
                            `);
                        });
                    },
                    error: function () {
                        console.error('Could not fetch activity logs');
                    }
                });
            }

            // Call on page load
            $(document).ready(function () {
                loadActivityLogs();
            });

        </script>
    @endpush

@endsection

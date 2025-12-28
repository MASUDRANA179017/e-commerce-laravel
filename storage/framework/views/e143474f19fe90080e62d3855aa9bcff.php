<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ecommerce | <?php echo $__env->yieldContent('title'); ?></title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <!-- Font Awesome (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- in layouts.admin (probably in your head or <?php echo $__env->yieldPushContent('styles'); ?>) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    

    <!-- Global Styles -->
    

    <!-- Published CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/apexcharts.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/sidebar-menu.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/fullcalendar.main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/google-icon.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/swiper-bundle.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jsvectormap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/lightpick.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/prism.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/quill.snow.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/rangeslider.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/remixicon.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/simplebar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/qbit-bms-style.css')); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/others.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css.map')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/select2-bootstrap-5-theme.min.css')); ?>">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />

<?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="boxed-size">

    <?php echo $__env->make('layouts.include.sidebar-blade', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="container-fluid">
        <div class="main-content d-flex flex-column">
            <!-- Start Header Area -->
            <header class="header-area mb-4 rounded-bottom-15" id="header-area">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="left-header-content pt-2 pb-2">
                            <ul
                                class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-sm-start">
                                <li>
                                    <button class="header-burger-menu bg-transparent p-0 border-0"
                                        id="header-burger-menu">
                                        <span class="material-symbols-outlined">menu</span>
                                    </button>
                                </li>
                                <li>
                                    <form class="src-form position-relative">
                                        <input type="text" class="form-control" placeholder="Search here.....">
                                        <button type="submit"
                                            class="src-btn position-absolute top-50 end-0 translate-middle-y bg-transparent p-0 border-0">
                                            <span class="material-symbols-outlined">search</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-8 col-sm-6">
                        <div class="right-header-content mt-2 mt-sm-0">
                            <ul
                                class="d-flex align-items-center justify-content-center justify-content-sm-end ps-0 mb-0 list-unstyled">
                                <li class="header-right-item">
                                    <div class="light-dark">
                                        <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent border-0"
                                            id="switch-toggle">
                                            <span class="dark"><i
                                                    class="material-symbols-outlined">light_mode</i></span>
                                            <span class="light"><i
                                                    class="material-symbols-outlined">dark_mode</i></span>
                                        </button>
                                    </div>
                                </li>
                                <li class="header-right-item">
                                    <button class="fullscreen-btn bg-transparent p-0 border-0" id="fullscreen-button">
                                        <i class="material-symbols-outlined text-body">bubbles</i>
                                    </button>
                                </li>
                                <li class="header-right-item">
                                    <div class="dropdown notifications noti">
                                        <button class="btn btn-secondary border-0 p-0 position-relative badge"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">notifications</span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->unreadNotifications->count() > 0): ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                                    <?php echo e(auth()->user()->unreadNotifications->count()); ?>

                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg p-0 border-0 p-0 dropdown-menu-end">
                                            <div class="d-flex justify-content-between align-items-center title">
                                                <span class="fw-semibold fs-15 text-secondary">Notifications <span
                                                        class="fw-normal text-body fs-14">(<?php echo e(auth()->check() ? auth()->user()->unreadNotifications->count() : 0); ?>)</span></span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->unreadNotifications->count() > 0): ?>
                                                    <a href="<?php echo e(route('user.notifications.read.all')); ?>" class="p-0 m-0 bg-transparent border-0 fs-14 text-primary text-decoration-none">Clear All</a>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>

                                            <div class="max-h-217" data-simplebar>
                                                <?php if(auth()->check()): ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = auth()->user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <div class="notification-menu">
                                                            <a href="<?php echo e(route('user.notifications.read', $notification->id)); ?>" class="dropdown-item">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($notification->data['image']) && $notification->data['image']): ?>
                                                                            <img src="<?php echo e($notification->data['image']); ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" alt="Product">
                                                                        <?php else: ?>
                                                                            <i class="material-symbols-outlined text-primary">notifications</i>
                                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <p class="mb-0 fw-bold"><?php echo e($notification->data['title'] ?? 'Notification'); ?></p>
                                                                        <p class="mb-0 fs-13 text-muted text-truncate" style="max-width: 200px;"><?php echo e($notification->data['message'] ?? ''); ?></p>
                                                                        <span class="fs-12 text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <div class="notification-menu p-3 text-center text-muted">
                                                            <p class="mb-0">No new notifications</p>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="header-right-item">
                                    <div class="dropdown admin-profile">
                                        <div class="d-xxl-flex align-items-center cursor dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <div class="flex-shrink-0">
                                                <img class="administrator rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                    src="<?php echo e(Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/andrew-rashel.png')); ?>"
                                                    alt="<?php echo e(Auth::user()->name); ?>">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-none d-xxl-block">
                                                        <div class="d-flex align-content-center">
                                                            <h3 class="fs-14 fw-500 "><?php echo e(Auth::user()->name); ?></h3>
                                                        </div>
                                                    </div>
                                                    <i class="material-symbols-outlined me-2" data-bs-toggle="tooltip"
                                                        data-bs-placement="left"
                                                        data-bs-title="Click On Theme Settings">settings_account_box</i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dropdown-menu border-0 bg-white dropdown-menu-end">
                                            <div class="d-flex align-items-center info">
                                                <div class="flex-shrink-0">
                                                    <img class="rounded-circle wh-30 administrator" style="width: 40px; height: 40px; object-fit: cover;"
                                                        src="<?php echo e(Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/andrew-rashel.png')); ?>" 
                                                        alt="<?php echo e(Auth::user()->name); ?>">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h3 class="fw-medium"><?php echo e(Auth::user()->name); ?></h3>
                                                    <span class="fs-12"><?php echo e(Auth::user()->designationname->name ?? (Auth::user()->getRoleNames()->first() ?? 'User')); ?></span>
                                                </div>
                                            </div>
                                            <ul class="admin-link ps-0 mb-0 list-unstyled">
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="<?php echo e(route('admin.user-profile.index')); ?>">
                                                        <i class="material-symbols-outlined">account_circle</i>
                                                        <span class="ms-2">My Profile</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0" id="logout-form">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item admin-item-link d-flex align-items-center text-body border-0 bg-transparent w-100 text-start" style="cursor: pointer;">
                                                            <i class="material-symbols-outlined">logout</i>
                                                            <span class="ms-2">Logout</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <!-- End Header Area -->

            <div class="main-content-container overflow-hidden">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <div class="flex-grow-1"></div>

            <!-- Start Footer Area -->
            <footer class="footer-area bg-white text-center rounded-top-7">
                <p class="fs-14">© <span class="text-primary-div">GrowUp</span> is Proudly Owned by <a
                        href="https://qbittechnology.com/" target="_blank"
                        class="text-decoration-none text-primary">QBit Technology</a></p>
            </footer>
            <!-- End Footer Area -->
        </div>
    </div>

    <!-- jQuery (required for DataTables AJAX) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS (CDN) -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script src="<?php echo e(asset('assets/js/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/clipboard.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dragdrop.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/echarts.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/fullcalendar.main.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/lightpick.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/prism.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/quill.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/sidebar-menu.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom/apexcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom/echarts.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/rangeslider.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/world-merc.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom/custom.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        <?php if(Session::has('success')): ?>
            toastr.success("<?php echo e(Session::get('success')); ?>");
        <?php endif; ?>

        <?php if(Session::has('error')): ?>
            toastr.error("<?php echo e(Session::get('error')); ?>");
        <?php endif; ?>

        <?php if(Session::has('info')): ?>
            toastr.info("<?php echo e(Session::get('info')); ?>");
        <?php endif; ?>

        <?php if(Session::has('warning')): ?>
            toastr.warning("<?php echo e(Session::get('warning')); ?>");
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr.error("<?php echo e($error); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        $(document).on('click', '.menu-toggle', function (e) {
            e.preventDefault();
            $(this).next('.menu-sub').toggle();
            $(this).parent().toggleClass('open');
        });
        
        document.getElementById('header-burger-menu').addEventListener('click', function () {
            document.getElementById('sidebar-area').classList.toggle('collapsed');
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\QBit Dev-2\Downloads\projects\e-commerce-laravel\resources\views/layouts/master.blade.php ENDPATH**/ ?>
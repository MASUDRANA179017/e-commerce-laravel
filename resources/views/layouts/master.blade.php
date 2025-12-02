<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ecommerce | @yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--
    <link rel="icon" href="{{ asset('storage/' . $companyInformation->brandSetting->favicon) }}" type="image/x-icon" />
    --}}
    <!-- Font Awesome (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- in layouts.admin (probably in your head or @stack('styles')) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    

    <!-- Global Styles -->
    {{-- If you still need your vite assets --}}

    <!-- Published CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/google-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightpick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/qbit-bms-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/others.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css.map') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
<!-- <<<<<<< HEAD -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/r2met6mrh50htc9yymzlqn3o0rbrfr511tjh46e0ucvylnq5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<!-- >>>>>>> 6b94703d277c9c717752d3c6994fa2f7a4e1eeb7 -->

@stack('styles')
</head>

<body class="boxed-size">

    @include('layouts.include.sidebar-blade')

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
                                <li>
                                    <div class="dropdown notifications apps">
                                        <button class="btn btn-secondary border-0 p-0 position-relative" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">apps</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg p-0 border-0 py-4 px-3 max-h-312"
                                            data-simplebar>
                                            <div
                                                class="notification-menu d-flex flex-wrap justify-content-between gap-4">
                                                <a href="https://www.figma.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/figma.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Figma</span>
                                                </a>
                                                <a href="https://www.dribbble.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/dribbble.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Dribbble</span>
                                                </a>
                                                <a href="https://www.spotify.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/spotify.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Spotify</span>
                                                </a>
                                                <a href="https://www.github.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/github.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Github</span>
                                                </a>
                                                <a href="https://www.google.com/drive/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/gdrive.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>GDrive</span>
                                                </a>
                                                <a href="https://www.trello.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/trello.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Trello</span>
                                                </a>
                                                <a href="https://www.slak.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/slak.svg" class="wh-25" alt="united-states">
                                                    <span>Slak</span>
                                                </a>
                                                <a href="https://www.pinterest.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/pinterest.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Pinterest</span>
                                                </a>
                                                <a href="https://www.facebook.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/facebook.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Facebook</span>
                                                </a>
                                                <a href="https://www.linkedin.com/" target="_blank"
                                                    class="dropdown-item p-0 text-center">
                                                    <img src="assets/images/linkedin.svg" class="wh-25"
                                                        alt="united-states">
                                                    <span>Linkedin</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
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
                                        </button>
                                        <div class="dropdown-menu dropdown-lg p-0 border-0 p-0 dropdown-menu-end">
                                            <div class="d-flex justify-content-between align-items-center title">
                                                <span class="fw-semibold fs-15 text-secondary">Notifications <span
                                                        class="fw-normal text-body fs-14">(03)</span></span>
                                                <button class="p-0 m-0 bg-transparent border-0 fs-14 text-primary">Clear
                                                    All</button>
                                            </div>

                                            <div class="max-h-217" data-simplebar>
                                                <div class="notification-menu">
                                                    <a href="notification.html" class="dropdown-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <i
                                                                    class="material-symbols-outlined text-primary">sms</i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p>You have requested to <span
                                                                        class="fw-semibold">withdrawal</span></p>
                                                                <span class="fs-13">2 hrs ago</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="notification-menu unseen">
                                                    <a href="notification.html" class="dropdown-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <i
                                                                    class="material-symbols-outlined text-info">person</i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p>A new user added in Trezo</p>
                                                                <span class="fs-13">3 hrs ago</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="notification-menu">
                                                    <a href="notification.html" class="dropdown-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <i
                                                                    class="material-symbols-outlined text-success">mark_email_unread</i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p>You have requested to <span
                                                                        class="fw-semibold">withdrawal</span></p>
                                                                <span class="fs-13">1 day ago</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="notification-menu">
                                                    <a href="notification.html" class="dropdown-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <i
                                                                    class="material-symbols-outlined text-primary">sms</i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p>You have requested to <span
                                                                        class="fw-semibold">withdrawal</span></p>
                                                                <span class="fs-13">2 hrs ago</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="notification-menu unseen">
                                                    <a href="notification.html" class="dropdown-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <i
                                                                    class="material-symbols-outlined text-info">person</i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p>A new user added in Trezo</p>
                                                                <span class="fs-13">3 hrs ago</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="notification-menu">
                                                    <a href="notification.html" class="dropdown-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <i
                                                                    class="material-symbols-outlined text-success">mark_email_unread</i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p>You have requested to <span
                                                                        class="fw-semibold">withdrawal</span></p>
                                                                <span class="fs-13">1 day ago</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <a href="notification.html"
                                                class="dropdown-item text-center text-primary d-block view-all fw-medium rounded-bottom-3">
                                                <span>See All Notifications </span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="header-right-item">
                                    <div class="dropdown admin-profile">
                                        <div class="d-xxl-flex align-items-center cursor dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <div class="flex-shrink-0">
                                                <img class="administrator rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                    src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/user-161.png') }}"
                                                    alt="{{ Auth::user()->name }}">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-none d-xxl-block">
                                                        <div class="d-flex align-content-center">
                                                            <h3 class="fs-14 fw-500 ">{{ Auth::user()->name }}</h3>
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
                                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/administrator.jpg') }}" 
                                                        alt="{{ Auth::user()->name }}">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h3 class="fw-medium">{{ Auth::user()->name }}</h3>
                                                    <span class="fs-12">{{ Auth::user()->designationname->name ?? (Auth::user()->getRoleNames()->first() ?? 'User') }}</span>
                                                </div>
                                            </div>
                                            <ul class="admin-link ps-0 mb-0 list-unstyled">
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="{{ route('admin.user-profile.index') }}">
                                                        <i class="material-symbols-outlined">account_circle</i>
                                                        <span class="ms-2">My Profile</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="{{ route('dashboard') }}">
                                                        <i class="material-symbols-outlined">chat</i>
                                                        <span class="ms-2">Messages</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="{{ route('dashboard') }}">
                                                        <i class="material-symbols-outlined">format_list_bulleted </i>
                                                        <span class="ms-2">My Task</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="{{ route('dashboard') }}">
                                                        <i class="material-symbols-outlined">credit_card </i>
                                                        <span class="ms-2">Billing</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="admin-link ps-0 mb-0 list-unstyled">
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="{{ route('admin.users.business-setup.index') }}">
                                                        <i class="material-symbols-outlined">settings </i>
                                                        <span class="ms-2">Settings</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="{{ route('dashboard') }}">
                                                        <i class="material-symbols-outlined">support</i>
                                                        <span class="ms-2">Support</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                        href="{{ route('login') }}">
                                                        <i class="material-symbols-outlined">lock</i>
                                                        <span class="ms-2">Lock Screen</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout') }}" class="m-0" id="logout-form">
                                                        @csrf
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
                @yield('content')
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (required for DataTables AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>


    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
    {{--
    <script src="{{ asset('assets/js/data-table.js') }}"></script> --}}
    <script src="{{ asset('assets/js/dragdrop.js') }}"></script>
    <script src="{{ asset('assets/js/echarts.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/fullcalendar.main.js') }}"></script>
    <script src="{{ asset('assets/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/lightpick.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/prism.js') }}"></script>
    <script src="{{ asset('assets/js/quill.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/custom/echarts.js') }}"></script>
    <script src="{{ asset('assets/js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/world-merc.js') }}"></script>
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.menu-toggle', function (e) {
            e.preventDefault();
            $(this).next('.menu-sub').toggle();
            $(this).parent().toggleClass('open');
        });

        document.getElementById('header-burger-menu').addEventListener('click', function () {
            document.getElementById('sidebar-area').classList.toggle('collapsed');
        });
    </script>

    @stack('scripts')
    @auth


        <script>
            window.userId = {{ auth()->id() }};
        </script>
    @endauth
</body>


</html>
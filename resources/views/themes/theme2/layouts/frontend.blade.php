<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Theme 2 - @yield('title')</title>

    <!-- Theme 2 Variables -->
    @php
        $business_setup = \App\Models\Admin\Business_SetUp\BusinessSetup::first();
        // Default colors for Theme 2
        $themePrimary = $business_setup->theme_color_primary ?? '#ef4444';
        $themeSecondary = $business_setup->theme_color_secondary ?? '#991b1b';
        $themeAccent = $business_setup->theme_color_accent ?? '#b45309';
    @endphp
    <style>
        :root {
            --primary-red: {{ $themePrimary }};
            --dark-red: {{ $themeSecondary }};
            --gold-brown: {{ $themeAccent }};
            --theme-primary: {{ $themePrimary }};
            --bs-primary: {{ $themePrimary }}; /* Bootstrap Override */
        }
        .text-theme-primary { color: var(--theme-primary) !important; }
        .bg-theme-primary { background-color: var(--theme-primary) !important; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f9f9f9;
        }
        a { text-decoration: none; color: inherit; }

        /* Basic Header/Footer fixes if partials are missing styles */
        .main-header { padding: 15px 0; background: #fff; border-bottom: 1px solid #eee; }
        .nav-bar { background: var(--dark-red); color: #fff; }
        .nav-link { color: #fff !important; }

        /* Product Card Fixes */
        .product-card-theme2 {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .product-card-theme2:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Caveat:wght@400;700&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-slider.css') }}">

    <!-- Stacks for additional styles -->
    @stack('styles')
</head>
<body>
    @include('themes.theme2.frontend.partials.header')

    <main>
        @yield('content')
    </main>

    @include('themes.theme2.frontend.partials.footer')
    @include('themes.theme2.frontend.partials.quick-view-modal')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('frontend/js/swiper-slider.js') }}"></script>

    <script>
        // Toastr config
        if (typeof toastr !== 'undefined') {
            toastr.options = { closeButton: true, progressBar: true, positionClass: 'toast-top-right', timeOut: '3000' };
        }

        // Wishlist AJAX Logic (Shared)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.add-to-wishlist');
            if (!btn) return;

            e.preventDefault();
            const productId = btn.dataset.id;
            const hasInWishList = btn.dataset.hasInWishlist;
            if (!productId) return;

            const icon = btn.querySelector('i');
            if(icon) icon.className = 'fa-solid fa-spinner fa-spin';

            const actionUrl = hasInWishList === 'true' ? `/wishlist/remove/${productId}` : '/wishlist/add';
            const method = hasInWishList === 'true' ? 'DELETE' : 'POST';
            const body = hasInWishList === 'true' ? null : JSON.stringify({ product_id: productId });

            fetch(actionUrl, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: body
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (hasInWishList === 'true') {
                        btn.dataset.hasInWishlist = 'false';
                        if(icon) icon.className = 'fa-regular fa-heart text-muted';
                    } else {
                        btn.dataset.hasInWishlist = 'true';
                        if(icon) icon.className = 'fa-solid fa-heart text-danger';
                    }
                    // Update header count
                    const countEl = document.querySelector('.wishlist-count');
                    if(countEl) {
                        countEl.innerText = data.wishlistCount || (parseInt(countEl.innerText) + (hasInWishList==='true' ? -1 : 1));
                        countEl.style.display = 'inline-block';
                    }
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                if(icon) icon.className = hasInWishList === 'true' ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart text-muted';
                toastr.error('Something went wrong');
            });
        });

        // Cart quantity update (Theme 2)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.update-qty');
            if (!btn) return;

            e.preventDefault();

            const rowId = btn.dataset.rowid;
            const action = btn.dataset.action;
            if (!rowId || !action) return;

            const row = btn.closest('tr');
            const qtyEl = row ? row.querySelector('.item-quantity') : null;
            let currentQty = qtyEl ? parseInt(qtyEl.textContent) || 1 : 1;

            if (action === 'decrease' && currentQty <= 1) return;

            const newQty = action === 'increase' ? currentQty + 1 : currentQty - 1;

            fetch(`/cart/update/${encodeURIComponent(rowId)}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    window.location.reload();
                } else if (window.toastr && data && data.message) {
                    toastr.error(data.message);
                }
            })
            .catch(() => {
                if (window.toastr) {
                    toastr.error('Failed to update cart quantity');
                }
            });
        });

        // Global Toast
        @if (Session::has('success')) toastr.success("{{ Session::get('success') }}"); @endif
        @if (Session::has('error')) toastr.error("{{ Session::get('error') }}"); @endif
    </script>

    @stack('scripts')
</body>
</html>

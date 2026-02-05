<!-- Top Bar -->
<div class="top-bar text-center">
    <div class="container">
        Azeen Agro Food is a quality brand of Fiza & Co. Pvt. Ltd.
    </div>
</div>

<!-- Main Header -->
<div class="main-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4"></div> <!-- Spacer to center logo -->
            <div class="col-md-4 text-center">
                <a href="{{ url('/') }}">
                    <img src="{{ $business_setup && $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}"
                         alt="{{ $business_setup->company_name ?? config('app.name') }}"
                         height="60">
                </a>
            </div>
            <div class="col-md-4 text-end d-flex align-items-center justify-content-end gap-3">
                <a href="{{ route('login') }}" class="text-theme-primary fs-4"><i class="fas fa-user"></i></a>

                <a href="{{ route('wishlist.index') }}" class="text-theme-primary fs-4 position-relative d-inline-flex align-items-center" title="Wishlist">
                    <i class="fas fa-heart"></i>
                    @php $wishlistCount = count(session('wishlist', [])); @endphp
                    <span class="cart-count wishlist-count" style="{{ $wishlistCount > 0 ? '' : 'display: none;' }}">{{ $wishlistCount }}</span>
                </a>

                <a href="{{ route('cart.index') }}" class="text-theme-primary fs-4 position-relative d-inline-flex align-items-center" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                    @php $cartCount = array_sum(array_column(session('cart', []), 'qty')); @endphp
                    <span class="cart-count" style="{{ $cartCount > 0 ? '' : 'display: none;' }}">{{ $cartCount }}</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Bar -->
<div class="nav-bar">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark p-0">
            <div class="container-fluid p-0">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    @php
                        // Load main menu from database
                        $mainMenuModel = \App\Models\Menu::where('key', 'main')
                            ->with('children')
                            ->first();

                        // Build nested array from MenuItem relationships
                        $mainMenu = [];
                        if ($mainMenuModel && $mainMenuModel->children) {
                            $buildTree = function ($items) use (&$buildTree) {
                                return $items
                                    ->map(function ($item) use (&$buildTree) {
                                        return [
                                            'label' => $item->label,
                                            'url' => $item->url,
                                            'children' => $buildTree($item->children),
                                        ];
                                    })
                                    ->values()
                                    ->toArray();
                            };
                            $mainMenu = $buildTree($mainMenuModel->children->where('parent_id', null));
                        }

                        // Render function for Bootstrap 5
                        $renderMenu = function ($items) use (&$renderMenu) {
                            foreach ($items as $m) {
                                $hasChildren = is_array($m) && isset($m['children']) && count($m['children']) > 0;

                                if ($hasChildren) {
                                    echo '<li class="nav-item dropdown">';
                                    echo '<a class="nav-link dropdown-toggle" href="' . e($m['url']) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . e($m['label']) . '</a>';
                                    echo '<ul class="dropdown-menu">';
                                    foreach ($m['children'] as $c) {
                                        echo '<li><a class="dropdown-item" href="' . e($c['url']) . '">' . e($c['label']) . '</a></li>';
                                    }
                                    echo '</ul>';
                                    echo '</li>';
                                } else {
                                    echo '<li class="nav-item"><a class="nav-link" href="' . e($m['url']) . '">' . e($m['label']) . '</a></li>';
                                }
                            }
                        };
                    @endphp

                    <ul class="navbar-nav">
                        {!! $renderMenu($mainMenu) !!}
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-search"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<style>
    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        min-width: 18px;
        height: 18px;
        padding: 0 4px;
        border-radius: 99px;
        background: var(--primary-red, #ef4444);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        line-height: 18px;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border: 1px solid #fff;
        z-index: 10;
    }
</style>

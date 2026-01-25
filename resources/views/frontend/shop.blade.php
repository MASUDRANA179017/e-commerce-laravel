@extends('layouts.frontend')

@section('title', 'Shop - ' . config('app.name', 'E-Commerce'))

@section('content')
    <!-- Shop Banner -->
    <section class="banner-two">
        <div class="banner-two__slider swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg"
                            data-background="{{ asset('frontend/assets/images/web-banner-4.png') }}"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-lg-10 m-auto">
                                    <div class="banner-two__slider-content text-center">
                                        <span class="sub-title-main text-white">
                                            <i class="bx bxs-shopping-bags"></i> Browse Our Collection
                                        </span>
                                        <h1 class="title-animation text-white">Shop All Products</h1>
                                        <p class="text-white mt-2 mb-4 text-center">
                                            Discover amazing products at great prices. Quality you can trust, delivery you
                                            can count on.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop Section -->
    <section class="shop">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="shop__sidebar">
                        <!-- Search Widget -->
                        <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                            <div class="intro">
                                <h5>Search Here</h5>
                            </div>
                            <form action="{{ route('shop.index') }}" method="get">
                                <input type="text" name="search" id="searchProduct" placeholder="Search products..."
                                    value="{{ request('search') }}">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>

                        @php
                            $cart = session()->get('cart', []);
                            $cartPreview = collect($cart)->take(3);
                            $cartSubtotal = 0;
                            foreach ($cart as $item) {
                                $cartSubtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
                            }
                        @endphp
                        @if ($cartPreview->count() > 0)
                            <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000"
                                data-aos-delay="100">
                                <div class="intro">
                                    <h5>My Cart (Top 3)</h5>
                                </div>
                                <div class="sidebar-list">
                                    <ul>
                                        @foreach ($cartPreview as $rowId => $item)
                                            @php
                                                $img = $item['options']['image'] ?? null;
                                                $slug = $item['options']['slug'] ?? $item['id'];
                                            @endphp
                                            <li>
                                                <a href="{{ route('product.show', $slug) }}">
                                                    @if ($img)
                                                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $item['name'] }}"
                                                            style="width:32px;height:32px;object-fit:cover;border-radius:6px;margin-right:8px;">
                                                    @else
                                                        <span
                                                            style="width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;background:#f0f0f0;border-radius:6px;margin-right:8px;">
                                                            <i class="fa-solid fa-box"></i>
                                                        </span>
                                                    @endif
                                                    <span
                                                        style="flex:1">{{ \Illuminate\Support\Str::limit($item['name'], 28) }}</span>
                                                    <span class="badge bg-light text-dark">{{ $item['qty'] }} ×
                                                        ৳{{ number_format($item['price'] ?? 0, 0) }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <span class="fw-semibold">Subtotal</span>
                                        <span class="fw-semibold">৳{{ number_format($cartSubtotal, 0) }}</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="{{ route('cart.index') }}" class="btn--primary w-50"
                                            style="padding:8px 14px;">View Cart</a>
                                        <a href="{{ route('checkout.index') }}" class="btn--primary w-50"
                                            style="padding:8px 14px;">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Categories Widget -->
                        <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                            <div class="intro">
                                <h5>Categories</h5>
                            </div>
                            <div class="sidebar-list">
                                <ul>
                                    @php
                                        $categories = \App\Models\Admin\Product\ProductCategory::withCount(
                                            'products',
                                        )->get();
                                    @endphp
                                    @php
                                        // Helper function to render categories recursively
                                        function renderCategoryTree($category, $selectedSlug, $level = 0) {
                                            $isActive = request('category') == $category->slug ? 'active' : '';
                                            $hasChildren = $category->children && $category->children->count() > 0;
                                            echo '<li class="' . $isActive . ($level > 0 ? ' subcategory' : '') . '" style="padding-left: ' . (18 + $level * 18) . 'px;">';
                                            echo '<a href="' . route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) . '">';
                                            echo '<i class="fa-solid fa-angle-right"></i>' . $category->name;
                                            echo '<span class="badge bg-light text-dark float-end">' . $category->products_count . '</span>';
                                            echo '</a>';
                                            if ($hasChildren) {
                                                echo '<ul style="list-style:none; margin:0; padding:0;">';
                                                foreach ($category->children as $child) {
                                                    renderCategoryTree($child, $selectedSlug, $level + 1);
                                                }
                                                echo '</ul>';
                                            }
                                            echo '</li>';
                                        }
                                    @endphp
                                    @foreach ($categories as $category)
                                        @if (empty($category->parent_id))
                                            {!! renderCategoryTree($category, request('category')) !!}
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Price Filter Widget -->
                        <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                            <div class="intro">
                                <h5>Filter By Price</h5>
                            </div>

                            <div class="filter-wrapper">
                                <form action="{{ route('shop.index') }}" method="get" style="display: block">

                                    @foreach (request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach

                                    <div class="price-filter">
                                        <div class="price-range-container">
                                            <div class="slider-track"></div>
                                            <div class="slider-track-fill"></div>

                                            <input type="range" min="0" max="10000" value="0"
                                                id="minRange">
                                            <input type="range" min="0" max="10000" value="10000"
                                                id="maxRange">
                                        </div>

                                        <div class="price-values mt-2">
                                            <span>৳ <span id="minPrice">0</span></span>
                                            <span>৳ <span id="maxPrice">10000</span></span>
                                        </div>



                                        <button type="submit" class="btn--primary w-100 mt-3">
                                            Filter
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>


                        <!-- Brands Widget -->
                        {{-- @php
                            $brands = \App\Models\Admin\Brand\Brand::where('active', 1)->take(10)->get();
                        @endphp
                        @if ($brands->count() > 0)
                            <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000"
                                data-aos-delay="100">
                                <div class="intro">
                                    <h5>Brands</h5>
                                </div>
                                <div class="sidebar-list">
                                    <ul>
                                        @foreach ($brands as $brand)
                                            <li class="{{ request('brand') == $brand->slug ? 'active' : '' }}">
                                                <a
                                                    href="{{ route('shop.index', array_merge(request()->except('brand', 'page'), ['brand' => $brand->slug])) }}">
                                                    <i class="fa-solid fa-angle-right"></i>{{ $brand->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif --}}

                        <!-- Tags Widget -->
                        <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="100">
                            <div class="intro">
                                <h5>Quick Filters</h5>
                            </div>
                            <div class="tag-wrapper">
                                <a href="{{ route('shop.index', ['on_sale' => 1]) }}"
                                    class="{{ request('on_sale') ? 'active' : '' }}">On Sale</a>
                                <a href="{{ route('shop.index', ['featured' => 1]) }}"
                                    class="{{ request('featured') ? 'active' : '' }}">Featured</a>
                                <a href="{{ route('shop.index', ['new_arrivals' => 1]) }}"
                                    class="{{ request('new_arrivals') ? 'active' : '' }}">New Arrivals</a>
                                <a href="{{ route('shop.index') }}">All Products</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="shop__content">
                        <!-- Results Header -->
                        <div class="shop__content-intro">
                            <div class="shop-intro__left">
                                <p>Showing
                                    <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of
                                    {{ $products->total() }} Results
                                </p>
                            </div>
                            <div class="shop-intro__right">
                                <div class="shop-right-single">
                                    <p>Sort By:</p>
                                </div>
                                <div class="shop-right-single">
                                    <select name="sort" class="price-select select"
                                        onchange="window.location.href=this.value">
                                        <option
                                            value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
                                            {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest
                                        </option>
                                        <option
                                            value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}"
                                            {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High
                                        </option>
                                        <option
                                            value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}"
                                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low
                                        </option>
                                        <option
                                            value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_asc'])) }}"
                                            {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                        <option
                                            value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_desc'])) }}"
                                            {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="row">
                            @forelse($products as $product)
                                @include('frontend.partials.product-card-template', [
                                    'product' => $product,
                                    'colClass' => 'col-12 col-md-4 col-lg-4 mb-5',
                                ])
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <i class="bx bx-package" style="font-size: 80px; color: #ddd;"></i>
                                        <h4 class="mt-3">No Products Found</h4>
                                        <p class="text-muted">Try adjusting your search or filter criteria</p>
                                        <a href="{{ route('shop.index') }}" class="btn--primary mt-3">View All
                                            Products</a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if ($products->hasPages())
                            <div class="row">
                                <div class="col-12">
                                    <div class="pagination-wrapper" data-aos="fade-up" data-aos-duration="1000">
                                        <ul class="pagination main-pagination">
                                            {{-- Previous Page Link --}}
                                            @if ($products->onFirstPage())
                                                <li class="disabled"><span><i class="fa-solid fa-angles-left"></i></span>
                                                </li>
                                            @else
                                                <li><a href="{{ $products->previousPageUrl() }}"><i
                                                            class="fa-solid fa-angles-left"></i></a></li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($products->links()->elements[0] as $page => $url)
                                                @if ($page == $products->currentPage())
                                                    <li><a href="#" class="active">{{ $page }}</a></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($products->hasMorePages())
                                                <li><a href="{{ $products->nextPageUrl() }}"><i
                                                            class="fa-solid fa-angles-right"></i></a></li>
                                            @else
                                                <li class="disabled"><span><i class="fa-solid fa-angles-right"></i></span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>

    .swiper-wrapper{
        height: auto !important;
    }
    .price-range-container {
        position: relative;
        width: 100%;
        height: 40px;
    }

    .price-range-container input[type=range] {
        position: absolute;
        width: 100%;
        height: 6px;
        top: 50%;
        transform: translateY(-50%);
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        pointer-events: none;
        z-index: 2;
    }

    .price-range-container input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        height: 18px;
        width: 18px;
        border-radius: 50%;
        background: #04a50c;
        cursor: pointer;
        pointer-events: all;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .price-range-container input[type=range]::-moz-range-thumb {
        height: 18px;
        width: 18px;
        border-radius: 50%;
        background: #04a50c;
        cursor: pointer;
        pointer-events: all;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }


    .price-range-container input[type=range]:focus {
        z-index: 3;
    }

    .price-range-container input[type=range]:active::-webkit-slider-thumb {
        background: #038509;
        transform: scale(1.1);
    }

    .slider-track {
        position: absolute;
        height: 6px;
        background: #ddd;
        width: 100%;
        top: 50%;
        transform: translateY(-50%);
        border-radius: 5px;
        z-index: 1;
    }

    .slider-track-fill {
        position: absolute;
        height: 6px;
        background: #0d6efd;
        border-radius: 5px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
        pointer-events: none;
        transition: all 0.1s ease;
    }

    .price-values {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        color: #333;
    }
</style>

<style>
    /* Sidebar category and subcategory left padding */
    .shop__sidebar .sidebar-list ul li {
        padding-left: 18px;
        transition: padding 0.2s;
    }
    .shop__sidebar .sidebar-list ul li.subcategory {
        font-size: 95%;
        opacity: 0.85;
    }
    .shop__sidebar .sidebar-list ul li.subcategory > a {
        font-weight: 400;
    }
</style>

@push('scripts')
    <script>
    

        $(document).ready(function() {
            const minRange = $('#minRange');
            const maxRange = $('#maxRange');
            const minPrice = $('#minPrice');
            const maxPrice = $('#maxPrice');
            const trackFill = $('.slider-track-fill');
            const form = minRange.closest('form');

            // Create hidden inputs if they don't exist
            if (!form.find('input[name="min_price"]').length) {
                form.append('<input type="hidden" name="min_price" id="minPriceInput" value="0">');
                form.append('<input type="hidden" name="max_price" id="maxPriceInput" value="10000">');
            }

            const minPriceInput = $('#minPriceInput');
            const maxPriceInput = $('#maxPriceInput');

            // Set initial values from URL if present
            const urlParams = new URLSearchParams(window.location.search);
            const initialMin = urlParams.get('min_price') || 0;
            const initialMax = urlParams.get('max_price') || 10000;

            minRange.val(initialMin);
            maxRange.val(initialMax);

            function updateSlider() {
                let minVal = parseInt(minRange.val());
                let maxVal = parseInt(maxRange.val());

                // Prevent min crossing max
                if (minVal > maxVal - 100) {
                    minVal = maxVal - 100;
                }
                if (maxVal < minVal + 100) {
                    maxVal = minVal + 100;
                }

                minRange.val(minVal);
                maxRange.val(maxVal);

                minPrice.text(minVal);
                maxPrice.text(maxVal);

                // Update hidden inputs
                minPriceInput.val(minVal);
                maxPriceInput.val(maxVal);

                // Update track fill
                const minPercent = (minVal / 10000) * 100;
                const maxPercent = (maxVal / 10000) * 100;
                trackFill.css({
                    left: minPercent + '%',
                    width: (maxPercent - minPercent) + '%'
                });
            }

            minRange.on('input', updateSlider);
            maxRange.on('input', updateSlider);

            updateSlider(); // initial call
        });
    </script>
@endpush

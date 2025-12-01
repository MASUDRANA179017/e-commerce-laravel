@extends('layouts.frontend')

@section('title', 'Shop - GrowUp E-Commerce')

@push('styles')
<style>
    /* Shop Banner */
    .shop-banner {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }
    
    .shop-banner::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%230496ff" fill-opacity="0.1" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,138.7C672,128,768,160,864,181.3C960,203,1056,213,1152,197.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat center bottom;
        background-size: cover;
        opacity: 0.3;
    }
    
    /* Sidebar */
    .shop-sidebar-widget {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
    }
    
    .shop-sidebar-widget .intro {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 12px;
        margin-bottom: 16px;
    }
    
    .shop-sidebar-widget .intro h5 {
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        font-size: 16px;
    }
    
    .sidebar-list ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .sidebar-list ul li {
        margin-bottom: 0;
    }
    
    .sidebar-list ul li a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        color: #555;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .sidebar-list ul li a:hover,
    .sidebar-list ul li.active a {
        background: linear-gradient(135deg, rgba(4, 150, 255, 0.1) 0%, rgba(4, 150, 255, 0.05) 100%);
        color: #0496ff;
    }
    
    .sidebar-list ul li a i {
        margin-right: 10px;
        font-size: 12px;
        transition: transform 0.3s;
    }
    
    .sidebar-list ul li.active a i,
    .sidebar-list ul li a:hover i {
        transform: translateX(5px);
    }
    
    .category-name {
        display: flex;
        align-items: center;
    }
    
    .product-count {
        background: #f0f0f0;
        color: #666;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .sidebar-list ul li.active .product-count,
    .sidebar-list ul li a:hover .product-count {
        background: #0496ff;
        color: #fff;
    }
    
    /* Price Range Slider */
    .price-inputs {
        display: flex;
        gap: 10px;
    }
    
    .price-inputs input {
        border: 2px solid #f0f0f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .price-inputs input:focus {
        border-color: #0496ff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(4, 150, 255, 0.1);
    }
    
    /* Shop Header */
    .shop-header {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
    }
    
    /* Active Filters */
    .active-filters {
        background: #fff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #f0f0f0;
    }
    
    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .filter-tag:hover {
        background: linear-gradient(135deg, #0380d9 0%, #026bc4 100%);
        color: #fff;
        transform: scale(1.02);
    }
    
    .filter-tag i {
        font-size: 10px;
    }
    
    .clear-all-btn {
        background: #dc3545;
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .clear-all-btn:hover {
        background: #c82333;
        color: #fff;
    }
    
    /* Product Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    
    .empty-icon {
        width: 100px;
        height: 100px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    /* Mobile Filter Toggle */
    .filter-toggle-btn {
        display: none;
    }
    
    @media (max-width: 991px) {
        .filter-toggle-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0496ff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }
        
        .shop-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 320px;
            height: 100vh;
            background: #f8f9fa;
            z-index: 1050;
            padding: 20px;
            overflow-y: auto;
            transition: left 0.3s ease;
        }
        
        .shop-sidebar.active {
            left: 0;
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        .sidebar-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #dc3545;
            color: #fff;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
    
    /* Quick Filters */
    .quick-filters {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    
    .quick-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #fff;
        border: 2px solid #f0f0f0;
        border-radius: 25px;
        color: #555;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .quick-filter-btn:hover,
    .quick-filter-btn.active {
        border-color: #0496ff;
        background: rgba(4, 150, 255, 0.05);
        color: #0496ff;
    }
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        padding: 0;
        margin: 0;
        list-style: none;
    }
    
    .pagination .page-item {
        margin: 0;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        height: 45px;
        padding: 0 15px;
        font-size: 15px;
        font-weight: 600;
        color: #555;
        background: #fff;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .pagination .page-link:hover {
        color: #0496ff;
        background: rgba(4, 150, 255, 0.1);
        border-color: #0496ff;
        transform: translateY(-2px);
    }
    
    .pagination .page-item.active .page-link {
        color: #fff;
        background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
        border-color: transparent;
        box-shadow: 0 4px 15px rgba(4, 150, 255, 0.4);
    }
    
    .pagination .page-item.disabled .page-link {
        color: #ccc;
        background: #f8f9fa;
        border-color: #e9ecef;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 18px;
    }
    
    /* Navigation arrows styling */
    nav[aria-label="Pagination Navigation"] {
        display: flex;
        justify-content: center;
    }
    
    nav[aria-label="Pagination Navigation"] > div {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    
    nav[aria-label="Pagination Navigation"] > div > div:first-child {
        display: none;
    }
    
    nav[aria-label="Pagination Navigation"] span[aria-current="page"] span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        height: 45px;
        padding: 0 15px;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(4, 150, 255, 0.4);
    }
    
    nav[aria-label="Pagination Navigation"] a {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        height: 45px;
        padding: 0 15px;
        font-size: 15px;
        font-weight: 600;
        color: #555;
        background: #fff;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    nav[aria-label="Pagination Navigation"] a:hover {
        color: #0496ff;
        background: rgba(4, 150, 255, 0.1);
        border-color: #0496ff;
        transform: translateY(-2px);
    }
    
    nav[aria-label="Pagination Navigation"] span[aria-disabled="true"] span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        height: 45px;
        padding: 0 15px;
        font-size: 15px;
        font-weight: 600;
        color: #ccc;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        cursor: not-allowed;
    }
    
    /* Tailwind pagination wrapper fix */
    nav[aria-label="Pagination Navigation"] > div > div:last-child {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
    }
    
    nav[aria-label="Pagination Navigation"] > div > div:last-child > span,
    nav[aria-label="Pagination Navigation"] > div > div:last-child > a {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        height: 45px;
        padding: 0 12px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    /* Responsive pagination */
    @media (max-width: 576px) {
        .pagination .page-link,
        nav[aria-label="Pagination Navigation"] a,
        nav[aria-label="Pagination Navigation"] span span {
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            font-size: 13px;
            border-radius: 10px;
        }
        
        nav[aria-label="Pagination Navigation"] > div > div:last-child {
            gap: 5px;
        }
    }
</style>
@endpush

@section('content')
<!-- Banner Section -->
<section class="shop-banner">
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                    <i class="fa-solid fa-shopping-bag me-1"></i> Our Collection
                </span>
                <h1 class="text-white mb-3" style="font-size: 48px; font-weight: 800;">Shop</h1>
                <p class="text-white-50 mb-4">Discover amazing products at unbeatable prices</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Shop</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Shop Section -->
<section class="shop py-5" style="background: #f8f9fa;">
    <div class="container-fluid px-lg-5">
        <!-- Mobile Filter Toggle -->
        <div class="d-lg-none mb-4">
            <button class="filter-toggle-btn" id="filterToggle">
                <i class="fa-solid fa-filter"></i> Filters
            </button>
        </div>
        
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="shop-sidebar" id="shopSidebar">
                    <button class="sidebar-close d-lg-none" id="sidebarClose">
                        <i class="fa-solid fa-times"></i>
                    </button>
                    
                    <!-- Search Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up">
                        <div class="intro"><h5><i class="fa-solid fa-search me-2"></i>Search Products</h5></div>
                        <form action="{{ route('shop.index') }}" method="GET">
                            <div class="position-relative">
                                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}" style="border-radius: 10px; padding: 12px 45px 12px 16px; border: 2px solid #f0f0f0;">
                                <button type="submit" class="btn position-absolute end-0 top-0 h-100 px-3" style="background: transparent; border: none; color: #0496ff;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="100">
                        <div class="intro"><h5><i class="fa-solid fa-layer-group me-2"></i>Categories</h5></div>
                        <div class="sidebar-list">
                            <ul>
                                <li class="{{ !request('category') ? 'active' : '' }}">
                                    <a href="{{ route('shop.index', request()->except('category')) }}">
                                        <span class="category-name"><i class="fa-solid fa-angle-right"></i> All Categories</span>
                                        <span class="product-count">{{ $totalProducts ?? 0 }}</span>
                                    </a>
                                </li>
                                @foreach($categories ?? [] as $category)
                                @php
                                    $categorySlug = $category->slug ?? \Str::slug($category->name);
                                    $isActive = request('category') == $categorySlug || request('category') == $category->name || \Str::slug(request('category')) == $categorySlug;
                                @endphp
                                <li class="{{ $isActive ? 'active' : '' }}">
                                    <a href="{{ route('shop.index', array_merge(request()->except('category'), ['category' => $categorySlug])) }}">
                                        <span class="category-name">
                                            <i class="fa-solid fa-angle-right"></i> {{ $category->name }}
                                        </span>
                                        <span class="product-count">{{ $category->products_count ?? 0 }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Price Filter Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="200">
                        <div class="intro"><h5><i class="fa-solid fa-dollar-sign me-2"></i>Price Range</h5></div>
                        <form action="{{ route('shop.index') }}" method="GET">
                            @foreach(request()->except(['min_price', 'max_price']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="price-inputs mb-3">
                                <input type="number" name="min_price" class="form-control" placeholder="৳ Min" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="form-control" placeholder="৳ Max" value="{{ request('max_price') }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px; padding: 12px;">
                                <i class="fa-solid fa-filter me-2"></i>Apply Filter
                            </button>
                        </form>
                        @if(isset($priceRange))
                        <div class="mt-3 text-center">
                            <small class="text-muted">Price: ৳{{ number_format($priceRange->min_price ?? 0) }} - ৳{{ number_format($priceRange->max_price ?? 0) }}</small>
                        </div>
                        @endif
                    </div>

                    <!-- Brands Widget -->
                    @if(isset($brands) && count($brands) > 0)
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="300">
                        <div class="intro"><h5><i class="fa-solid fa-award me-2"></i>Brands</h5></div>
                        <div class="sidebar-list">
                            <ul>
                                @foreach($brands as $brand)
                                <li class="{{ request('brand') == ($brand->slug ?? $brand->name) ? 'active' : '' }}">
                                    <a href="{{ route('shop.index', array_merge(request()->except('brand'), ['brand' => $brand->slug ?? $brand->name])) }}">
                                        <span class="category-name">
                                            <i class="fa-solid fa-angle-right"></i> {{ $brand->name }}
                                        </span>
                                        <span class="product-count">{{ $brand->products_count ?? 0 }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Availability Filters -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="400">
                        <div class="intro"><h5><i class="fa-solid fa-check-circle me-2"></i>Availability</h5></div>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('shop.index', array_merge(request()->except('in_stock'), ['in_stock' => 1])) }}" 
                               class="quick-filter-btn {{ request('in_stock') ? 'active' : '' }}">
                                <i class="fa-solid fa-box"></i> In Stock Only
                            </a>
                            <a href="{{ route('shop.index', array_merge(request()->except('on_sale'), ['on_sale' => 1])) }}" 
                               class="quick-filter-btn {{ request('on_sale') ? 'active' : '' }}">
                                <i class="fa-solid fa-tag"></i> On Sale
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="shop-content">
                    <!-- Shop Header -->
                    <div class="shop-header d-flex flex-wrap justify-content-between align-items-center mb-4">
                        <div class="shop-header-left mb-2 mb-md-0">
                            @if(isset($products) && method_exists($products, 'total'))
                                <p class="mb-0">
                                    Showing <strong class="text-primary">{{ $products->firstItem() ?? 0 }}</strong> - 
                                    <strong class="text-primary">{{ $products->lastItem() ?? 0 }}</strong> of 
                                    <strong class="text-primary">{{ $products->total() }}</strong> products
                                </p>
                            @else
                                <p class="mb-0">Showing all products</p>
                            @endif
                        </div>
                        <div class="shop-header-right d-flex align-items-center gap-3">
                            <label class="mb-0 text-muted fw-medium">Sort:</label>
                            <select name="sort" class="form-select" id="sortProducts" style="width: auto; border-radius: 10px; border: 2px solid #f0f0f0; padding: 8px 35px 8px 15px;">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                            </select>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if(request('category') || request('search') || request('min_price') || request('max_price') || request('brand') || request('in_stock') || request('on_sale'))
                    <div class="active-filters mb-4 d-flex flex-wrap align-items-center gap-2">
                        <span class="text-muted fw-medium me-1"><i class="fa-solid fa-filter me-1"></i>Active Filters:</span>
                        @if(request('search'))
                            <a href="{{ route('shop.index', request()->except('search')) }}" class="filter-tag">
                                Search: {{ request('search') }} <i class="fa-solid fa-times"></i>
                            </a>
                        @endif
                        @if(request('category'))
                            <a href="{{ route('shop.index', request()->except('category')) }}" class="filter-tag">
                                Category: {{ request('category') }} <i class="fa-solid fa-times"></i>
                            </a>
                        @endif
                        @if(request('brand'))
                            <a href="{{ route('shop.index', request()->except('brand')) }}" class="filter-tag">
                                Brand: {{ request('brand') }} <i class="fa-solid fa-times"></i>
                            </a>
                        @endif
                        @if(request('min_price') || request('max_price'))
                            <a href="{{ route('shop.index', request()->except(['min_price', 'max_price'])) }}" class="filter-tag">
                                Price: ৳{{ request('min_price', 0) }} - ৳{{ request('max_price', '∞') }} <i class="fa-solid fa-times"></i>
                            </a>
                        @endif
                        @if(request('in_stock'))
                            <a href="{{ route('shop.index', request()->except('in_stock')) }}" class="filter-tag">
                                In Stock <i class="fa-solid fa-times"></i>
                            </a>
                        @endif
                        @if(request('on_sale'))
                            <a href="{{ route('shop.index', request()->except('on_sale')) }}" class="filter-tag">
                                On Sale <i class="fa-solid fa-times"></i>
                            </a>
                        @endif
                        <a href="{{ route('shop.index') }}" class="clear-all-btn">
                            <i class="fa-solid fa-trash-alt me-1"></i>Clear All
                        </a>
                    </div>
                    @endif

                    <!-- Products -->
                    <div class="row g-4">
                        @forelse($products ?? [] as $product)
                        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 50 }}">
                            @include('frontend.partials.product-card', ['product' => $product])
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa-solid fa-search fa-2x text-muted"></i>
                                </div>
                                <h4 class="mb-2">No Products Found</h4>
                                <p class="text-muted mb-4">We couldn't find any products matching your criteria.<br>Try adjusting your filters or search terms.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fa-solid fa-refresh me-2"></i>Clear All Filters
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if(isset($products) && method_exists($products, 'links') && $products->hasPages())
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                {{ $products->withQueryString()->links() }}
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

@push('scripts')
<script>
    // Sort Products Handler
    document.getElementById('sortProducts').addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        window.location.href = url.toString();
    });
    
    // Mobile Filter Sidebar Toggle
    const filterToggle = document.getElementById('filterToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const shopSidebar = document.getElementById('shopSidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    
    if (filterToggle) {
        filterToggle.addEventListener('click', function() {
            shopSidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    function closeSidebar() {
        shopSidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
</script>
@endpush

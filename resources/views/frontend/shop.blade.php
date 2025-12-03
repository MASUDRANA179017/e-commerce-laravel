@extends('layouts.frontend')

@section('title', 'Shop - ' . config('app.name', 'E-Commerce'))

@section('content')
<!-- Shop Banner -->
<section class="banner-two">
    <div class="banner-two__slider swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="banner-two__slider-single">
                    <div class="banner-two__slider-bg" data-background="{{ asset('frontend/assets/images/web-banner-4.png') }}"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-10 m-auto">
                                <div class="banner-two__slider-content text-center">
                                    <span class="sub-title-main text-white">
                                        <i class="bx bxs-shopping-bags"></i> Browse Our Collection
                                    </span>
                                    <h1 class="title-animation text-white">Shop All Products</h1>
                                    <p class="text-white mt-2 mb-4">
                                        Discover amazing products at great prices. Quality you can trust, delivery you can count on.
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
                    
                    <!-- Categories Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="intro">
                            <h5>Categories</h5>
                        </div>
                        <div class="sidebar-list">
                            <ul>
                                @php
                                    $categories = \App\Models\Admin\Product\ProductCategory::withCount('products')->get();
                                @endphp
                                @foreach($categories as $category)
                                    <li class="{{ request('category') == $category->slug ? 'active' : '' }}">
                                        <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) }}">
                                            <i class="fa-solid fa-angle-right"></i>{{ $category->name }}
                                            <span class="badge bg-light text-dark float-end">{{ $category->products_count }}</span>
                                        </a>
                                    </li>
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
                            <form action="{{ route('shop.index') }}" method="get">
                                @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <div class="d-flex gap-2 mb-3">
                                    <input type="number" name="min_price" class="form-control form-control-sm" 
                                           placeholder="Min" value="{{ request('min_price') }}">
                                    <input type="number" name="max_price" class="form-control form-control-sm" 
                                           placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                                <button type="submit" class="btn--primary w-100" aria-label="filter" title="filter">Filter</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Brands Widget -->
                    @php
                        $brands = \App\Models\Admin\Brand\Brand::where('active', 1)->take(10)->get();
                    @endphp
                    @if($brands->count() > 0)
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="intro">
                            <h5>Brands</h5>
                        </div>
                        <div class="sidebar-list">
                            <ul>
                                @foreach($brands as $brand)
                                    <li class="{{ request('brand') == $brand->slug ? 'active' : '' }}">
                                        <a href="{{ route('shop.index', array_merge(request()->except('brand', 'page'), ['brand' => $brand->slug])) }}">
                                            <i class="fa-solid fa-angle-right"></i>{{ $brand->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Tags Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
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
                            <p>Showing <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of {{ $products->total() }} Results</p>
                        </div>
                        <div class="shop-intro__right">
                            <div class="shop-right-single">
                                <p>Sort By:</p>
                            </div>
                            <div class="shop-right-single">
                                <select name="sort" class="price-select select" onchange="window.location.href=this.value">
                                    <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}" 
                                            {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                                    <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}"
                                            {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}"
                                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_asc'])) }}"
                                            {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                    <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_desc'])) }}"
                                            {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Products Grid -->
                    <div class="row">
                        @forelse($products as $product)
                            @include('frontend.partials.product-card-shop', ['product' => $product])
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bx bx-package" style="font-size: 80px; color: #ddd;"></i>
                                    <h4 class="mt-3">No Products Found</h4>
                                    <p class="text-muted">Try adjusting your search or filter criteria</p>
                                    <a href="{{ route('shop.index') }}" class="btn--primary mt-3">View All Products</a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrapper" data-aos="fade-up" data-aos-duration="1000">
                                <ul class="pagination main-pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="disabled"><span><i class="fa-solid fa-angles-left"></i></span></li>
                                    @else
                                        <li><a href="{{ $products->previousPageUrl() }}"><i class="fa-solid fa-angles-left"></i></a></li>
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
                                        <li><a href="{{ $products->nextPageUrl() }}"><i class="fa-solid fa-angles-right"></i></a></li>
                                    @else
                                        <li class="disabled"><span><i class="fa-solid fa-angles-right"></i></span></li>
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

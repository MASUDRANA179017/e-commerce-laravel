@extends('layouts.frontend')

@section('title', 'Shop - GrowUp E-Commerce')

@section('content')
<!-- Banner Section -->
<section class="common-banner">
    <div class="container">
        <div class="row">
            <div class="common-banner__content text-center">
                <span class="sub-title"><i class="fa-solid fa-shopping-bag"></i> Our Products</span>
                <h2 class="title-animation">Shop</h2>
                <nav aria-label="breadcrumb" class="mt-3">
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
<section class="shop py-5">
    <div class="container-fluid px-lg-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-12 col-lg-3 mb-4 mb-lg-0">
                <div class="shop__sidebar">
                    <!-- Search Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up">
                        <div class="intro"><h5>Search Products</h5></div>
                        <form action="{{ route('shop.index') }}" method="GET">
                            <div class="position-relative">
                                <input type="text" name="search" class="form-control" placeholder="Search Here..." value="{{ request('search') }}">
                                <button type="submit" class="btn position-absolute end-0 top-0 h-100" style="background: transparent; border: none;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="100">
                        <div class="intro"><h5>Categories</h5></div>
                        <div class="sidebar-list">
                            <ul>
                                <li class="{{ !request('category') ? 'active' : '' }}">
                                    <a href="{{ route('shop.index') }}"><i class="fa-solid fa-angle-right"></i> All Categories</a>
                                </li>
                                @foreach($categories ?? [] as $category)
                                <li class="{{ request('category') == $category->slug ? 'active' : '' }}">
                                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}">
                                        <i class="fa-solid fa-angle-right"></i> {{ $category->name }}
                                        <span class="badge bg-light text-dark float-end">{{ $category->products_count ?? 0 }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Price Filter Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="200">
                        <div class="intro"><h5>Filter By Price</h5></div>
                        <form action="{{ route('shop.index') }}" method="GET">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min ৳" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max ৳" value="{{ request('max_price') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                        </form>
                    </div>

                    <!-- Brands Widget -->
                    @if(isset($brands) && count($brands) > 0)
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="300">
                        <div class="intro"><h5>Brands</h5></div>
                        <div class="sidebar-list">
                            <ul>
                                @foreach($brands as $brand)
                                <li class="{{ request('brand') == $brand->slug ? 'active' : '' }}">
                                    <a href="{{ route('shop.index', array_merge(request()->query(), ['brand' => $brand->slug])) }}">
                                        <i class="fa-solid fa-angle-right"></i> {{ $brand->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Popular Tags Widget -->
                    <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-delay="400">
                        <div class="intro"><h5>Popular Tags</h5></div>
                        <div class="tag-wrapper d-flex flex-wrap gap-2">
                            <a href="{{ route('shop.index', ['search' => 'fashion']) }}" class="badge bg-light text-dark p-2">Fashion</a>
                            <a href="{{ route('shop.index', ['search' => 'electronics']) }}" class="badge bg-light text-dark p-2">Electronics</a>
                            <a href="{{ route('shop.index', ['search' => 'accessories']) }}" class="badge bg-light text-dark p-2">Accessories</a>
                            <a href="{{ route('shop.index', ['search' => 'new']) }}" class="badge bg-light text-dark p-2">New Arrival</a>
                            <a href="{{ route('shop.index', ['search' => 'sale']) }}" class="badge bg-light text-dark p-2">Sale</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-12 col-lg-9">
                <div class="shop__content">
                    <!-- Shop Header -->
                    <div class="shop__content-intro d-flex flex-wrap justify-content-between align-items-center mb-4 p-3 bg-white rounded shadow-sm">
                        <div class="shop-intro__left mb-2 mb-md-0">
                            @if(isset($products) && method_exists($products, 'total'))
                                <p class="mb-0">Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> - <strong>{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> Results</p>
                            @else
                                <p class="mb-0">Showing all results</p>
                            @endif
                        </div>
                        <div class="shop-intro__right d-flex align-items-center gap-3">
                            <label class="mb-0 text-muted">Sort By:</label>
                            <select name="sort" class="form-select form-select-sm" id="sortProducts" style="width: auto;">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                            </select>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if(request('category') || request('search') || request('min_price') || request('max_price'))
                    <div class="active-filters mb-4 p-3 bg-light rounded">
                        <span class="me-2 text-muted">Active Filters:</span>
                        @if(request('search'))
                            <a href="{{ route('shop.index', array_merge(request()->except('search'))) }}" class="badge bg-primary me-2">
                                Search: {{ request('search') }} <i class="fa-solid fa-times ms-1"></i>
                            </a>
                        @endif
                        @if(request('category'))
                            <a href="{{ route('shop.index', array_merge(request()->except('category'))) }}" class="badge bg-primary me-2">
                                Category: {{ request('category') }} <i class="fa-solid fa-times ms-1"></i>
                            </a>
                        @endif
                        @if(request('min_price') || request('max_price'))
                            <a href="{{ route('shop.index', array_merge(request()->except(['min_price', 'max_price']))) }}" class="badge bg-primary me-2">
                                Price: ৳{{ request('min_price', 0) }} - ৳{{ request('max_price', '∞') }} <i class="fa-solid fa-times ms-1"></i>
                            </a>
                        @endif
                        <a href="{{ route('shop.index') }}" class="badge bg-danger">Clear All</a>
                    </div>
                    @endif

                    <!-- Products -->
                    <div class="row">
                        @forelse($products ?? [] as $product)
                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            @include('frontend.partials.product-card', ['product' => $product])
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fa-solid fa-search fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">No products found</h4>
                                <p class="text-muted">Try adjusting your search or filter criteria</p>
                                <a href="{{ route('shop.index') }}" class="btn--primary mt-3">Clear Filters</a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if(isset($products) && method_exists($products, 'links'))
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-center mt-4">
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
</script>
@endpush


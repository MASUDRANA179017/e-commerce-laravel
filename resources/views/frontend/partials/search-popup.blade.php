<div class="search-popup">
    <button class="close-search" aria-label="close search box" title="close search box">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <form action="{{ route('shop.index') }}" method="GET">
        <div class="search-popup__group">
            <input type="text" name="search" placeholder="Search products..." required>
            <button type="submit" aria-label="search products" title="search products">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>
</div>


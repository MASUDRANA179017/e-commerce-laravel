<!-- Search Popup Overlay -->
<div class="search-popup-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(26, 26, 46, 0.95); z-index: 10000; opacity: 0; visibility: hidden; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
    
    <!-- Close Button -->
    <button class="close-search-popup" style="position: absolute; top: 30px; right: 30px; width: 50px; height: 50px; border: 2px solid rgba(255,255,255,0.3); background: transparent; border-radius: 50%; color: #fff; font-size: 24px; cursor: pointer; transition: all 0.3s;">
        <i class="fa-solid fa-times"></i>
    </button>
    
    <div class="search-popup-content" style="width: 100%; max-width: 700px; padding: 20px; transform: translateY(-30px); transition: all 0.4s;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-decoration-none">
                <div class="logo-icon me-2" style="width: 50px; height: 50px; background: #0496ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-cart-shopping text-white" style="font-size: 22px;"></i>
                </div>
                <div class="logo-text">
                    <h3 class="mb-0 text-white" style="font-weight: 700;">Grow<span style="color: #0496ff;">Up</span></h3>
                </div>
            </a>
        </div>
        
        <!-- Search Form -->
        <form action="{{ route('shop.index') }}" method="GET" class="search-popup-form">
            <div class="position-relative">
                <input type="text" name="search" class="form-control" placeholder="What are you looking for?" style="width: 100%; padding: 20px 60px 20px 25px; font-size: 18px; border: none; border-radius: 60px; background: #fff; box-shadow: 0 10px 40px rgba(0,0,0,0.2);" autofocus>
                <button type="submit" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border: none; background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border-radius: 50%; color: #fff; font-size: 18px; cursor: pointer; transition: all 0.3s;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
        
        <!-- Popular Searches -->
        <div class="popular-searches mt-4 text-center">
            <p style="color: rgba(255,255,255,0.6); margin-bottom: 15px; font-size: 14px;">Popular Searches:</p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('shop.index', ['search' => 'Electronics']) }}" class="popular-tag" style="padding: 8px 20px; background: rgba(255,255,255,0.1); color: #fff; border-radius: 30px; text-decoration: none; font-size: 13px; transition: all 0.3s;">
                    Electronics
                </a>
                <a href="{{ route('shop.index', ['search' => 'Fashion']) }}" class="popular-tag" style="padding: 8px 20px; background: rgba(255,255,255,0.1); color: #fff; border-radius: 30px; text-decoration: none; font-size: 13px; transition: all 0.3s;">
                    Fashion
                </a>
                <a href="{{ route('shop.index', ['search' => 'Accessories']) }}" class="popular-tag" style="padding: 8px 20px; background: rgba(255,255,255,0.1); color: #fff; border-radius: 30px; text-decoration: none; font-size: 13px; transition: all 0.3s;">
                    Accessories
                </a>
                <a href="{{ route('shop.index', ['search' => 'Mobile']) }}" class="popular-tag" style="padding: 8px 20px; background: rgba(255,255,255,0.1); color: #fff; border-radius: 30px; text-decoration: none; font-size: 13px; transition: all 0.3s;">
                    Mobile
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .search-popup-overlay.active {
        opacity: 1 !important;
        visibility: visible !important;
    }
    .search-popup-overlay.active .search-popup-content {
        transform: translateY(0) !important;
    }
    .close-search-popup:hover {
        background: rgba(255,255,255,0.1);
        transform: rotate(90deg);
    }
    .popular-tag:hover {
        background: #0496ff !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const openSearchBtn = document.querySelector('.open-search');
    const searchPopup = document.querySelector('.search-popup-overlay');
    const closeSearchBtn = document.querySelector('.close-search-popup');
    
    if (openSearchBtn) {
        openSearchBtn.addEventListener('click', function() {
            searchPopup.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(function() {
                searchPopup.querySelector('input[name="search"]').focus();
            }, 300);
        });
    }
    
    if (closeSearchBtn) {
        closeSearchBtn.addEventListener('click', function() {
            searchPopup.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchPopup.classList.contains('active')) {
            searchPopup.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Close on overlay click
    searchPopup.addEventListener('click', function(e) {
        if (e.target === searchPopup) {
            searchPopup.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>

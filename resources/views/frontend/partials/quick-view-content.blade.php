@php

    $images = $product->images && $product->images->count() > 0 ? $product->images->sortByDesc('is_cover') : collect();
    $mainImage = $images->first();
    $dummyImage = asset('frontend/assets/images/shop/KHPP-SA21 - 1.png');

    $price = $product->price ?? 0;
    $salePrice = $product->sale_price ?? null;
    $isOnSale = $salePrice && $salePrice < $price;
    $effectivePrice = $isOnSale ? $salePrice : $price;

    $stockQty = $product->stock_quantity ?? 0;
    $inStock = $stockQty > 0 || ($product->allow_backorder ?? false);

    $category = $product->categories && $product->categories->count() > 0 ? $product->categories->first() : null;

    $variantsData =
        $product->variants && $product->variants->count() > 0
            ? $product->variants
                ->map(function ($v) use ($product) {
                    $base = $v->price;
                    if ($base === null || $base <= 0) {
                        $purchaseSell = \Illuminate\Support\Facades\DB::table('purchase_items')
                            ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                            ->where('purchase_items.variant_id', $v->id)
                            ->where('purchases.status', 'received')
                            ->orderByDesc('purchases.purchase_date')
                            ->value('purchase_items.sell_price');
                        $base = $purchaseSell ?? ($v->product->sale_price ?? $v->product->price);
                    }
                    // Get stock quantity for this variant
                    $stock = $v->stock_quantity ?? 0;
                    $inStock = $stock > 0 || ((bool) ($product->allow_backorder ?? false));

                    return [
                        'id' => $v->id,
                        'label' => $v->combination_key ?? ($v->sku ?? ''),
                        'price' => $base,
                        'stock' => $stock,
                        'inStock' => $inStock,
                        'sku' => $v->sku ?? '',
                        'pairs' => $v->options
                            ->map(function ($opt) {
                                return [
                                    'attr' => optional($opt->attribute)->name ?? 'Option',
                                    'term_id' => optional($opt->term)->id,
                                ];
                            })
                            ->toArray(),
                    ];
                })
                ->toArray()
            : [];

    // Calculate Min/Max Price for Range Display
    $purchaseMin = null;
    $purchaseMax = null;
    if (!empty($variantsData)) {
        $prices = array_column($variantsData, 'price');
        $prices = array_filter($prices, function ($p) {
            return $p > 0;
        });
        if (!empty($prices)) {
            $purchaseMin = min($prices);
            $purchaseMax = max($prices);
        }
    }
    // Fallback if no variant prices
    if (!$purchaseMin) {
        $purchaseMin = $effectivePrice;
    }
    if (!$purchaseMax) {
        $purchaseMax = $effectivePrice;
    }
@endphp

<div id="quick-view-container" class="product-details" style="padding: 0;">
    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="product-details__content">
                <div class="product-meta mt-0">
                    <h3 class="title-animation mb-1">{{ $product->title }}</h3>
                </div>
                <div class="product-price mt-0">
                    @if ($purchaseMin)
                        @if ($purchaseMax && $purchaseMax != $purchaseMin)
                            <h6>৳{{ number_format($purchaseMin, 0) }} - ৳{{ number_format($purchaseMax, 0) }}</h6>
                        @else
                            <h6>৳{{ number_format($purchaseMin, 0) }}</h6>
                        @endif
                    @else
                        @if ($isOnSale)
                            <h6>৳{{ number_format($salePrice, 0) }}</h6>
                            <h6><del>৳{{ number_format($price, 0) }}</del></h6>
                        @else
                            <h6>৳{{ number_format($price, 0) }}</h6>
                        @endif
                    @endif
                </div>

                <div class="card client-details-inner border rounded-3 mb-4">
                    <div class="card-header">
                        <h6 class="sub-title-main fs-16 mb-0 fw-600 lh-sm"><i class="bx bxs-analyse"></i>Quick Overview
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                <i class="bx bx-hash me-1"></i>
                                SKU
                            </span>
                            <p class="w-60 text-dark p-0 m-0">{{ $product->sku ?? 'N/A' }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-2">
                            <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                <i class="bx bx-category me-1"></i>
                                Category
                            </span>
                            <p class="w-60 text-dark p-0 m-0">{{ $category->name ?? 'N/A' }}</p>
                        </div>
                        @if ($product->brand)
                            <div class="d-flex align-items-center justify-content-between pt-2 ">
                                <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                    <i class="bx bx-purchase-tag me-1"></i>
                                    Brand
                                </span>
                                <p class="w-60 text-dark p-0 m-0">{{ $product->brand->name }}</p>
                            </div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between pt-2">
                            <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                <i class="bx bx-check-circle me-1"></i>
                                Availability
                            </span>
                            <p class="w-60 {{ $inStock ? 'text-success' : 'text-danger' }} p-0 m-0">
                                {{ $inStock ? 'In Stock' : 'Out of Stock' }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" id="quick-view-add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Variants Logic -->
                    @if ($product->variants && $product->variants->count() > 0)
                        <div id="qv-variant-selection-message" class="alert alert-info d-flex align-items-center mb-3"
                            style="display: none !important;">
                            <i class="bx bx-info-circle me-2"></i>
                            <span>Please select all options to see the price and add to cart</span>
                        </div>
                        @php
                            $axes = [];
                            foreach ($product->variants as $v) {
                                foreach ($v->options as $opt) {
                                    $an = $opt->attribute->name ?? 'Option';
                                    $tn = $opt->term->name ?? '';
                                    $tid = $opt->term->id ?? null;
                                    if (!isset($axes[$an])) {
                                        $axes[$an] = [];
                                    }
                                    if ($tid && !isset($axes[$an][$tid])) {
                                        $axes[$an][$tid] = $tn;
                                    }
                                }
                            }
                        @endphp

                        <div class="variant-options-container">
                            @foreach ($axes as $attrName => $terms)
                                @php
                                    $isColor =
                                        stripos($attrName, 'color') !== false || stripos($attrName, 'colour') !== false;
                                @endphp
                                <div class="variant-option-group mb-2">
                                    <label class="variant-label fw-600 fs-14 mb-2 d-block" style="color: #333;">
                                        {{ $attrName }}:
                                    </label>

                                    @if ($isColor)
                                        <div class="variant-colors-wrapper">
                                            @foreach ($terms as $tid => $tname)
                                                <div class="variant-chip-wrapper">
                                                    <button type="button" class="variant-color-chip variant-chip-btn"
                                                        style="background-color: {{ strtolower($tname) }};"
                                                        data-attr="{{ $attrName }}"
                                                        data-term-id="{{ $tid }}"
                                                        data-term-name="{{ $tname }}"
                                                        title="{{ $tname }}">
                                                        <i class="bx bx-x deselect-icon-color"
                                                            style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 1.2rem; color: white; text-shadow: 0 0 3px rgba(0,0,0,0.5);"></i>
                                                        <span class="color-label">{{ $tname }}</span>
                                                    </button>
                                                    <span class="availability-badge" style="display: none;"></span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="variant-options-grid">
                                            @foreach ($terms as $tid => $tname)
                                                <div class="variant-chip-wrapper">
                                                    <button type="button"
                                                        class="variant-option-btn variant-chip-btn action-btn-success"
                                                        data-attr="{{ $attrName }}"
                                                        data-term-id="{{ $tid }}"
                                                        data-term-name="{{ $tname }}">
                                                        <span class="btn-text">{{ $tname }}</span>
                                                        <i class="bx bx-x deselect-icon" style="display: none;"></i>
                                                    </button>
                                                    <span class="availability-badge"
                                                        style="display: none; font-size: 0.65rem; margin-left: 3px;"></span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Stock Information - Shows only when variant is selected -->
                        <div id="qv-variant-stock-info" class="alert alert-light border d-none mb-4 p-3"
                            style="background: #f8f9fa;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <strong>Stock Available:</strong>
                                    <span id="qv-stock-quantity" class="ms-2 badge bg-success"
                                        style="font-size: 0.9rem;">-</span>
                                </div>
                                <div>
                                    <strong>SKU:</strong>
                                    <span id="qv-variant-sku" class="ms-2 text-muted">-</span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="variant_id" id="qv_variant_id" value="">
                        <input type="hidden" name="variant" id="qv_variant_name" value="">
                        <input type="hidden" name="variant_price" id="qv_variant_price" value="">
                    @endif

                    <div class="mt-5 pt-0 mb-4 btn-area1 text-center d-flex align-items-center justify-content-start">
                        <div class="product-quantity cart-item-single mb-0">
                            <div class="measure">
                                <button type="button" aria-label="decrease item" class="quantity-decrease"
                                    onclick="decreaseQvQty()">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" id="qv-quantity" value="1" min="1"
                                    max="{{ $stockQty > 0 ? $stockQty : 99 }}" class="item-quantity-input"
                                    style="width: 40px; text-align: center; border: none; background: transparent;"
                                    readonly>
                                <button type="button" aria-label="add item" class="quantity-increase"
                                    onclick="increaseQvQty()">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="action-btn-success p-3 ms-2 h-40px w-40 rounded-3 border-0"
                            {{ !$inStock ? 'disabled' : '' }}>
                            <i class="bx bxs-cart fs-15 me-1"></i> Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .variant-options-container {
        margin: 1rem 0;
        padding: 1rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    }

    .variant-option-group {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .variant-option-group:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .variant-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1f2937;
        letter-spacing: 0.2px;
        text-transform: capitalize;
        display: block;
        margin-bottom: 0.5rem !important;
    }

    /* Wrapper for each chip */
    .variant-chip-wrapper {
        position: relative;
        display: inline-block;
    }

    .availability-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        padding: 0.25rem 0.5rem;
        border-radius: 50%;
        font-size: 0.7rem;
        font-weight: 700;
        z-index: 10;
    }

    .availability-badge.in-stock {
        background: #10b981;
        color: white;
    }

    .availability-badge.out-of-stock {
        background: #ef4444;
        color: white;
    }

    /* Color Chips Styling */
    .variant-colors-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(45px, 1fr));
        gap: 0.5rem;
    }

    .variant-color-chip {
        position: relative;
        width: 45px;
        height: 45px;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .variant-color-chip:hover:not(.disabled) {
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        border-color: #d1d5db;
    }

    .variant-color-chip.active {
        border-color: #059669;
        border-width: 4px;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1), 0 6px 16px rgba(5, 150, 105, 0.3);
    }

    .variant-color-chip .deselect-icon-color {
        display: none !important;
        opacity: 0;
    }

    .variant-color-chip.active .deselect-icon-color {
        display: block !important;
        opacity: 1;
    }

    .variant-color-chip.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: repeating-linear-gradient(45deg,
                transparent,
                transparent 10px,
                rgba(0, 0, 0, 0.1) 10px,
                rgba(0, 0, 0, 0.1) 20px);
    }

    .variant-color-chip .color-label {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        transition: all 0.3s ease;
        pointer-events: none;
    }

    .variant-color-chip:hover:not(.disabled) .color-label {
        opacity: 1;
        bottom: -32px;
    }

    /* Options Grid Styling */
    .variant-options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(70px, auto));
        gap: 0.5rem;
    }

    .variant-option-btn {
        padding: 0.5rem 0.75rem;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        background: white;
        color: #374151;
        font-weight: 500;
        font-size: 0.8rem;
        white-space: nowrap;
        width: auto;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 36px;
        gap: 0.25rem;
    }

    .variant-option-btn .btn-text {
        flex-shrink: 0;
    }

    .variant-option-btn .deselect-icon {
        font-size: 1rem;
        margin-left: 0.25rem;
        opacity: 0;
        display: none !important;
        transition: opacity 0.2s;
    }

    .variant-option-btn.active .deselect-icon {
        opacity: 0.8;
        display: inline-block !important;
    }

    .variant-option-btn.active .deselect-icon:hover {
        opacity: 1;
    }

    .variant-option-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(5, 150, 105, 0.1);
        transition: left 0.3s ease;
        z-index: 0;
    }

    .variant-option-btn:hover:not(.disabled) {
        border-color: #059669;
        color: #059669;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
        transform: translateY(-2px);
    }

    .variant-option-btn:hover:not(.disabled)::before {
        left: 0;
    }

    .variant-option-btn:active:not(.disabled) {
        transform: translateY(0);
    }

    .variant-option-btn.active {
        background: var(--qbit-success, #10b981) !important;
        color: white !important;
        border-color: var(--qbit-success, #10b981) !important;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .variant-option-btn.active::before {
        background: transparent;
    }

    .variant-option-btn.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #9ca3af;
    }

    .variant-option-btn.disabled::before {
        background: transparent;
    }

    .variant-option-btn.disabled:hover {
        transform: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border-color: #d1d5db;
        color: #9ca3af;
    }

    /* Stock Info Styling */
    #variant-stock-info {
        border-left: 5px solid #059669;
        background: linear-gradient(135deg, #f0fdf4 0%, #f3f4f6 100%);
        border-radius: 12px;
        padding: 1.25rem !important;
        border: 1px solid #d1fae5;
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.1);
    }

    #variant-stock-info strong {
        color: #065f46;
        font-weight: 600;
    }

    #stock-quantity {
        font-size: 1rem !important;
        padding: 0.5rem 1rem !important;
        background: #059669;
        border-radius: 8px;
        font-weight: 600;
    }

    #stock-quantity.out-of-stock {
        background: #ef4444;
    }

    #variant-sku {
        font-weight: 500;
        font-family: 'Courier New', monospace;
        background: rgba(5, 150, 105, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        color: #065f46;
    }

    /* Selection Message */
    #variant-selection-message {
        background: linear-gradient(135deg, #dbeafe 0%, #f3f4f6 100%);
        border: 1px solid #bfdbfe;
        border-left: 5px solid #3b82f6;
        border-radius: 10px;
        color: #1e40af;
    }

    #variant-selection-message i {
        color: #3b82f6;
        font-size: 1.2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .variant-options-container {
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .variant-option-group {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
        }

        .variant-colors-wrapper {
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
            gap: 0.75rem;
        }

        .variant-color-chip {
            width: 50px;
            height: 50px;
        }

        .variant-options-grid {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 0.75rem;
        }

        .variant-option-btn {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<script>
    // Quantity control functions
    window.increaseQvQty = function() {
        var input = document.getElementById('qv-quantity');
        var max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    };

    window.decreaseQvQty = function() {
        var input = document.getElementById('qv-quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    };

    // Variant initialization - run after small delay to ensure DOM is ready
    setTimeout(function() {
        console.log('=== Quick View Variant Init Started ===');

        var chips = document.querySelectorAll('#quick-view-container .variant-chip-btn');
        console.log('Chips found:', chips.length);

        if (!chips.length) {
            console.log('No chips found, exiting');
            return;
        }

        var selected = {};
        var variants = @json($variantsData);
        var container = document.getElementById('quick-view-container');
        var priceContainer = container ? container.querySelector('.product-price') : null;
        var originalPriceHtml = priceContainer ? priceContainer.innerHTML : '';

        console.log('Variants data:', variants);
        console.log('Variants with stock=0:', variants.filter(function(v) {
            return v.stock <= 0;
        }));

        function updateVariantInput() {
            var matchId = null,
                matchLabel = '',
                matchPrice = null,
                matchVariant = null;
            variants.forEach(function(v) {
                var ok = true;
                for (var a in selected) {
                    var wantTid = String(selected[a]);
                    var found = v.pairs.find(function(p) {
                        return p.attr == a && String(p.term_id) == wantTid;
                    });
                    if (!found) {
                        ok = false;
                        break;
                    }
                }
                if (ok && Object.keys(selected).length === v.pairs.length) {
                    matchId = v.id;
                    matchLabel = v.label;
                    matchPrice = v.price;
                    matchVariant = v;
                }
            });

            var vidInput = document.getElementById('qv_variant_id');
            var vnameInput = document.getElementById('qv_variant_name');
            var vpriceInput = document.getElementById('qv_variant_price');
            var messageEl = document.getElementById('qv-variant-selection-message');
            var stockEl = document.getElementById('qv-variant-stock-info');

            if (vidInput) vidInput.value = matchId || '';
            if (vnameInput) vnameInput.value = matchLabel || '';
            if (vpriceInput) vpriceInput.value = matchPrice || '';

            // Show/hide selection message
            if (messageEl) {
                if (matchId) {
                    messageEl.style.display = 'none';
                } else {
                    messageEl.style.display = 'flex';
                }
            }

            // Update displayed price
            if (matchPrice && matchPrice > 0) {
                if (priceContainer) {
                    priceContainer.innerHTML = '<h6>৳' + Number(matchPrice).toLocaleString('en-IN', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }) + '</h6>';
                }
            } else {
                if (priceContainer && originalPriceHtml) {
                    priceContainer.innerHTML = originalPriceHtml;
                }
            }

            // Update stock information
            if (stockEl && matchVariant) {
                var skuEl = document.getElementById('qv-variant-sku');
                var stockQtyEl = document.getElementById('qv-stock-quantity');
                var addToCartBtn = container ? container.querySelector('button[type="submit"]') : null;

                if (skuEl) skuEl.textContent = matchLabel || '-';

                if (stockQtyEl) {
                    if (matchVariant.inStock) {
                        stockQtyEl.textContent = '✓ ' + matchVariant.stock + ' in stock';
                        stockQtyEl.classList.remove('out-of-stock');
                        if (addToCartBtn) addToCartBtn.disabled = false;
                    } else {
                        stockQtyEl.textContent = '✕ Out of Stock';
                        stockQtyEl.classList.add('out-of-stock');
                        if (addToCartBtn) addToCartBtn.disabled = true;
                    }
                }
                stockEl.classList.remove('d-none');
            } else if (stockEl) {
                stockEl.classList.add('d-none');
            }
        }

        // Initialize - show message on load if variants exist
        var messageEl = document.getElementById('qv-variant-selection-message');
        if (messageEl && variants.length > 0) {
            messageEl.style.display = 'flex';
        }

        // Check which options are available - EXACTLY like product-details
        function updateAvailability() {
            console.log('=== updateAvailability called ===');
            console.log('Current selected:', selected);

            chips.forEach(function(chip) {
                var attr = chip.getAttribute('data-attr');
                var tid = chip.getAttribute('data-term-id');
                var termName = chip.getAttribute('data-term-name');

                // Build current selection with this option
                var testSelected = Object.assign({}, selected);
                testSelected[attr] = tid;

                // Check if any variant matches this combination
                var isAvailable = false;
                variants.forEach(function(v) {
                    // Skip variants with 0 or no stock (ignore allow_backorder for availability)
                    if (v.stock <= 0) return;
                    var matches = true;
                    for (var a in testSelected) {
                        // Use String() to ensure type-safe comparison
                        var wantTid = String(testSelected[a]);
                        var found = v.pairs.find(function(p) {
                            return p.attr == a && String(p.term_id) == wantTid;
                        });
                        if (!found) {
                            matches = false;
                            break;
                        }
                    }
                    // If all selected options match and this option is part of the variant
                    var hasThisOption = v.pairs.find(function(p) {
                        return p.attr == attr && String(p.term_id) == String(tid);
                    });
                    if (matches && hasThisOption) {
                        isAvailable = true;
                    }
                });

                // Log availability for each option
                if (!isAvailable) {
                    console.log('DISABLED:', attr, '=', termName, '(tid:', tid, ')');
                }

                // Update button state
                var wrapper = chip.closest('.variant-chip-wrapper');
                if (wrapper) {
                    var badge = wrapper.querySelector('.availability-badge');
                    if (!isAvailable) {
                        chip.classList.add('disabled');
                        chip.style.opacity = '0.4'; // Force visual feedback
                        chip.style.pointerEvents = 'none'; // Prevent clicking
                        if (badge) {
                            badge.style.display = 'inline-block';
                            badge.classList.add('out-of-stock');
                            badge.classList.remove('in-stock');
                        }
                    } else {
                        chip.classList.remove('disabled');
                        chip.style.opacity = '';
                        chip.style.pointerEvents = '';
                        if (badge) {
                            badge.classList.remove('out-of-stock');
                        }
                    }
                }
            });
        }

        // Initial availability check
        console.log('Calling initial updateAvailability...');
        updateAvailability();

        // Add click handlers - EXACTLY like product-details
        chips.forEach(function(chip) {
            chip.addEventListener('click', function(e) {
                e.preventDefault();

                // Check if clicking the deselect icon
                if (e.target.classList.contains('deselect-icon') || e.target.closest(
                        '.deselect-icon') ||
                    e.target.classList.contains('deselect-icon-color') || e.target.closest(
                        '.deselect-icon-color')) {
                    var attr = this.getAttribute('data-attr');
                    this.classList.remove('active');
                    delete selected[attr];
                    updateVariantInput();
                    updateAvailability();
                    return;
                }

                // Don't allow clicking disabled chips
                if (this.classList.contains('disabled')) {
                    return;
                }

                var attr = this.getAttribute('data-attr');
                var tid = this.getAttribute('data-term-id');

                // Find the container (variant-colors-wrapper or variant-options-grid)
                var optionGroup = this.closest('.variant-option-group');
                if (optionGroup) {
                    // Deselect others in same attribute
                    var siblings = optionGroup.querySelectorAll(
                        '.variant-chip-btn[data-attr="' +
                        attr + '"]');
                    siblings.forEach(function(s) {
                        s.classList.remove('active');
                    });

                    // Select this
                    this.classList.add('active');
                    selected[attr] = tid;

                    updateVariantInput();
                    updateAvailability();
                }
            });
        });

        // Form validation
        var addToCartForm = document.getElementById('quick-view-add-to-cart-form');
        if (addToCartForm) {
            addToCartForm.addEventListener('submit', function(e) {
                var variantId = document.getElementById('qv_variant_id');
                if (variantId && !variantId.value) {
                    e.preventDefault();
                    alert('Please select all product options before adding to cart');
                    return false;
                }
            });
        }
    }, 50); // Small delay to ensure DOM is ready
</script>

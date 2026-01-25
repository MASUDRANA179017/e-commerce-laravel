# Product Pricing System - Implementation Guide

## Overview
The Product model has been updated to support:
1. **Purchase-based pricing** - Get sell price from last purchase
2. **Variant-based pricing** - Different prices for different variants
3. **Price range display** - Show min-max prices when variants have different costs
4. **Dynamic cart calculation** - Variant-specific prices added to cart

---

## New Product Model Methods

### 1. `getPurchaseSellPriceAttribute()`
Gets the selling price from the most recent purchase record.

**Usage:**
```php
$product = Product::find(1);
echo $product->purchase_sell_price; // Returns last purchase unit_cost
```

### 2. `getBasePriceAttribute()`
Returns base price (manual price or falls back to purchase price).

**Usage:**
```php
$basePrice = $product->base_price;
```

### 3. `getPriceRangeAttribute()`
Returns price range for products with variants.

**Returns Array:**
```php
[
    'min' => 500,
    'max' => 1500,
    'min_sale' => 450
]
```

**Usage:**
```php
$range = $product->price_range;
echo $range['min']; // Minimum variant price
```

### 4. `getHasVariantPricingAttribute()`
Checks if product has variants with different prices.

**Usage:**
```php
if ($product->has_variant_pricing) {
    echo "Show price range";
}
```

### 5. `getFormattedPriceRangeAttribute()`
Returns formatted price range string.

**Usage:**
```php
echo $product->formatted_price_range; // "500.00 - 1500.00"
```

---

## New ProductVariant Model Methods

### 1. `getEffectivePriceAttribute()`
Gets variant price or falls back to product price.

**Usage:**
```php
$variant = ProductVariant::find(1);
echo $variant->effective_price;
```

### 2. `getPurchaseCostAttribute()`
Gets purchase cost for specific variant.

**Usage:**
```php
$cost = $variant->purchase_cost;
```

### 3. `getIsInStockAttribute()`
Checks if variant is in stock.

**Usage:**
```php
if ($variant->is_in_stock) {
    echo "Available";
}
```

### 4. `getVariantNameAttribute()`
Returns formatted variant name from attribute combinations.

**Usage:**
```php
echo $variant->variant_name; // "Color: Red | Size: Large"
```

---

## Frontend Implementation

### Display Product Price

**Single Product (No Variants):**
```blade
<p class="price">৳{{ number_format($product->effective_price, 2) }}</p>
```

**Product with Variants:**
```blade
@if($product->has_variant_pricing)
    <p class="price">৳{{ $product->formatted_price_range }}</p>
@else
    <p class="price">৳{{ number_format($product->effective_price, 2) }}</p>
@endif
```

### Add to Cart with Variant

**HTML:**
```html
<form id="addToCartForm">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    
    @if($product->variants->count() > 0)
        <select name="variant_id" id="variantSelect" required>
            <option value="">Select Variant</option>
            @foreach($product->variants as $variant)
                <option value="{{ $variant->id }}" data-price="{{ $variant->effective_price }}">
                    {{ $variant->variant_name }} - ৳{{ number_format($variant->effective_price, 2) }}
                </option>
            @endforeach
        </select>
    @endif
    
    <input type="number" name="quantity" value="1" min="1">
    <button type="submit">Add to Cart</button>
</form>
```

**JavaScript:**
```javascript
document.getElementById('variantSelect').addEventListener('change', function() {
    const selectedPrice = this.options[this.selectedIndex].dataset.price;
    document.querySelector('.variant-price').textContent = '৳' + parseFloat(selectedPrice).toFixed(2);
});
```

---

## Cart Calculation

The CartController already handles:
- ✅ Variant-specific pricing
- ✅ Purchase-based fallback pricing
- ✅ Proper row ID generation with variant
- ✅ Display variant details in cart

**Cart Item Structure:**
```php
[
    'id' => $product->id,
    'name' => $product->title,
    'price' => $variant->effective_price, // Variant price
    'original_price' => $product->price,
    'qty' => 1,
    'options' => [
        'variant' => 'Color: Red | Size: Large',
        'sku' => $variant->sku,
        'image' => $product->cover_image
    ]
]
```

---

## Database Requirements

Ensure `purchase_items` table has:
```sql
ALTER TABLE purchase_items ADD COLUMN sell_price DECIMAL(10,2);
```

---

## Example Usage

```php
// Get single product price
$product = Product::with('variants')->find(1);
$price = $product->effective_price;

// Get variant-aware pricing
if ($product->variants->count() > 0) {
    $priceRange = $product->price_range;
    $hasMultiplePrices = $product->has_variant_pricing;
}

// Get variant details
$variant = $product->variants->first();
$variantPrice = $variant->effective_price;
$variantName = $variant->variant_name;
```

---

## Summary of Changes

| File | Changes |
|------|---------|
| `Product.php` | Added 5 new attribute methods for pricing & variants |
| `ProductVariant.php` | Added 4 new methods for variant pricing & info |
| `PurchaseItem.php` | Added `sell_price` field support & methods |
| `CartController.php` | Already handles variant pricing (no changes needed) |

All changes are backward compatible with existing code.

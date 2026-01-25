# Auto Stock Update on Purchase - Implementation Guide

## Overview
When a purchase order status is changed to **"received"**, the system automatically updates:
- ✅ Product stock quantity
- ✅ Product variant stock quantity  
- ✅ Product/variant selling price (from purchase sell_price)

When a purchase status is changed **FROM "received"** to another status, the stock is automatically reverted.

---

## How It Works

### Observer Pattern
A **PurchaseObserver** listens for Purchase model changes and automatically:

1. **On Status Change to "received":**
   - Increments product stock by purchase item quantity
   - Increments variant stock by purchase item quantity (if variant exists)
   - Updates product/variant price from `sell_price` if available

2. **On Status Change FROM "received":**
   - Decrements product stock by purchase item quantity
   - Decrements variant stock by purchase item quantity

3. **On Purchase Deletion (if status is received):**
   - Automatically reverts all stock changes

---

## Technical Implementation

### Observer Location
`app/Observers/PurchaseObserver.php`

### Key Methods

**1. `updated(Purchase $purchase)`**
- Listens for status changes
- Calls appropriate stock update method

**2. `deleted(Purchase $purchase)`**
- Handles purchase deletion
- Reverts stock if purchase was "received"

**3. `updateStockOnReceived(Purchase $purchase)`**
- Increments stock when purchase marked as received
- Updates selling prices from purchase items

**4. `revertStockOnStatusChange(Purchase $purchase)`**
- Reverts stock when purchase status changes away from "received"

### Registration
Registered in `app/Providers/AppServiceProvider.php` boot method:
```php
Purchase::observe(PurchaseObserver::class);
```

---

## Purchase Status Flow

```
pending → ordered → received (✅ Stock Updated)
           ↓
        cancelled (Revert Stock if was received)
```

---

## Database Fields Used

**purchase_items table:**
- `quantity` - Number of items to add to stock
- `sell_price` - Selling price to set on product/variant
- `variant_id` - Optional variant ID (if product has variants)
- `product_id` - Product ID

**products table:**
- `stock_quantity` - Total product stock
- `price` - Selling price

**product_variants table:**
- `stock_quantity` - Variant-specific stock
- `price` - Variant-specific price

---

## Usage Examples

### Example 1: Create Purchase (pending)
```php
$purchase = Purchase::create([
    'vendor_id' => 1,
    'purchase_date' => now(),
    'status' => 'pending', // Stock NOT updated
]);

PurchaseItem::create([
    'purchase_id' => $purchase->id,
    'product_id' => 1,
    'quantity' => 100,
    'unit_cost' => 500,
    'sell_price' => 800, // Will be set as product price when received
]);
```

### Example 2: Mark as Received (stock updates automatically)
```php
$purchase = Purchase::find(1);
$purchase->update(['status' => 'received']); // 🔄 Observer auto-updates stock

// Result:
// - Product stock increased by 100
// - Product price set to 800
```

### Example 3: Cancel Received Purchase (stock reverts)
```php
$purchase = Purchase::find(1);
$purchase->update(['status' => 'cancelled']); // 🔄 Observer auto-reverts stock

// Result:
// - Product stock decreased by 100
// - Price remains as is
```

### Example 4: Product with Variants
```php
$purchase = Purchase::create([
    'vendor_id' => 1,
    'purchase_date' => now(),
    'status' => 'pending',
]);

PurchaseItem::create([
    'purchase_id' => $purchase->id,
    'product_id' => 1,
    'variant_id' => 5, // Variant exists
    'quantity' => 50,
    'unit_cost' => 600,
    'sell_price' => 900,
]);

$purchase->update(['status' => 'received']);
// Result:
// - Variant #5 stock increased by 50
// - Variant #5 price set to 900
// - Product #1 stock increased by 50 (parent)
```

---

## Benefits

✅ **Automatic** - No manual stock entry needed  
✅ **Consistent** - Stock always matches purchases  
✅ **Variant-aware** - Handles both products and variants  
✅ **Reversible** - Stock reverts if purchase status changes  
✅ **Price Sync** - Auto-updates selling prices from purchases  
✅ **Safe Deletion** - Stock reverted even if purchase deleted  

---

## Events Triggered

The Observer uses Laravel's Eloquent events:
- `updated` - Called when purchase record is updated
- `deleted` - Called when purchase record is deleted
- `restored` - Called when soft-deleted purchase is restored

---

## Configuration

### Disable Auto-Update (if needed)
In PurchaseObserver, comment out the observer registration:
```php
// In AppServiceProvider boot()
// Purchase::observe(PurchaseObserver::class);
```

### Custom Stock Threshold
To prevent negative stock, add validation:
```php
// In PurchaseObserver
if ($variant->stock_quantity < 0) {
    throw new Exception('Stock cannot go negative');
}
```

---

## Troubleshooting

### Stock Not Updating?
1. Check purchase status is exactly "received" (case-sensitive)
2. Verify PurchaseItem records have correct product_id and quantity
3. Ensure Observer is registered in AppServiceProvider
4. Run `php artisan cache:clear`

### Prices Not Updating?
1. Check `sell_price` is > 0 in PurchaseItem
2. For variants, ensure `variant_id` is set in PurchaseItem
3. Verify `price` column exists in products/product_variants table

### Unexpected Stock Changes?
1. Check Purchase history for previous status changes
2. Review logs for model observer events
3. Verify no duplicate purchase items

---

## Log Activity

To track stock changes, add logging to PurchaseObserver:
```php
\Illuminate\Support\Facades\Log::info('Stock updated for purchase', [
    'purchase_id' => $purchase->id,
    'old_status' => $oldStatus,
    'new_status' => $purchase->status,
]);
```

---

## Future Enhancements

- [ ] Add stock history/audit log
- [ ] Email notification when purchase received
- [ ] Webhook integration for external systems
- [ ] Batch stock updates for multiple purchases
- [ ] Stock reorder point notifications

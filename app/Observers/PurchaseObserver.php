<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductVariant;

class PurchaseObserver
{
    /**
     * Handle the Purchase "updated" event - Auto update stock when status changes to received
     */
    public function updated(Purchase $purchase): void
    {
        // Check if status changed to 'received'
        if ($purchase->wasChanged('status') && $purchase->status === 'received') {
            $this->updateStockOnReceived($purchase);
        }
        
        // Check if status changed from 'received' to something else
        if ($purchase->wasChanged('status') && $purchase->getOriginal('status') === 'received') {
            $this->revertStockOnStatusChange($purchase);
        }
    }

    /**
     * Handle the Purchase "deleted" event - Revert stock if purchase was received
     */
    public function deleted(Purchase $purchase): void
    {
        if ($purchase->status === 'received') {
            $this->revertStockOnStatusChange($purchase);
        }
    }

    /**
     * Handle the Purchase "restored" event - Restore stock if purchase was received
     */
    public function restored(Purchase $purchase): void
    {
        if ($purchase->status === 'received') {
            $this->updateStockOnReceived($purchase);
        }
    }

    /**
     * Update stock when purchase is received
     */
    private function updateStockOnReceived(Purchase $purchase): void
    {
        foreach ($purchase->items as $item) {
            // Update variant stock if applicable
            if ($item->variant_id) {
                $variant = ProductVariant::find($item->variant_id);
                if ($variant) {
                    // Increment variant stock
                    $variant->increment('stock_quantity', $item->quantity);
                    
                    // Update variant price from sell_price if available
                    if ($item->sell_price && $item->sell_price > 0) {
                        $variant->update(['price' => $item->sell_price]);
                    }
                }
            }
            
            // Always update product stock
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock_quantity', $item->quantity);
                
                // Update product price from sell_price if no variant
                if (!$item->variant_id && $item->sell_price && $item->sell_price > 0) {
                    $product->update(['price' => $item->sell_price]);
                }
            }
        }
    }

    /**
     * Revert stock when purchase status changes from received
     */
    private function revertStockOnStatusChange(Purchase $purchase): void
    {
        foreach ($purchase->items as $item) {
            // Revert variant stock if applicable
            if ($item->variant_id) {
                $variant = ProductVariant::find($item->variant_id);
                if ($variant) {
                    $variant->decrement('stock_quantity', $item->quantity);
                }
            }
            
            // Always revert product stock
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrement('stock_quantity', $item->quantity);
            }
        }
    }
}

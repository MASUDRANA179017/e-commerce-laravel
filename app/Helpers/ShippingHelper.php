<?php

namespace App\Helpers;

use App\Models\Admin\Business_SetUp\BusinessSetup;

class ShippingHelper
{
    /**
     * Calculate shipping cost based on address location (Inside/Outside Dhaka)
     */
    public static function calculateShippingCost($subtotal, $address = null, $isDhaka = null)
    {
        $settings = BusinessSetup::first();
        
        // Get shipping cost configuration
        $costDhaka = $settings->shipping_cost_dhaka ?? 60;
        $costOutside = $settings->shipping_cost_outside ?? 120;
        $freeThreshold = $settings->free_shipping_threshold ?? 5000;
        
        // Check if order qualifies for free shipping
        if ($subtotal >= $freeThreshold) {
            return 0;
        }
        
        // Determine if address is in Dhaka
        $inDhaka = $isDhaka;
        
        if ($inDhaka === null && $address) {
            $inDhaka = self::isAddressInDhaka($address);
        }
        
        // Default to checking if outside Dhaka
        if ($inDhaka === null) {
            $inDhaka = false;
        }
        
        return $inDhaka ? $costDhaka : $costOutside;
    }
    
    /**
     * Check if address is in Dhaka
     */
    public static function isAddressInDhaka($address)
    {
        if (!$address) {
            return false;
        }
        
        // Convert to string and lowercase for matching
        $addressStr = '';
        
        if (is_array($address)) {
            $addressStr = strtolower(implode(' ', array_values($address)));
        } elseif (is_object($address)) {
            $addressStr = strtolower(implode(' ', [
                $address->city ?? '',
                $address->district ?? '',
                $address->area ?? '',
                $address->thana ?? ''
            ]));
        } else {
            $addressStr = strtolower((string)$address);
        }
        
        // Check for Dhaka related keywords
        $dhakaKeywords = [
            'dhaka',
            'dhaka city',
            'gulshan',
            'banani',
            'baridhara',
            'dhanmondi',
            'mirpur',
            'uttara',
            'mohakhali',
            'badda',
            'motijheel',
            'kawran bazar',
            'panthapath',
            'shahbag',
            'farmgate',
            'kakrail',
            'sadarghat',
            'buriganga',
            'old dhaka',
            'chawkbazar',
            'lalbagh',
            'dasknondii',
            'pallabi',
            'gabtoli',
            'patenga',
            'malibagh',
        ];
        
        foreach ($dhakaKeywords as $keyword) {
            if (strpos($addressStr, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get shipping cost display text
     */
    public static function getShippingCostText($subtotal, $isDhaka, $includeFree = true)
    {
        $settings = BusinessSetup::first();
        $freeThreshold = $settings->free_shipping_threshold ?? 5000;
        
        $cost = self::calculateShippingCost($subtotal, null, $isDhaka);
        
        if ($cost == 0 && $includeFree) {
            return 'FREE';
        }
        
        return '৳' . number_format($cost, 0);
    }
}

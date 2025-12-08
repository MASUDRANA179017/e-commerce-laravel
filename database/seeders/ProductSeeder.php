<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Admin\Brand\Brand;
use App\Models\Admin\Product\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Brands
        $brandsData = [
            ['name' => 'Apple', 'logo' => 'brands/apple.png'],
            ['name' => 'Samsung', 'logo' => 'brands/samsung.png'],
            ['name' => 'Nike', 'logo' => 'brands/nike.png'],
            ['name' => 'Adidas', 'logo' => 'brands/adidas.png'],
            ['name' => 'Sony', 'logo' => 'brands/sony.png'],
            ['name' => 'Dell', 'logo' => 'brands/dell.png'],
        ];

        $brands = [];
        foreach ($brandsData as $b) {
            $brands[] = Brand::firstOrCreate(
                ['slug' => Str::slug($b['name'])],
                [
                    'name' => $b['name'],
                    'logo' => $b['logo'],
                    'country' => 'US',
                    'active' => true
                ]
            );
        }

        // 2. Fetch Categories (created by CatalogSeeder)
        $categories = ProductCategory::whereIn('slug', ['clothing', 'phone', 'laptop', 'electronicItem', 'organicFood', 'eyewear'])
            ->get()
            ->keyBy('slug');

        if ($categories->isEmpty()) {
            return;
        }

        // 3. Create Products
        $productsData = [
            // Phones
            [
                'name' => 'iPhone 15 Pro',
                'cat' => 'phone',
                'brand' => 'Apple',
                'price' => 999,
                'thumb' => 'products/iphone15.jpg'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'cat' => 'phone',
                'brand' => 'Samsung',
                'price' => 899,
                'thumb' => 'products/s24.jpg'
            ],
            // Laptops
            [
                'name' => 'MacBook Pro M3',
                'cat' => 'laptop',
                'brand' => 'Apple',
                'price' => 1299,
                'thumb' => 'products/mbp.jpg'
            ],
            [
                'name' => 'Dell XPS 15',
                'cat' => 'laptop',
                'brand' => 'Dell',
                'price' => 1199,
                'thumb' => 'products/xps15.jpg'
            ],
            // Clothing
            [
                'name' => 'Nike Air Max',
                'cat' => 'clothing',
                'brand' => 'Nike',
                'price' => 120,
                'thumb' => 'products/airmax.jpg'
            ],
            [
                'name' => 'Adidas Ultraboost',
                'cat' => 'clothing',
                'brand' => 'Adidas',
                'price' => 140,
                'thumb' => 'products/ultraboost.jpg'
            ],
            // Electronics
            [
                'name' => 'Sony WH-1000XM5',
                'cat' => 'electronicItem',
                'brand' => 'Sony',
                'price' => 349,
                'thumb' => 'products/sony-headphones.jpg'
            ],
        ];

        foreach ($productsData as $p) {
            $cat = $categories[$p['cat']] ?? $categories->first();

            $brandId = null;
            foreach ($brands as $brand) {
                if ($brand->name === $p['brand']) {
                    $brandId = $brand->id;
                    break;
                }
            }

            // Create Product
            $product = Product::create([
                'title' => $p['name'], // Changed from name to title
                'slug' => Str::slug($p['name']) . '-' . Str::random(5),
                'brand_id' => $brandId,
                // 'category_id' => $cat->id, // Removed, pivot table used

                'sku' => strtoupper(Str::random(8)),
                'price' => $p['price'],
                'sale_price' => $p['price'], // Set sale price to price initially

                'stock_quantity' => 100, // Changed from quantity to stock_quantity
                'status' => 'Active', // Capitalized Active to match migration enum

                // Fields required by migration but nullable/defaulted:
                'short_desc' => 'This is a dummy product description for ' . $p['name'],
                'featured' => (bool) rand(0, 1),
                'allow_backorder' => false,
                'variant_wise_image' => false,
            ]);

            // Attach Category
            $product->categories()->attach($cat->id, ['is_primary' => true]);

            // Create Image
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $p['thumb'],
                'is_cover' => true,
                'sort_order' => 0
            ]);
        }
    }
}

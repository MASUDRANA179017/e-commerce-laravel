<?php

namespace Database\Seeders;

use App\Models\Admin\Brand\BrandTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'cat' => 'Clothing',
                'items' => [
                    ['name' => 'Nike', 'country' => 'US'],
                    ['name' => 'Adidas', 'country' => 'DE'],
                    ['name' => 'Uniqlo', 'country' => 'JP'],
                    ["name" => "Levi's", 'country' => 'US'],
                    ['name' => 'H&M', 'country' => 'SE'],
                ],
            ],
            [
                'cat' => 'Phone',
                'items' => [
                    ['name' => 'Apple', 'country' => 'US'],
                    ['name' => 'Samsung', 'country' => 'KR'],
                    ['name' => 'Xiaomi', 'country' => 'CN'],
                    ['name' => 'OnePlus', 'country' => 'CN'],
                ],
            ],
            [
                'cat' => 'Laptop',
                'items' => [
                    ['name' => 'Dell', 'country' => 'US'],
                    ['name' => 'HP', 'country' => 'US'],
                    ['name' => 'Lenovo', 'country' => 'CN'],
                    ['name' => 'ASUS', 'country' => 'TW'],
                    ['name' => 'Acer', 'country' => 'TW'],
                ],
            ],
            [
                'cat' => 'Electronic Item',
                'items' => [
                    ['name' => 'Sony', 'country' => 'JP'],
                    ['name' => 'LG', 'country' => 'KR'],
                    ['name' => 'Panasonic', 'country' => 'JP'],
                    ['name' => 'Philips', 'country' => 'NL'],
                ],
            ],
            [
                'cat' => 'Organic Food',
                'items' => [
                    ["name" => "Organic Valley", 'country' => 'US'],
                    ["name" => "Nature's Path", 'country' => 'CA'],
                    ['name' => 'Whole Earth', 'country' => 'UK'],
                ],
            ],
            [
                'cat' => 'Eyewear',
                'items' => [
                    ['name' => 'Ray-Ban', 'country' => 'IT'],
                    ['name' => 'Oakley', 'country' => 'US'],
                    ['name' => 'Warby Parker', 'country' => 'US'],
                ],
            ],
            [
                'cat' => 'Cosmetic',
                'items' => [
                    ["name" => "L'Oréal", 'country' => 'FR'],
                    ['name' => 'Maybelline', 'country' => 'US'],
                    ['name' => 'MAC', 'country' => 'CA'],
                    ['name' => 'NIVEA', 'country' => 'DE'],
                ],
            ],
            [
                'cat' => 'Gadget',
                'items' => [
                    ['name' => 'Anker', 'country' => 'CN'],
                    ['name' => 'Logitech', 'country' => 'CH'],
                    ['name' => 'Razer', 'country' => 'US'],
                ],
            ],
            [
                'cat' => 'Gift Item',
                'items' => [
                    ['name' => 'Hallmark', 'country' => 'US'],
                    ['name' => 'Paper Source', 'country' => 'US'],
                    ['name' => 'Typo', 'country' => 'AU'],
                ],
            ],
        ];

        foreach ($data as $category) {
            foreach ($category['items'] as $item) {
                BrandTemplate::updateOrCreate(
                    [
                        'name' => $item['name'],        
                        'category' => $category['cat'], 
                    ],
                    [
                        'slug' => Str::slug($item['name']),
                        'country' => $item['country'],
                        'order' => 0,
                        'featured' => false,
                        'active' => true,
                        'top' => false,
                    ]
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog\Category;
use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeTerm;
use Illuminate\Support\Arr;

use App\Models\Admin\Product\ProductCategory; // Added for Product seeding compatibility

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // === Categories (LABELS) ===
        $categories = [
            'clothing' => 'Clothing',
            'phone' => 'Phone',
            'laptop' => 'Laptop',
            'electronicItem' => 'Electronic Item',
            'organicFood' => 'Organic Food',
            'eyewear' => 'Eyewear',
            'cosmetic' => 'Cosmetic',
            'gadget' => 'Gadget',
            'giftItem' => 'Gift Item',
            'sportsItem' => 'Sports Item',
            'adventureGear' => 'Adventure Gear',
            'animalFood' => 'Animal Food',
        ];

        $catModels = [];
        foreach ($categories as $slug => $name) {
            echo "Creating category: $name ($slug)\n";
            $catModels[$slug] = Category::firstOrCreate(['slug' => $slug], ['name' => $name]);
            // Also create ProductCategory for ProductSeeder compatibility
            ProductCategory::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // === Attributes (ATTRIBUTES meta) ===
        $attrs = [
            // General
            'color' => ['name' => 'Color', 'code' => 'CLR', 'type' => 'swatch', 'edit_fields' => ['name', 'code', 'color']],
            'size' => ['name' => 'Size', 'code' => 'SIZE', 'type' => 'select', 'edit_fields' => ['name', 'code', 'unit']],
            'material' => ['name' => 'Material', 'code' => 'MAT', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'brand' => ['name' => 'Brand', 'code' => 'BRD', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'dimension_unit' => ['name' => 'Dimension Unit', 'code' => 'DUNIT', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'weight_unit' => ['name' => 'Weight Unit', 'code' => 'WUNIT', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'warranty' => ['name' => 'Warranty', 'code' => 'WRN', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            // Electronics
            'storage' => ['name' => 'Storage', 'code' => 'STR', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'ram' => ['name' => 'RAM', 'code' => 'RAM', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'cpu' => ['name' => 'CPU', 'code' => 'CPU', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'screen' => ['name' => 'Screen Size', 'code' => 'SCR', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'os' => ['name' => 'Operating System', 'code' => 'OS', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'conn' => ['name' => 'Connectivity', 'code' => null, 'type' => 'select', 'edit_fields' => ['name', 'code']],
            // Clothing
            'fit' => ['name' => 'Fit', 'code' => 'FIT', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'pattern' => ['name' => 'Pattern', 'code' => 'PAT', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            // Food
            'flavor' => ['name' => 'Flavor', 'code' => 'FLV', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'weight_pack' => ['name' => 'Pack Weight/Size', 'code' => 'PACK', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'pet_type' => ['name' => 'Pet Type', 'code' => 'PET', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            // Eyewear
            'frame_color' => ['name' => 'Frame Color', 'code' => 'FCLR', 'type' => 'swatch', 'edit_fields' => ['name', 'code', 'color']],
            'lens_type' => ['name' => 'Lens Type', 'code' => 'LENS', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            // Cosmetic
            'shade' => ['name' => 'Shade', 'code' => 'SHD', 'type' => 'swatch', 'edit_fields' => ['name', 'code', 'color']],
            'finish' => ['name' => 'Finish', 'code' => 'FIN', 'type' => 'select', 'edit_fields' => ['name', 'code']],
            // Category-specific
            'theme' => ['name' => 'Theme', 'code' => null, 'type' => 'select', 'edit_fields' => ['name', 'code']],
            'sport_type' => ['name' => 'Sport Type', 'code' => 'SPORT', 'type' => 'select', 'edit_fields' => ['name', 'code']],
        ];

        $attrModels = [];
        foreach ($attrs as $slug => $meta) {
            $attrModels[$slug] = Attribute::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $meta['name'],
                    'code' => $meta['code'],
                    'type' => $meta['type'],
                    'edit_fields' => $meta['edit_fields']
                ]
            );
        }

        // === Terms (exactly as in JS) ===
        $terms = [
            'color' => [
                ['slug' => 'red', 'name' => 'Red', 'code' => 'RED', 'color' => '#ef4444'],
                ['slug' => 'blue', 'name' => 'Blue', 'code' => 'BLU', 'color' => '#3b82f6'],
                ['slug' => 'black', 'name' => 'Black', 'code' => 'BLK', 'color' => '#111827'],
                ['slug' => 'white', 'name' => 'White', 'code' => 'WHT', 'color' => '#ffffff', 'has_border' => true],
            ],
            'size' => [
                ['slug' => 's', 'name' => 'S', 'code' => 'S', 'unit' => 'EU'],
                ['slug' => 'm', 'name' => 'M', 'code' => 'M', 'unit' => 'EU'],
                ['slug' => 'l', 'name' => 'L', 'code' => 'L', 'unit' => 'EU'],
            ],
            'material' => [
                ['slug' => 'cotton', 'name' => 'Cotton', 'code' => 'CTN'],
                ['slug' => 'poly', 'name' => 'Polyester', 'code' => 'POL'],
            ],
            'brand' => [
                ['slug' => 'apple', 'name' => 'Apple', 'code' => 'APL'],
                ['slug' => 'samsung', 'name' => 'Samsung', 'code' => 'SAM'],
                ['slug' => 'nike', 'name' => 'Nike', 'code' => 'NIKE'],
            ],
            'dimension_unit' => [
                ['slug' => 'mm', 'name' => 'mm', 'code' => 'MM'],
                ['slug' => 'cm', 'name' => 'cm', 'code' => 'CM'],
                ['slug' => 'inch', 'name' => 'inch', 'code' => 'IN'],
            ],
            'weight_unit' => [
                ['slug' => 'g', 'name' => 'g', 'code' => 'G'],
                ['slug' => 'kg', 'name' => 'kg', 'code' => 'KG'],
                ['slug' => 'lb', 'name' => 'lb', 'code' => 'LB'],
            ],
            'warranty' => [
                ['slug' => '6', 'name' => '6 Months', 'code' => '6M'],
                ['slug' => '12', 'name' => '12 Months', 'code' => '12M'],
            ],
            'storage' => [
                ['slug' => '64', 'name' => '64GB', 'code' => '64'],
                ['slug' => '128', 'name' => '128GB', 'code' => '128'],
            ],
            'ram' => [
                ['slug' => '8', 'name' => '8GB', 'code' => '8G'],
                ['slug' => '16', 'name' => '16GB', 'code' => '16G'],
            ],
            'cpu' => [
                ['slug' => 'i5', 'name' => 'Intel i5', 'code' => 'I5'],
                ['slug' => 'i7', 'name' => 'Intel i7', 'code' => 'I7'],
            ],
            'screen' => [
                ['slug' => '13', 'name' => '13&quot;', 'code' => '13'],
                ['slug' => '15', 'name' => '15&quot;', 'code' => '15'],
            ],
            'os' => [
                ['slug' => 'ios', 'name' => 'iOS', 'code' => 'IOS'],
                ['slug' => 'android', 'name' => 'Android', 'code' => 'AND'],
            ],
            'conn' => [
                ['slug' => 'bt', 'name' => 'Bluetooth', 'code' => 'BT'],
                ['slug' => 'wifi', 'name' => 'Wi-Fi', 'code' => 'WF'],
            ],
            'fit' => [
                ['slug' => 'slim', 'name' => 'Slim', 'code' => 'SLIM'],
                ['slug' => 'regular', 'name' => 'Regular', 'code' => 'REG'],
            ],
            'pattern' => [
                ['slug' => 'solid', 'name' => 'Solid', 'code' => 'SLD'],
                ['slug' => 'striped', 'name' => 'Striped', 'code' => 'STP'],
            ],
            'flavor' => [
                ['slug' => 'plain', 'name' => 'Plain', 'code' => 'PLN'],
                ['slug' => 'chili', 'name' => 'Chili', 'code' => 'CHI'],
            ],
            'weight_pack' => [
                ['slug' => '100g', 'name' => '100g', 'code' => '100G'],
                ['slug' => '500g', 'name' => '500g', 'code' => '500G'],
            ],
            'pet_type' => [
                ['slug' => 'dog', 'name' => 'Dog', 'code' => 'DOG'],
                ['slug' => 'cat', 'name' => 'Cat', 'code' => 'CAT'],
            ],
            'frame_color' => [
                ['slug' => 'gold', 'name' => 'Gold', 'code' => 'GLD', 'color' => '#d4af37'],
                ['slug' => 'silver', 'name' => 'Silver', 'code' => 'SLV', 'color' => '#c0c0c0'],
            ],
            'lens_type' => [
                ['slug' => 'sv', 'name' => 'Single Vision', 'code' => 'SV'],
                ['slug' => 'bf', 'name' => 'Bifocal', 'code' => 'BF'],
            ],
            'shade' => [
                ['slug' => 'n1', 'name' => 'N1', 'code' => 'N1', 'color' => '#e7c3a7'],
                ['slug' => 'n2', 'name' => 'N2', 'code' => 'N2', 'color' => '#d3a27d'],
            ],
            'finish' => [
                ['slug' => 'matte', 'name' => 'Matte', 'code' => 'MAT'],
                ['slug' => 'glossy', 'name' => 'Glossy', 'code' => 'GLS'],
            ],
            'theme' => [
                ['slug' => 'birthday', 'name' => 'Birthday', 'code' => 'BD'],
                ['slug' => 'anniv', 'name' => 'Anniversary', 'code' => 'ANV'],
            ],
            'sport_type' => [
                ['slug' => 'cricket', 'name' => 'Cricket', 'code' => 'CRK'],
                ['slug' => 'football', 'name' => 'Football', 'code' => 'FTB'],
            ],
        ];

        foreach ($terms as $attrSlug => $rows) {
            $attr = $attrModels[$attrSlug];
            foreach ($rows as $row) {
                AttributeTerm::firstOrCreate(
                    ['attribute_id' => $attr->id, 'slug' => $row['slug']],
                    [
                        'name' => $row['name'],
                        'code' => $row['code'] ?? null,
                        'unit' => $row['unit'] ?? null,
                        'color' => $row['color'] ?? null,
                        'has_border' => (bool) ($row['has_border'] ?? false),
                        'meta' => null
                    ]
                );
            }
        }

        // === Category -> Attributes mapping (DATA) ===
        $map = [
            'clothing' => ['color', 'size', 'material', 'fit', 'pattern', 'dimension_unit', 'weight_unit'],
            'phone' => ['brand', 'color', 'storage', 'ram', 'screen', 'os', 'warranty', 'dimension_unit', 'weight_unit'],
            'laptop' => ['brand', 'storage', 'ram', 'cpu', 'screen', 'os', 'warranty', 'dimension_unit', 'weight_unit'],
            'electronicItem' => ['brand', 'color', 'conn', 'warranty', 'dimension_unit', 'weight_unit'],
            'organicFood' => ['flavor', 'weight_pack', 'weight_unit'],
            'eyewear' => ['frame_color', 'size', 'lens_type'],
            'cosmetic' => ['shade', 'finish'],
            'gadget' => ['brand', 'color', 'conn', 'warranty'],
            'giftItem' => ['theme', 'color', 'size'],
            'sportsItem' => ['sport_type', 'brand', 'color', 'size', 'material'],
            'adventureGear' => ['brand', 'color', 'size', 'material', 'weight_unit'],
            'animalFood' => ['pet_type', 'flavor', 'weight_pack'],
        ];

        foreach ($map as $catSlug => $attrSlugs) {
            $cat = $catModels[$catSlug];
            $ids = Arr::map($attrSlugs, fn($s) => $attrModels[$s]->id);
            $cat->attributes()->syncWithoutDetaching($ids);
        }
    }
}


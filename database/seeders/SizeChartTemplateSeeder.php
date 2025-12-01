<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use App\Models\SizeChartTemplate;
use Illuminate\Database\Seeder;

class SizeChartTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // category_slug => [templates...]
        $data = [
            'clothing' => [
                [
                    'code' => 'tee',
                    'name' => 'Unisex T-Shirt',
                    'unit' => 'cm',
                    'columns' => ['Size', 'Chest', 'Length', 'Shoulder', 'Sleeve'],
                    'rows' => [['S', 48, 70, 43, 20], ['M', 51, 72, 45, 21], ['L', 54, 74, 47, 22], ['XL', 57, 76, 49, 23]],
                ],
                [
                    'code' => 'hoodie',
                    'name' => 'Hoodie',
                    'unit' => 'cm',
                    'columns' => ['Size', 'Chest', 'Length', 'Sleeve'],
                    'rows' => [['S', 50, 66, 60], ['M', 53, 69, 62], ['L', 56, 72, 64], ['XL', 59, 75, 66]],
                ],
                [
                    'code' => 'shirt',
                    'name' => 'Men Shirt',
                    'unit' => 'cm',
                    'columns' => ['Size', 'Neck', 'Chest', 'Waist', 'Sleeve'],
                    'rows' => [['S', 38, 96, 84, 61], ['M', 40, 102, 90, 62], ['L', 42, 108, 96, 63]],
                ],
                [
                    'code' => 'jeans',
                    'name' => 'Jeans',
                    'unit' => 'cm',
                    'columns' => ['Size', 'Waist', 'Hip', 'Inseam'],
                    'rows' => [['30', 76, 96, 76], ['32', 81, 101, 78], ['34', 86, 106, 80]],
                ],
                [
                    'code' => 'dress',
                    'name' => 'Women Dress',
                    'unit' => 'cm',
                    'columns' => ['Size', 'Bust', 'Waist', 'Hip', 'Length'],
                    'rows' => [['S', 84, 66, 90, 95], ['M', 89, 71, 95, 97], ['L', 94, 76, 100, 99]],
                ],
            ],

            'phone' => [
                [
                    'code' => 'phone-dim',
                    'name' => 'Smartphone Dimensions',
                    'unit' => 'mm',
                    'columns' => ['Model', 'Height', 'Width', 'Thickness', 'Weight(g)'],
                    'rows' => [['5.8"', 144, 71, 7.7, 150], ['6.1"', 150, 72, 7.8, 165], ['6.7"', 160, 77, 8.1, 200]],
                ],
                [
                    'code' => 'protector',
                    'name' => 'Screen Protector',
                    'unit' => 'mm',
                    'columns' => ['Inches', 'Glass Width', 'Glass Height'],
                    'rows' => [['5.5"', 62, 130], ['6.1"', 68, 142], ['6.7"', 74, 155]],
                ],
                [
                    'code' => 'case',
                    'name' => 'Case Size Matrix',
                    'unit' => '',
                    'columns' => ['Brand', 'Model', 'Case Code'],
                    'rows' => [['Apple', 'iPhone 14', 'C-14'], ['Samsung', 'S24', 'C-S24'], ['Xiaomi', '12T', 'C-12T']],
                ],
            ],

            'laptop' => [
                [
                    'code' => 'laptop-dim',
                    'name' => 'Laptop Size',
                    'unit' => 'mm',
                    'columns' => ['Inches', 'Width', 'Depth', 'Height'],
                    'rows' => [['13"', 304, 212, 15], ['14"', 318, 224, 17], ['15.6"', 360, 250, 19]],
                ],
                [
                    'code' => 'sleeve',
                    'name' => 'Sleeve Guide',
                    'unit' => 'cm',
                    'columns' => ['Inches', 'Inner Width', 'Inner Height'],
                    'rows' => [['13"', 32, 22], ['14"', 34, 24], ['15.6"', 38, 27]],
                ],
                [
                    'code' => 'kb-cover',
                    'name' => 'Keyboard Cover',
                    'unit' => 'mm',
                    'columns' => ['Layout', 'Width', 'Height'],
                    'rows' => [['US ANSI', 279, 108], ['ISO', 285, 112]],
                ],
            ],

            'electronic item' => [
                [
                    'code' => 'tv-size',
                    'name' => 'TV Size (Panel)',
                    'unit' => 'cm',
                    'columns' => ['Inches', 'Width', 'Height'],
                    'rows' => [['32"', 71, 39], ['43"', 95, 53], ['55"', 121, 68]],
                ],
                [
                    'code' => 'vesa',
                    'name' => 'Monitor VESA Mount',
                    'unit' => '',
                    'columns' => ['VESA', 'Max Weight(kg)'],
                    'rows' => [['75x75', 8], ['100x100', 12], ['200x200', 25]],
                ],
                [
                    'code' => 'camera-bag',
                    'name' => 'Camera Bag',
                    'unit' => 'cm',
                    'columns' => ['Size', 'Inner L', 'Inner W', 'Inner H'],
                    'rows' => [['S', 20, 10, 15], ['M', 25, 12, 18], ['L', 30, 15, 22]],
                ],
            ],

            'organic food' => [
                [
                    'code' => 'pouch',
                    'name' => 'Pouch Size',
                    'unit' => 'cm',
                    'columns' => ['Weight(g)', 'Width', 'Height'],
                    'rows' => [[250, 12, 20], [500, 14, 23], [1000, 18, 28]],
                ],
                [
                    'code' => 'bottle',
                    'name' => 'Bottle Volume',
                    'unit' => 'mm',
                    'columns' => ['Volume(ml)', 'Diameter', 'Height'],
                    'rows' => [[250, 55, 180], [500, 65, 220], [1000, 85, 270]],
                ],
                [
                    'code' => 'box',
                    'name' => 'Food Box',
                    'unit' => 'cm',
                    'columns' => ['Size', 'L', 'W', 'H'],
                    'rows' => [['S', 15, 10, 6], ['M', 20, 12, 8], ['L', 25, 15, 10]],
                ],
            ],

            'eyewear' => [
                [
                    'code' => 'eyeframe',
                    'name' => 'Eyewear Frame',
                    'unit' => 'mm',
                    'columns' => ['Size', 'Lens', 'Bridge', 'Temple'],
                    'rows' => [['S', 48, 18, 140], ['M', 50, 19, 145], ['L', 52, 20, 150]],
                ],
                [
                    'code' => 'sunglass',
                    'name' => 'Sunglass Frame',
                    'unit' => 'mm',
                    'columns' => ['Size', 'Lens', 'Bridge', 'Temple'],
                    'rows' => [['S', 50, 18, 140], ['M', 52, 19, 145], ['L', 55, 20, 150]],
                ],
                [
                    'code' => 'kids-eye',
                    'name' => 'Kids Eyewear',
                    'unit' => 'mm',
                    'columns' => ['Size', 'Lens', 'Bridge', 'Temple'],
                    'rows' => [['S', 44, 16, 125], ['M', 46, 17, 130]],
                ],
            ],

            'cosmetic' => [
                [
                    'code' => 'foundation',
                    'name' => 'Foundation Shades',
                    'unit' => '',
                    'columns' => ['Shade', 'Tone', 'Hex'],
                    'rows' => [['100', 'Fair', '#F5E9DC'], ['220', 'Beige', '#E3CBAF'], ['340', 'Mocha', '#7B4E2A']],
                ],
                [
                    'code' => 'lip-volume',
                    'name' => 'Lipstick Volume',
                    'unit' => '',
                    'columns' => ['Variant', 'Volume(ml)', 'Weight(g)'],
                    'rows' => [['Mini', 2, 6], ['Std', 3.5, 9]],
                ],
                [
                    'code' => 'jar',
                    'name' => 'Cosmetic Jar',
                    'unit' => 'mm',
                    'columns' => ['Volume(ml)', 'Diameter', 'Height'],
                    'rows' => [[30, 45, 35], [50, 52, 42], [100, 65, 55]],
                ],
            ],

            'gadget' => [
                [
                    'code' => 'powerbank',
                    'name' => 'Power Bank',
                    'unit' => 'mm',
                    'columns' => ['mAh', 'Length', 'Width', 'Height', 'Weight(g)'],
                    'rows' => [[10000, 140, 70, 16, 230], [20000, 155, 73, 27, 420]],
                ],
                [
                    'code' => 'watch-strap',
                    'name' => 'Watch Strap',
                    'unit' => 'mm',
                    'columns' => ['Size', 'Lug Width', 'Wrist Circum.'],
                    'rows' => [['S', 20, 150], ['M', 22, 170], ['L', 24, 190]],
                ],
                [
                    'code' => 'earbuds',
                    'name' => 'Earbuds Case',
                    'unit' => 'mm',
                    'columns' => ['Model', 'Width', 'Height', 'Depth'],
                    'rows' => [['Std', 60, 45, 25], ['XL', 70, 50, 28]],
                ],
            ],

            'gift item' => [
                [
                    'code' => 'ring',
                    'name' => 'Ring',
                    'unit' => 'mm',
                    'columns' => ['Size', 'Diameter', 'Circumference'],
                    'rows' => [['6', 16.5, 52], ['7', 17.3, 54.4], ['8', 18.1, 56.5]],
                ],
                [
                    'code' => 'bangle',
                    'name' => 'Bangle',
                    'unit' => 'mm',
                    'columns' => ['Size', 'Inner Dia.', 'Circumference'],
                    'rows' => [['S', 58, 182], ['M', 60, 188], ['L', 64, 201]],
                ],
                [
                    'code' => 'mug',
                    'name' => 'Mug',
                    'unit' => 'mm',
                    'columns' => ['Volume(ml)', 'Diameter', 'Height'],
                    'rows' => [[250, 80, 90], [350, 85, 95], [450, 90, 105]],
                ],
            ],
        ];

        foreach ($data as $slug => $templates) {
            // ensure category exists; reuse if present
            $category = Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => ucwords($slug)]
            );

            foreach ($templates as $t) {
                SizeChartTemplate::updateOrCreate(
                    ['code' => $t['code']],
                    [
                        'category_id' => $category->id,
                        'name' => $t['name'],
                        'unit' => $t['unit'] ?? null,
                        'columns' => $t['columns'],
                        'rows' => $t['rows'],
                        'notes' => $t['notes'] ?? null,
                        'image_path' => $t['image_path'] ?? null,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}

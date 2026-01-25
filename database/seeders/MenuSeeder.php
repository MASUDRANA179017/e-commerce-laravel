<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Storage;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for truncate
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Clear existing menus
        MenuItem::truncate();
        Menu::truncate();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Load menus from JSON file
        $menusData = [];
        if (\Illuminate\Support\Facades\Storage::disk('local')->exists('private/menus.json')) {
            $menusData = json_decode(\Illuminate\Support\Facades\Storage::disk('local')->get('private/menus.json'), true) ?: [];
        } elseif (\Illuminate\Support\Facades\Storage::disk('local')->exists('menus.json')) {
            $menusData = json_decode(\Illuminate\Support\Facades\Storage::disk('local')->get('menus.json'), true) ?: [];
        }

        // Seed menus and items
        foreach ($menusData as $key => $items) {
            $menu = Menu::create([
                'key' => $key,
                'name' => ucfirst($key),
            ]);

            $this->seedMenuItems($menu->id, $items);
        }
    }

    /**
     * Recursively seed menu items.
     */
    private function seedMenuItems(int $menuId, array $items, ?int $parentId = null): void
    {
        foreach (array_values($items) as $idx => $item) {
            $menuItem = MenuItem::create([
                'menu_id' => $menuId,
                'parent_id' => $parentId,
                'label' => $item['label'] ?? '',
                'url' => $item['url'] ?? '',
                'sort_order' => $idx,
            ]);

            // Recursively seed children
            if (!empty($item['children']) && is_array($item['children'])) {
                $this->seedMenuItems($menuId, $item['children'], $menuItem->id);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('admin.product_category.index');
    }

    // Save category (add/edit)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'thumb_url' => 'nullable|string',
        ]);

        $parent = $request->parent_id ? ProductCategory::find($request->parent_id) : null;

        // Check max level = 4
        $level = $parent ? $parent->level() + 1 : 1;
        if ($level > 4) {
            return response()->json(['success' => false, 'message' => 'Max 4 levels allowed']);
        }

        // Find existing category if editing
        $category = $request->id ? ProductCategory::find($request->id) : new ProductCategory();
        
        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($category->thumb_url && !str_starts_with($category->thumb_url, 'http')) {
                deleteFile($category->thumb_url);
            }
            $category->thumb_url = null;
        }

        $productsCount = \DB::table('product_category_map as pcm')
            ->join('products as p', 'pcm.product_id', '=', 'p.id')
            ->where('pcm.category_id', $category->id)
            ->count();
        $variantsCount = \DB::table('product_variants as pv')
            ->join('products as p', 'pv.product_id', '=', 'p.id')
            ->join('product_category_map as pcm', 'p.id', '=', 'pcm.product_id')
            ->where('pcm.category_id', $category->id)
            ->count();
        $ordersCount = \DB::table('order_items as oi')
            ->join('products as p', 'oi.product_id', '=', 'p.id')
            ->join('product_category_map as pcm', 'p.id', '=', 'pcm.product_id')
            ->where('pcm.category_id', $category->id)
            ->distinct('oi.order_id')
            ->count('oi.order_id');
        $payload = [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'parent_id' => $category->parent_id,
            'order' => $category->order,
            'show_on_menu' => $category->show_on_menu,
            'icon' => $category->icon,
            'thumb_url' => $category->thumb_url,
            'products_count' => $productsCount,
            'orders_count' => $ordersCount,
            'variants_count' => $variantsCount,
            'children_recursive' => [],
        ];

        return response()->json(['success' => true, 'data' => $payload]);
    }

    // Get all parent categories for dropdown (level 1 + 2)
    private function buildCategoryTree($categories, $parentId = null, $prefix = '')
    {
        $result = [];

        foreach ($categories->where('parent_id', $parentId) as $category) {
            // push current category
            $result[] = [
                'id' => $category->id,
                'name' => $prefix.$category->name,
            ];

            // recursive call for children
            $children = $this->buildCategoryTree($categories, $category->id, $prefix.$category->name.' > ');
            $result = array_merge($result, $children);
        }

        return $result;
    }

    public function getParents()
    {
        $categories = ProductCategory::orderByRaw('CASE WHEN `order` = 0 OR `order` IS NULL THEN 1 ELSE 0 END, `order` ASC')->get();
        $tree = $this->buildCategoryTree($categories);

        return response()->json(['categories' => $tree]);
    }

    public function getTree()
    {
        $categories = ProductCategory::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderByRaw('CASE WHEN `order` = 0 OR `order` IS NULL THEN 1 ELSE 0 END, `order` ASC')
            ->get();

        $map = function ($cat) use (&$map) {
            $productsCount = \DB::table('product_category_map as pcm')
                ->join('products as p', 'pcm.product_id', '=', 'p.id')
                ->where('pcm.category_id', $cat->id)
                ->count();
            $variantsCount = \DB::table('product_variants as pv')
                ->join('products as p', 'pv.product_id', '=', 'p.id')
                ->join('product_category_map as pcm', 'p.id', '=', 'pcm.product_id')
                ->where('pcm.category_id', $cat->id)
                ->count();
            $ordersCount = \DB::table('order_items as oi')
                ->join('products as p', 'oi.product_id', '=', 'p.id')
                ->join('product_category_map as pcm', 'p.id', '=', 'pcm.product_id')
                ->where('pcm.category_id', $cat->id)
                ->distinct('oi.order_id')
                ->count('oi.order_id');
            $children = ($cat->childrenRecursive ?? collect())->map(function ($c) use (&$map) {
                return $map($c);
            })->toArray();
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'parent_id' => $cat->parent_id,
                'order' => $cat->order,
                'show_on_menu' => $cat->show_on_menu,
                'icon' => $cat->icon,
                'thumb_url' => $cat->thumb_url,
                'products_count' => $productsCount,
                'orders_count' => $ordersCount,
                'variants_count' => $variantsCount,
                'children_recursive' => $children,
            ];
        };
        $data = $categories->map(function ($c) use ($map) {
            return $map($c);
        });

        return response()->json($data);
    }

    // Get single category for edit
    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = ProductCategory::with('childrenRecursive')->findOrFail($id);

        // Recursive delete function
        $this->deleteCategoryWithChildren($category);

        // keep main menu Categories item in sync
        $this->syncMainMenuCategories();

        return response()->json([
            'success' => true,
            'message' => 'Category and all its children deleted successfully',
        ]);
    }

    /**
     * Recursive delete function
     */
    private function deleteCategoryWithChildren($category)
    {
        foreach ($category->children as $child) {
            $this->deleteCategoryWithChildren($child);
        }

        $category->delete();
    }

    /**
     * Rebuild "Categories" item in main menu from current product categories.
     */
    private function syncMainMenuCategories(): void
    {
        $path = 'menus.json';

        // Build category tree for menu
        $rootCategories = ProductCategory::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderByRaw('CASE WHEN `order` = 0 OR `order` IS NULL THEN 1 ELSE 0 END, `order` ASC')
            ->get();

        $mapCategory = function ($cat) use (&$mapCategory) {
            return [
                'label' => $cat->name,
                'url' => '/shop?category=' . $cat->slug,
                'children' => ($cat->childrenRecursive ?? collect())->map(function ($child) use (&$mapCategory) {
                    return $mapCategory($child);
                })->values()->toArray(),
            ];
        };

        $categoriesNode = [
            'label' => 'Categories',
            'url' => '/shop',
            'children' => $rootCategories->map(function ($cat) use (&$mapCategory) {
                return $mapCategory($cat);
            })->values()->toArray(),
        ];

        // Load menus file, create baseline if missing
        $menus = [];
        if (Storage::disk('local')->exists($path)) {
            $menus = json_decode(Storage::disk('local')->get($path), true) ?: [];
        } else {
            $menus['main'] = [];
            Storage::disk('local')->put($path, json_encode($menus));
        }

        if (!isset($menus['main'])) {
            $menus['main'] = [];
        }

        // Replace existing Categories item or append if not present
        $main = $menus['main'];
        $replaced = false;
        foreach ($main as $idx => $item) {
            if (isset($item['label']) && strtolower($item['label']) === 'categories') {
                $main[$idx] = $categoriesNode;
                $replaced = true;
                break;
            }
        }
        if (!$replaced) {
            $main[] = $categoriesNode;
        }

        $menus['main'] = $main;
        Storage::disk('local')->put($path, json_encode($menus));
    }

    public function leaf(Request $request)
    {
        // id, name, parent_id only; sort by `order` then name for stable paths
        $rows = ProductCategory::query()
            ->select('id', 'name', 'parent_id', 'order')
            ->orderByRaw('CASE WHEN `order` = 0 OR `order` IS NULL THEN 1 ELSE 0 END, `order` ASC')
            ->get();

        if ($rows->isEmpty()) {
            return response()->json([]);
        }

        // Build adjacency
        $nodes = [];
        foreach ($rows as $r) {
            $nodes[$r->id] = [
                'id' => $r->id,
                'name' => $r->name,
                'parent_id' => $r->parent_id,
                'children' => [],
                'order' => $r->order,
            ];
        }
        foreach ($nodes as $id => $n) {
            if ($n['parent_id'] && isset($nodes[$n['parent_id']])) {
                $nodes[$n['parent_id']]['children'][] = &$nodes[$id];
            }
        }

        // Roots = items without valid parent
        $roots = array_values(array_filter($nodes, fn ($n) => empty($n['parent_id']) || ! isset($nodes[$n['parent_id']])));

        // Sort children by order then name
        $sortFn = function (&$arr) use (&$sortFn) {
            usort($arr, function ($a, $b) {
                $ao = !empty($a['order']) ? $a['order'] : 999999;
                $bo = !empty($b['order']) ? $b['order'] : 999999;
                if ($ao === $bo) {
                    return strcasecmp($a['name'], $b['name']);
                }

                return $ao <=> $bo;
            });
            foreach ($arr as &$child) {
                if (! empty($child['children'])) {
                    $sortFn($child['children']);
                }
            }
        };
        $sortFn($roots);

        // DFS to collect leaf nodes with slug/path
        $leafs = [];
        $visit = function ($node, $nameParts, $slugParts) use (&$visit, &$leafs) {
            $nameParts2 = array_merge($nameParts, [$node['name']]);
            $slugParts2 = array_merge($slugParts, [Str::slug($node['name'])]);

            if (empty($node['children'])) {
                $leafs[] = [
                    'id' => $node['id'],
                    'slug' => implode('/', $slugParts2),
                    'path' => implode(' › ', $nameParts2),
                ];

                return;
            }
            foreach ($node['children'] as $ch) {
                $visit($ch, $nameParts2, $slugParts2);
            }
        };
        foreach ($roots as $r) {
            $visit($r, [], []);
        }

        return response()->json($leafs);
    }

    // public function tree(Request $request)
    // {
    //     $rows = ProductCategory::query()
    //         ->select('id', 'name', 'parent_id', 'order')
    //         ->orderByRaw('COALESCE(`order`, 999999) asc')
    //         ->orderBy('name')
    //         ->get();

    //     if ($rows->isEmpty()) {
    //         return response()->json([]);
    //     }

    //     // Build adjacency
    //     $nodes = [];
    //     foreach ($rows as $r) {
    //         $nodes[$r->id] = [
    //             'id' => $r->id,
    //             'name' => $r->name,
    //             'parent_id' => $r->parent_id,
    //             'children' => [],
    //             'order' => $r->order,
    //         ];
    //     }
    //     foreach ($nodes as $id => $n) {
    //         if ($n['parent_id'] && isset($nodes[$n['parent_id']])) {
    //             $nodes[$n['parent_id']]['children'][] = &$nodes[$id];
    //         }
    //     }
    //     // Roots
    //     $roots = array_values(array_filter($nodes, fn ($n) => empty($n['parent_id']) || ! isset($nodes[$n['parent_id']])));

    //     // Sort + compute slug along the way
    //     $sortFn = function (&$arr) use (&$sortFn) {
    //         usort($arr, function ($a, $b) {
    //             $ao = $a['order'] ?? 999999;
    //             $bo = $b['order'] ?? 999999;
    //             if ($ao === $bo) {
    //                 return strcasecmp($a['name'], $b['name']);
    //             }

    //             return $ao <=> $bo;
    //         });
    //         foreach ($arr as &$child) {
    //             if (! empty($child['children'])) {
    //                 $sortFn($child['children']);
    //             }
    //         }
    //     };
    //     $sortFn($roots);

    //     $mapTree = function ($node, $slugPrefix = []) use (&$mapTree) {
    //         $slugParts = array_merge($slugPrefix, [Str::slug($node['name'])]);

    //         return [
    //             'id' => $node['id'],
    //             'name' => $node['name'],
    //             'slug' => implode('/', $slugParts),
    //             'children' => array_map(fn ($c) => $mapTree($c, $slugParts), $node['children']),
    //         ];
    //     };

    //     $tree = array_map(fn ($r) => $mapTree($r, []), $roots);

    //     return response()->json($tree);
    // }

    public function tree()
{
    $rows = ProductCategory::select('id', 'name', 'parent_id', 'order')
        ->get();

    if ($rows->isEmpty()) {
        return response()->json([]);
    }

    // Build adjacency
    $nodes = [];
    foreach ($rows as $r) {
        $nodes[$r->id] = [
            'id' => $r->id,
            'name' => $r->name,
            'parent_id' => $r->parent_id,
            'order' => $r->order,
            'children' => [],
        ];
    }

    foreach ($nodes as $id => $node) {
        if ($node['parent_id'] && isset($nodes[$node['parent_id']])) {
            $nodes[$node['parent_id']]['children'][] = &$nodes[$id];
        }
    }

    // Root nodes
    $roots = array_values(array_filter($nodes, fn ($n) =>
        empty($n['parent_id']) || ! isset($nodes[$n['parent_id']])
    ));

    // ✅ SORT MAIN + SUB TREES
    $this->sortTree($roots);

    // Build slugged tree
    $mapTree = function ($node, $slugPrefix = []) use (&$mapTree) {
        $slug = array_merge($slugPrefix, [Str::slug($node['name'])]);

        return [
            'id' => $node['id'],
            'name' => $node['name'],
            'slug' => implode('/', $slug),
            'children' => array_map(
                fn ($c) => $mapTree($c, $slug),
                $node['children']
            ),
        ];
    };

    return response()->json(array_map(fn ($r) => $mapTree($r), $roots));
}

    private function sortTree(array &$nodes): void
{
    usort($nodes, function ($a, $b) {
        $ao = $a['order'] ?? PHP_INT_MAX;
        $bo = $b['order'] ?? PHP_INT_MAX;

        return $ao <=> $bo ?: strcasecmp($a['name'], $b['name']);
    });

    foreach ($nodes as &$node) {
        if (! empty($node['children'])) {
            $this->sortTree($node['children']);
        }
    }
}

}

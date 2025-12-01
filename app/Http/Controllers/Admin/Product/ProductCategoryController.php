<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('admin.product_category.index');
    }

    // Save category (add/edit)
    public function store(Request $request)
    {
        $parent = $request->parent_id ? ProductCategory::find($request->parent_id) : null;

        // Check max level = 4
        $level = $parent ? $parent->level() + 1 : 1;
        if ($level > 4) {
            return response()->json(['success' => false, 'message' => 'Max 4 levels allowed']);
        }

        $category = ProductCategory::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'parent_id' => $request->parent_id ?: null,
                'order' => $request->order ?? 0,
                'show_on_menu' => $request->show_on_menu ? 1 : 0,
                'icon' => $request->icon,
                'thumb_url' => $request->thumb_url,
            ]
        );

        return response()->json(['success' => true, 'data' => $category]);
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
        $categories = ProductCategory::all();
        $tree = $this->buildCategoryTree($categories);

        return response()->json(['categories' => $tree]);
    }

    public function getTree()
    {
        $categories = ProductCategory::with('childrenRecursive') // যত depth দরকার
            ->whereNull('parent_id')
            ->get();

        return response()->json($categories);
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

    public function leaf(Request $request)
    {
        // id, name, parent_id only; sort by `order` then name for stable paths
        $rows = ProductCategory::query()
            ->select('id', 'name', 'parent_id', 'order')
            ->orderByRaw('COALESCE(`order`, 999999) asc')
            ->orderBy('name')
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
                $ao = $a['order'] ?? 999999;
                $bo = $b['order'] ?? 999999;
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

    public function tree(Request $request)
    {
        $rows = ProductCategory::query()
            ->select('id', 'name', 'parent_id', 'order')
            ->orderByRaw('COALESCE(`order`, 999999) asc')
            ->orderBy('name')
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
        // Roots
        $roots = array_values(array_filter($nodes, fn ($n) => empty($n['parent_id']) || ! isset($nodes[$n['parent_id']])));

        // Sort + compute slug along the way
        $sortFn = function (&$arr) use (&$sortFn) {
            usort($arr, function ($a, $b) {
                $ao = $a['order'] ?? 999999;
                $bo = $b['order'] ?? 999999;
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

        $mapTree = function ($node, $slugPrefix = []) use (&$mapTree) {
            $slugParts = array_merge($slugPrefix, [Str::slug($node['name'])]);

            return [
                'id' => $node['id'],
                'name' => $node['name'],
                'slug' => implode('/', $slugParts),
                'children' => array_map(fn ($c) => $mapTree($c, $slugParts), $node['children']),
            ];
        };

        $tree = array_map(fn ($r) => $mapTree($r, []), $roots);

        return response()->json($tree);
    }
}

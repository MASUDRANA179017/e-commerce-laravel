<?php

namespace App\Http\Controllers\Admin\Business_SetUp\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Category as CatalogCategory;
use App\Models\Admin\Product\ProductCategory;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $slug = $request->query('category');
        if (!$slug) {
            return response()->json(['message' => 'category is required'], 422);
        }

        // Try Catalog categories first (where attributes are linked)
        $catalogCategory = CatalogCategory::where('slug', $slug)->first();

        // If not found, fall back to ProductCategory just to return category info with empty attributes
        $productCategory = null;
        if (!$catalogCategory) {
            $productCategory = ProductCategory::where('slug', $slug)->first();
            if (!$productCategory) {
                return response()->json(['message' => 'category not found'], 404);
            }
        }

        if ($catalogCategory) {
            $attributes = $catalogCategory->attributes()
                ->with(['terms' => function ($q) { $q->orderBy('id'); }])
                ->orderBy('name')
                ->get();

            $payload = [
                'category' => [
                    'id'   => $catalogCategory->id,
                    'slug' => $catalogCategory->slug,
                    'name' => $catalogCategory->name,
                ],
                'attributes' => $attributes->map(function ($a) {
                    $fields = $a->edit_fields ?? ['name','code'];
                    if (is_array($fields)) {
                        $fields = array_values(array_unique(array_merge(['name'], $fields)));
                    } else {
                        $fields = ['name','code'];
                    }
                    return [
                        'id'          => $a->id,
                        'slug'        => $a->slug,
                        'name'        => $a->name,
                        'code'        => $a->code,
                        'type'        => $a->type,
                        'edit_fields' => $fields,
                        'terms'       => $a->terms->map(function ($t) {
                            return [
                                'id'         => $t->id,
                                'slug'       => $t->slug,
                                'name'       => $t->name,
                                'code'       => $t->code,
                                'unit'       => $t->unit,
                                'color'      => $t->color,
                                'has_border' => (bool) $t->has_border,
                            ];
                        })->values(),
                        'terms_count' => $a->terms->count(),
                    ];
                })->values(),
            ];
        } else {
            // Product category exists but no Catalog category; return empty attributes payload
            $payload = [
                'category' => [
                    'id'   => $productCategory->id,
                    'slug' => $productCategory->slug,
                    'name' => $productCategory->name,
                ],
                'attributes' => [],
            ];
        }

        return response()->json($payload);
    }
}

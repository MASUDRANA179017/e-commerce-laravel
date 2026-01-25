<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeSet;
use App\Models\Catalog\AttributeSetItem;
use App\Models\Catalog\AttributeTerm;
use App\Models\Catalog\Category;
use App\Models\VariantSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Log;

class CreateProductApiController extends Controller
{
    // GET /admin/all-attributes/  -> { attributes: [ {id,name,type,terms:[...]} ] }
    public function attributesAll()
    {
        $attrs = Attribute::with(['terms' => function($q){
            $q->orderBy('name');
        }])->orderBy('name')->get();

        $payload = $attrs->map(function(Attribute $a){
            return [
                'id'   => $a->id,
                'name' => $a->name,
                'type' => $a->type, // 'text' | 'swatch' | etc
                'terms'=> $a->terms->map(function(AttributeTerm $t){
                    return [
                        'id'    => $t->id,
                        'name'  => $t->name,
                        'code'  => $t->code,
                        'color' => $t->color,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json(['attributes' => $payload]);
    }

    // GET /catalog/attribute-sets -> { sets: [ {id,name, attrs:[attribute_id,...]} ] }
    public function attributeSets()
    {
        $sets = AttributeSet::with(['items' => function($q){
            $q->orderBy('sort_order')->orderBy('id');
        }, 'category'])->orderBy('name')->get();

        $payload = $sets->map(function(AttributeSet $s){
            $attrIds = $s->items->pluck('attribute_id')->unique()->values();
            return [
                'id'         => $s->id,
                'name'       => $s->name,
                'category_id'=> $s->category_id,
                // core for the UI
                'attrs'      => $attrIds,
                // optional richer "items" if you want them
                'items'      => $s->items->map(function(AttributeSetItem $it){
                    return [
                        'attribute_id' => $it->attribute_id,
                        'term_id'      => $it->attribute_term_id,
                        'is_variant'   => (bool)$it->is_variant,
                        'is_filter'    => (bool)$it->is_filter,
                        'sort_order'   => (int)$it->sort_order,
                    ];
                })->values(),
                // hint for “category config”
                'category'   => $s->category ? ['id'=>$s->category->id, 'name'=>$s->category->name, 'slug'=>$s->category->slug] : null,
            ];
        })->values();

        return response()->json(['sets' => $payload]);
    }

    // POST /product/get/varient-rules  body:{attribute_set_id}
// returns [ { id, name, set_of_rules:[attribute_id,...] } ]
// Derives axes from AttributeSetItem.is_variant=1 and gracefully includes DB rules if table exists.
public function variantRules(Request $request)
{
    $setId = (int) $request->input('attribute_set_id');
    if (!$setId) {
        return response()->json(['message' => 'attribute_set_id required'], 422);
    }

    $set = AttributeSet::with('items')->find($setId);
    if (!$set) {
        return response()->json([]);
    }

    $rows = [];

    // Derived rule from attribute set items
    $axes = $set->items
        ->where('is_variant', true)
        ->pluck('attribute_id')
        ->unique()
        ->values()
        ->all();

    if (!empty($axes)) {
        $rows[] = [
            'id'           => 'derived_' . $set->id,
            'name'         => 'Derived from Attribute Set',
            'set_of_rules' => $axes,
        ];
    }

    // Get variant sets from the variant_sets table
    try {
        $variantSets = VariantSet::with('attributeSet')
            ->where('attribute_set_id', $setId)
            ->where('status', '!=', 'deleted')
            ->get()
            ->map(function ($vs) {
                // Extract attribute IDs from the variants array
                $attributeIds = [];
                
                if (is_array($vs->variants) && !empty($vs->variants)) {
                    // Get first variant to extract attribute structure
                    $firstVariant = $vs->variants[0] ?? null;
                    if ($firstVariant && isset($firstVariant['options']) && is_array($firstVariant['options'])) {
                        foreach ($firstVariant['options'] as $option) {
                            if (isset($option['attribute_id'])) {
                                $attributeIds[] = (int) $option['attribute_id'];
                            }
                        }
                    }
                }
                
                return [
                    'id'           => $vs->id,
                    'name'         => $vs->name,
                    'set_of_rules' => array_values(array_unique($attributeIds)),
                ];
            })
            ->toArray();
        
        $rows = array_merge($rows, $variantSets);
    } catch (\Throwable $e) {
        Log::warning('variant_sets query failed: ' . $e->getMessage());
    }

    return response()->json($rows);
}



  

    

    public function categoryConfig(string $slug)
    {
        $cat = Category::where('slug', $slug)->first();
        if (!$cat) return response()->json(null);

        // choose the first set tied to this category if any
        $set = AttributeSet::where('category_id', $cat->id)->orderBy('id')->first();

        return response()->json([
            'attrSet'          => $set?->id ?? null,
            'mediaRule'        => null,        // you can wire your own later
            'variantWiseImage' => false,
            'units'            => ['weight'=>'kg', 'dim'=>'cm'],
            'sizeChart'        => false,
        ]);
    }
}

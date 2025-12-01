<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeSet;
use App\Models\Catalog\AttributeSetItem;
use App\Models\Catalog\AttributeTerm;
use App\Models\Catalog\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    // returns [ { id, name, axes:[attribute_id,...], note } ]
    // DB does not contain a variant_rules table. We derive axes from AttributeSetItem.is_variant=1.
public function variantRules(Request $request)
{

    $setId = (int) $request->input('attribute_set_id');
    if (!$setId) {
        return response()->json(['message' => 'attribute_set_id required'], 422);
    }

    $set = AttributeSet::find($setId);
    if (!$set) {
        return response()->json([]);
    }

   

    $rules = DB::table('variant_rules')
        ->select('id', 'category_id', 'category_name', 'set_of_rules', 'status')
        ->where('category_id', $set->category_id)
        ->get()
        ->map(function ($r) use ($set) {
            $decoded = $r->set_of_rules ? json_decode($r->set_of_rules, true) : [];

            return [
                'id'            => $r->id,
                'category_id'   => $r->category_id,
                'category_name' => $r->category_name,
                'set_of_rules'  => $decoded,
                'status'        => $r->status,
                'derived_rule'  => [
                    'id'   => $set->id,
                    'name' => 'Derived from Attribute Set',
                    'note' => 'Axes come from items marked is_variant=1 in this set.',
                ],
            ];
        });
    // Log::info( $rules->toArray());

    return response()->json($rules);
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

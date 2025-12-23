<?php

namespace App\Http\Controllers\Admin\Business_SetUp;

use Illuminate\Http\Request;
use App\Models\Catalog\Category;
use App\Http\Controllers\Controller;
use App\Models\Catalog\AttributeSet;
use App\Models\VariantSet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VarientBuildController extends Controller
{
public function index() {
    $categories = Category::all();

        $sets = AttributeSet::with([
            'items.attribute',
            'items.term',
            'category'
        ])->get();

        $attribute_sets = $sets->map(function ($set) {
            // group terms under each attribute
            $attributes = $set->items
                ->groupBy('attribute_id')
                ->map(function ($items, $attributeId) {
                    $firstItem = $items->first();
                    $attribute = $firstItem->attribute;

                    return [
                        'id'    => $attribute->id,
                        'name'  => $attribute->name,
                        'code'  => $attribute->code ?? null,
                        'terms' => $items->map(function ($item) {
                            $term = $item->term;
                            if (!$term) return null;
                            return [
                                'id'   => $term->id,
                                'name' => $term->name,
                                'code' => $term->code ?? null,
                            ];
                        })->filter()->values()->toArray()
                    ];
                })
                ->values()
                ->toArray();

            return [
                'id'            => $set->id,
                'name'          => $set->name,
                'category_id'   => $set->category->id ?? null,
                'category_name' => $set->category->name ?? null,
                'attributes'    => $attributes
            ];
        })->toArray();

        // dd($attribute_sets);

    return view('admin.varient_build.index', compact('categories', 'attribute_sets'));
}

public function store(Request $request)
{
    $v = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'sku_prefix' => ['nullable', 'string', 'max:64'],
        'business' => ['nullable'],
        'attribute_set_id' => ['required', 'integer', 'exists:attribute_sets,id'],
        'media_rules' => ['array'],
        'variant_rules' => ['array'],
        'variants' => ['array', 'min:1'],
    ]);
    if ($v->fails()) {
        return response()->json(['ok' => false, 'message' => 'Validation failed', 'errors' => $v->errors()], 422);
    }

    $data = $v->validated();
    // Optional server-side enforcement: unique SKUs when the rule is enabled
    $vr = $data['variant_rules'] ?? [];
    $enforceUnique = is_array($vr) && (!empty($vr['unique_sku']));
    if ($enforceUnique) {
        $seen = [];
        foreach (($data['variants'] ?? []) as $idx => $vrow) {
            $sku = strtoupper(trim((string)($vrow['sku'] ?? '')));
            if ($sku === '') {
                return response()->json(['ok' => false, 'message' => 'SKU is required when unique SKU rule is enabled', 'errors' => ['variants' => ['SKU required at index '.$idx]]], 422);
            }
            if (isset($seen[$sku])) {
                return response()->json(['ok' => false, 'message' => 'Duplicate SKUs found', 'errors' => ['variants' => ['Duplicate SKU "'.$sku.'" at index '.$idx]]], 422);
            }
            $seen[$sku] = true;
        }
    }

    $row = VariantSet::create([
        'name' => $data['name'],
        'category_id' => is_numeric($data['business'] ?? null) ? (int) $data['business'] : null,
        'attribute_set_id' => (int) $data['attribute_set_id'],
        'sku_prefix' => $data['sku_prefix'] ?? null,
        'media_rules' => $data['media_rules'] ?? [],
        'variant_rules' => $data['variant_rules'] ?? [],
        'variants' => $data['variants'] ?? [],
        'status' => 'draft',
        'created_by' => optional(Auth::user())->id,
    ]);

    return response()->json(['ok' => true, 'id' => $row->id, 'message' => 'Variant Set saved'], 201);
}

}
// [
//   {
//     id:"clo_basic",
//     name:"Clothing — Color + Size",
//     business:"Clothing",
//     attributes:[
//       { id:"color", name:"Color", code:"CLR", terms:[
//         {id:"red", name:"Red", code:"RED"},
//         {id:"blue", name:"Blue", code:"BLU"},
//         {id:"black", name:"Black", code:"BLK"}
//       ]},
//       { id:"size", name:"Size", code:"SIZE", terms:[
//         {id:"s", name:"S", code:"S"},
//         {id:"m", name:"M", code:"M"},
//         {id:"l", name:"L", code:"L"}
//       ]}
//     ]
//   }
// ];

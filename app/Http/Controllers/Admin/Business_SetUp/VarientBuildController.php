<?php

namespace App\Http\Controllers\Admin\Business_SetUp;

use Illuminate\Http\Request;
use App\Models\Catalog\Category;
use App\Http\Controllers\Controller;
use App\Models\Catalog\AttributeSet;

class VarientBuildController extends Controller
{
public function index() {
    $categories = Category::all();

        $attribute_sets = AttributeSet::with([
            'items.attribute'
        ])->get();

        // $attribute_sets = $attributeSets->map(function ($set) {
        //     // group terms under each attribute
        //     $attributes = $set->items
        //         ->groupBy('attribute_id')
        //         ->map(function ($items, $attributeId) {
        //             $firstItem = $items->first();
        //             $attribute = $firstItem->attribute;

        //             return [
        //                 'id'    => $attribute->id,                    // or slug/code
        //                 'name'  => $attribute->name,
        //                 'code'  => $attribute->code ?? null,          // if code exists
        //                 'terms' => $items->map(function ($item) {
        //                     $term = $item->attributeTerm;
        //                     return [
        //                         'id'   => $term->id,
        //                         'name' => $term->name,
        //                         'code' => $term->code ?? null,       // if code exists
        //                     ];
        //                 })->values()->toArray()
        //             ];
        //         })
        //         ->values()
        //         ->toArray();

        //     return [
        //         'id'         => $set->id,                          // or slug/code like "clo_basic"
        //         'name'       => $set->name,
        //         'business'   => optional($set->category)->name ?? null,   // if category is business
        //         'attributes' => $attributes
        //     ];
        // })->toArray();

        // dd($attribute_sets);

    return view('admin.varient_build.index', compact('categories', 'attribute_sets'));
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

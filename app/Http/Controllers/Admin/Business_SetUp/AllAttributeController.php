<?php

namespace App\Http\Controllers\Admin\Business_SetUp;

use App\Http\Controllers\Controller;
use App\Models\Catalog\AttributeSet;
use Illuminate\Http\Request;

class AllAttributeController extends Controller
{
    //
    public function index()
    {
        return view('admin.business_settings.all_attributes');
    }
    public function attributeSetsIndex()
    {
        $sets = AttributeSet::with([
            'items' => function ($q) {
                $q->with([
                    'attribute:id,name,type,code',
                    'term:id,attribute_id,name,code,color'
                ])->orderBy('sort_order');
            }
        ])->orderByDesc('id')->get();

        $payload = $sets->map(function ($set) {
            return [
                'id' => $set->id,
                'name' => $set->name,
                'items' => $set->items->map(function ($it) {
                    return [
                        'id' => $it->id,
                        'attribute' => [
                            'id' => $it->attribute->id,
                            'name' => $it->attribute->name,
                            'type' => $it->attribute->type,
                            'slug' => strtolower($it->attribute->code),
                        ],
                        'term' => $it->term ? [
                            'id' => $it->term->id,
                            'name' => $it->term->name,
                            'code' => $it->term->code,
                            'color' => $it->term->color,
                        ] : null,
                        'is_variant' => (bool) $it->is_variant,
                        'is_filter' => (bool) $it->is_filter,
                        'sort_order' => (int) $it->sort_order,
                    ];
                }),
            ];
        });

        return response()->json(['sets' => $payload]);
    }
}

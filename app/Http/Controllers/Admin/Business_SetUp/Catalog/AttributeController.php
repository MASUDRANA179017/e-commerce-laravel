<?php

namespace App\Http\Controllers\Admin\Business_SetUp\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Category;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $slug = $request->query('category');
        if (!$slug) {
            return response()->json(['message'=>'category is required'], 422);
        }

        $category = Category::where('slug',$slug)->firstOrFail();

        $attributes = $category->attributes()
            ->with(['terms' => function($q){ $q->orderBy('id'); }])
            ->orderBy('name')
            ->get();

        $payload = [
            'category' => [
                'id'   => $category->id,
                'slug' => $category->slug,
                'name' => $category->name,
            ],
            'attributes' => $attributes->map(function($a){
                return [
                    'id'          => $a->id,
                    'slug'        => $a->slug,
                    'name'        => $a->name,
                    'code'        => $a->code,
                    'type'        => $a->type,
                    'edit_fields' => $a->edit_fields ?? ['name','code'],
                    'terms'       => $a->terms->map(function($t){
                        return [
                            'id'         => $t->id,
                            'slug'       => $t->slug,
                            'name'       => $t->name,
                            'code'       => $t->code,
                            'unit'       => $t->unit,
                            'color'      => $t->color,
                            'has_border' => (bool)$t->has_border,
                        ];
                    })->values(),
                    'terms_count' => $a->terms->count(),
                ];
            })->values(),
        ];

        return response()->json($payload);
    }
}

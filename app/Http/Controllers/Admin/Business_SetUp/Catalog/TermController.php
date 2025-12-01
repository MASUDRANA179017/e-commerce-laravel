<?php
namespace App\Http\Controllers\Admin\Business_SetUp\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeTerm;
use Log;
class TermController extends Controller
{
    // Create term
    public function store(Request $request)
    {
        $data = $request->validate([
            'attribute_id' => ['required','exists:attributes,id'],
            'slug'         => ['nullable','regex:/^[A-Za-z0-9_\-]+$/'],
            'name'         => ['required','string','max:255'],
            'code'         => ['nullable','string','max:32'],
            'unit'         => ['nullable','string','max:32'],
            'color'        => ['nullable','string','max:16'],
            'has_border'   => ['nullable','boolean'],
        ]);

        $attr = Attribute::findOrFail($data['attribute_id']);

        // default slug: from name if not provided
        $slug = $data['slug'] ?? strtoupper(preg_replace('/[^A-Za-z0-9]+/','_', $data['name']));
        // ensure uniqueness per attribute
        $exists = AttributeTerm::where('attribute_id',$attr->id)->where('slug',$slug)->exists();
        if ($exists) {
            return response()->json(['message'=>'Slug already exists for this attribute'], 422);
        }

        $term = AttributeTerm::create([
            'attribute_id' => $attr->id,
            'slug'         => $slug,
            'name'         => $data['name'],
            'code'         => $data['code'] ?? null,
            'unit'         => $data['unit'] ?? null,
            'color'        => $data['color'] ?? null,
            'has_border'   => (bool)($data['has_border'] ?? false),
            'meta'         => null,
        ]);

        return response()->json([
            'term' => [
                'id'=>$term->id,'slug'=>$term->slug,'name'=>$term->name,'code'=>$term->code,
                'unit'=>$term->unit,'color'=>$term->color,'has_border'=>(bool)$term->has_border
            ]
        ], 201);
    }

    // Update term
    public function update(Request $request, AttributeTerm $term)
    {
        log::info('Update Term Request Data:', $request->all());
        log::info('Term to be updated:', $term->toArray());
        $data = $request->validate([
            'name'       => ['sometimes','required','string','max:255'],
            'code'       => ['nullable','string','max:32'],
            'unit'       => ['nullable','string','max:32'],
            'color'      => ['nullable','string','max:16'],
            'has_border' => ['nullable','boolean'],
        ]);

        $term->fill($data);
        $term->save();

        return response()->json([
            'term' => [
                'id'=>$term->id,'slug'=>$term->slug,'name'=>$term->name,'code'=>$term->code,
                'unit'=>$term->unit,'color'=>$term->color,'has_border'=>(bool)$term->has_border
            ]
        ]);
    }

    // Delete term
    public function destroy(AttributeTerm $term)
    {
        $term->delete();
        return response()->json(['deleted'=>true]);
    }
}


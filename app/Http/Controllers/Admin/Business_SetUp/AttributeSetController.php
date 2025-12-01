<?php

namespace App\Http\Controllers\Admin\Business_SetUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Catalog\Category;
use App\Models\Catalog\AttributeSet;
use App\Models\Catalog\AttributeSetItem;

class AttributeSetController extends Controller
{
    // Optional: list existing sets for a category
    public function index(Request $request)
    {
        $slug = $request->query('category');
        $q = AttributeSet::query()->with([
            'items' => function ($q) {
                $q->orderBy('sort_order');
            }
        ]);

        if ($slug) {
            $cat = Category::where('slug', $slug)->first();
            if ($cat)
                $q->where('category_id', $cat->id);
        }

        $sets = $q->orderBy('id', 'desc')->get()->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'category_id' => $s->category_id,
                'items' => $s->items->map(fn($i) => [
                    'id' => $i->id,
                    'attribute_id' => $i->attribute_id,
                    'attribute_term_id' => $i->attribute_term_id,
                    'is_variant' => (bool) $i->is_variant,
                    'is_filter' => (bool) $i->is_filter,
                    'sort_order' => (int) $i->sort_order,
                ])->values(),
            ];
        });

        return response()->json(['sets' => $sets]);
    }

    // Create/Update multiple sets at once from the UI
    public function bulkSave(Request $request)
    {
        $data = $request->validate([
            'sets' => ['required', 'array', 'min:1'],
            'sets.*.id' => ['nullable', 'integer', 'exists:attribute_sets,id'],
            'sets.*.name' => ['required', 'string', 'max:255'],
            'sets.*.category_slug' => ['nullable', 'string', 'exists:categories,slug'],
            'sets.*.items' => ['array'],
            'sets.*.items.*.attribute_id' => ['required', 'integer', 'exists:attributes,id'],
            'sets.*.items.*.attribute_term_id' => ['required', 'integer', 'exists:attribute_terms,id'],
            'sets.*.items.*.is_variant' => ['boolean'],
            'sets.*.items.*.is_filter' => ['boolean'],
            'sets.*.items.*.sort_order' => ['integer'],
        ]);

        $saved = [];

        DB::transaction(function () use ($data, &$saved) {
            foreach ($data['sets'] as $payload) {
                $catId = null;
                if (!empty($payload['category_slug'])) {
                    $catId = optional(Category::where('slug', $payload['category_slug'])->first())->id;
                }

                $set = isset($payload['id'])
                    ? AttributeSet::find($payload['id'])
                    : new AttributeSet();

                $set->name = $payload['name'];
                $set->category_id = $catId;
                if (!$set->exists) {
                    $set->created_by = auth()->id();
                }
                $set->save();

                // reset items (simple + predictable)
                $set->items()->delete();

                $itemsData = [];
                foreach ($payload['items'] ?? [] as $i => $it) {
                    $itemsData[] = [
                        'attribute_set_id' => $set->id,
                        'category_id' => $catId,
                        'attribute_id' => (int) $it['attribute_id'],
                        'attribute_term_id' => (int) $it['attribute_term_id'],
                        'is_variant' => !empty($it['is_variant']),
                        'is_filter' => array_key_exists('is_filter', $it) ? (bool) $it['is_filter'] : true,
                        'sort_order' => (int) ($it['sort_order'] ?? $i),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                if ($itemsData) {
                    AttributeSetItem::insert($itemsData);
                }

                $saved[] = [
                    'id' => $set->id,
                    'name' => $set->name,
                ];
            }
        });

        return response()->json(['sets' => $saved]);
    }

    public function destroy(AttributeSet $attribute_set)
    {
        // Optional guard if sets can be attached elsewhere
        // if ($attribute_set->products()->exists()) {
        //     return response()->json(['message' => 'Set is in use'], 409);
        // }

        DB::transaction(function () use ($attribute_set): void {
            // If FK is not ON DELETE CASCADE:
            $attribute_set->items()->delete();
            $attribute_set->delete();
        });

        return response()->json(['ok' => true]);
    }
}

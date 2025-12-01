<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Log;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * 🧱 Product Create Page
     */
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        $bootstrap = ['primaryCategory' => null];

        return view('admin.product.create_product.index', [
            'brands' => $brands,
            'PRODUCT_BOOTSTRAP' => $bootstrap,
        ]);
    }

    /**
     * 📦 All Products (for DataTables & Blade)
     */
    public function allProducts(Request $request)
    {
        // Base Query (with joins)
        $query = DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('product_category_map as pcm', function ($join) {
                $join->on('products.id', '=', 'pcm.product_id')
                    ->where('pcm.is_primary', true);
            })
            ->leftJoin('product_categories as pc', 'pcm.category_id', '=', 'pc.id')
            ->leftJoin(DB::raw('(SELECT product_id, COUNT(*) as images_count FROM product_images GROUP BY product_id) as img'), 'products.id', '=', 'img.product_id')
            ->leftJoin(DB::raw('(SELECT product_id, COUNT(*) as variants_count FROM product_variants GROUP BY product_id) as var'), 'products.id', '=', 'var.product_id')
            ->select(
                'products.id',
                'products.title',
                'brands.name as brand_name',
                'pc.name as category_name',
                'products.status',
                'products.created_at',
                DB::raw('COALESCE(img.images_count, 0) as images_count'),
                DB::raw('COALESCE(var.variants_count, 0) as variants_count')
            )
            ->orderBy('products.created_at', 'desc');

        // If AJAX request → return DataTable JSON
        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked = $row->status === 'active' ? 'checked' : '';
                    return '
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold">'.ucfirst($row->status).'</span>
                            <label class="product-toggle-switch">
                                <input type="checkbox" class="toggle-status" data-product-id="'.$row->id.'" '.$checked.'>
                                <span class="product-slider"></span>
                            </label>
                        </div>';
                })
                ->addColumn('images', function ($row) {
                    return '<button class="btn btn-sm btn-outline-primary btn-view-images" data-product-id="'.$row->id.'">'
                        .$row->images_count.' Images</button>';
                })
                ->addColumn('variants', function ($row) {
                    return '<button class="btn btn-sm btn-outline-secondary btn-view-variants" data-product-id="'.$row->id.'">'
                        .$row->variants_count.' Variants</button>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group">
                            <a href="#" class="btn btn-sm btn-primary editProduct" data-id="'.$row->id.'">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger deleteProduct" data-id="'.$row->id.'">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>';
                })
                ->rawColumns(['status', 'images', 'variants', 'action'])
                ->make(true);
        }

        // Otherwise → send to Blade for @forelse
        $products = $query->get();
        return view('admin.product.all_products.index', compact('products'));
    }

    /**
     * 🔍 Resolve category id from path
     */
    private function resolveCategoryIdFromPath(string $path): ?int
    {
        $segments = array_filter(array_map('trim', explode('/', $path)));
        if (empty($segments)) return null;

        $parentId = null;
        foreach ($segments as $seg) {
            $name = str_replace('-', ' ', $seg);
            $row = DB::table('product_categories')
                ->when(
                    is_null($parentId),
                    fn($q) => $q->whereNull('parent_id'),
                    fn($q) => $q->where('parent_id', $parentId)
                )
                ->whereRaw('LOWER(name) = ?', [Str::lower($name)])
                ->select('id')
                ->first();

            if (!$row) return null;
            $parentId = $row->id;
        }
        return $parentId;
    }

    /**
     * 🧾 Store Product
     */
    public function store(Request $request)
    {
        $payload = json_decode($request->input('data', '{}'), true);
        Log::info($payload);

        return DB::transaction(function () use ($request, $payload) {
            $slug = $payload['slug'] ?? Str::slug($payload['title'] ?? (string) Str::uuid());
            $productId = DB::table('products')->insertGetId([
                'brand_id' => $payload['brand_id'] ?? null,
                'attribute_set_id' => $payload['attribute_set_id'] ?? null,
                'variant_rule_id' => $payload['variant_rule_id'] ?? null,
                'title' => $payload['title'] ?? '',
                'slug' => $slug,
                'short_desc' => $payload['short_desc'] ?? null,
                'status' => $payload['status'] ?? 'Draft',
                'featured' => (bool) ($payload['featured'] ?? false),
                'allow_backorder' => (bool) ($payload['allow_backorder'] ?? false),
                'variant_wise_image' => (bool) ($payload['variant_wise_image'] ?? false),
                'seo_title' => $payload['seo']['title'] ?? null,
                'seo_desc' => $payload['seo']['desc'] ?? null,
                'seo_keys' => $payload['seo']['keys'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔗 Category mapping
            $catPaths = $payload['categories'] ?? [];
            $primaryPath = $payload['primary_category'] ?? null;

            $catIds = [];
            foreach ($catPaths as $p) {
                if (is_numeric($p)) {
                    $catIds[] = (int) $p;
                    continue;
                }
                if ($id = $this->resolveCategoryIdFromPath((string) $p))
                    $catIds[] = $id;
            }
            $catIds = array_values(array_unique($catIds));

            $primaryId = null;
            if ($primaryPath) {
                $primaryId = is_numeric($primaryPath)
                    ? (int) $primaryPath
                    : $this->resolveCategoryIdFromPath((string) $primaryPath);
            }
            if ($primaryId && !in_array($primaryId, $catIds, true))
                $catIds[] = $primaryId;

            foreach ($catIds as $cid) {
                DB::table('product_category_map')->insert([
                    'product_id' => $productId,
                    'category_id' => $cid,
                    'is_primary' => ($primaryId === $cid),
                ]);
            }

            // 🖼️ Gallery Images
            $galleryFiles = $request->file('gallery');
            $galleryFiles = is_array($galleryFiles) ? $galleryFiles : ($galleryFiles ? [$galleryFiles] : []);
            $coverIdx = (int) $request->input('gallery_cover_index', 0);
            $sort = 0;

            foreach ($galleryFiles as $idx => $file) {
                if (!($file instanceof \Illuminate\Http\UploadedFile) || !$file->isValid()) continue;
                $path = $file->store('product/images', 'public');
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'path' => $path,
                    'is_cover' => (int) ((string) $idx === (string) $coverIdx),
                    'sort_order' => $sort++,
                ]);
            }

            // ⚙️ Attributes
            foreach (($payload['attributes'] ?? []) as $row) {
                $aid = $row['attribute_id'] ?? null;
                foreach (($row['term_ids'] ?? []) as $tid) {
                    if ($aid && $tid) {
                        DB::table('product_attribute_terms')->insert([
                            'product_id' => $productId,
                            'attribute_id' => (int) $aid,
                            'term_id' => (int) $tid,
                        ]);
                    }
                }
            }

            // 🧩 Variants
            $wantImages = (bool) ($payload['variant_wise_image'] ?? false);
            $files = $request->file('variant_images', []);
            $variants = $payload['variants'] ?? [];

            foreach ($variants as $i => $v) {
                $pairs = array_map(
                    fn($o) => [(int) ($o['attribute_id'] ?? $o[0]), (int) ($o['term_id'] ?? $o[1])],
                    $v['options'] ?? ($v['map'] ?? [])
                );
                usort($pairs, fn($a, $b) => $a[0] <=> $b[0]);
                $combo = implode('|', array_map(fn($p) => "{$p[0]}:{$p[1]}", $pairs));

                $variantId = DB::table('product_variants')->insertGetId([
                    'product_id' => $productId,
                    'sku' => $v['sku'] ?? Str::upper(Str::random(8)),
                    'combination_key' => $combo,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($pairs as [$attrId, $termId]) {
                    DB::table('product_variant_options')->insert([
                        'variant_id' => $variantId,
                        'attribute_id' => $attrId,
                        'term_id' => $termId,
                    ]);
                }

                if ($wantImages && isset($files[$i]) && $files[$i] && $files[$i]->isValid()) {
                    $path = $files[$i]->store('product/variants', 'public');
                    DB::table('product_variant_images')->insert([
                        'variant_id' => $variantId,
                        'path' => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return response()->json(['ok' => true, 'product_id' => $productId], 201);
        });
    }

    /**
     * 🔄 Update Product Active/Inactive
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        if (is_null($status)) {
            $data = $request->json()->all();
            $status = $data['status'] ?? null;
        }

        if (!in_array($status, ['active', 'inactive'])) {
            return response()->json(['ok' => false, 'message' => 'Invalid status.'], 400);
        }

        try {
            DB::table('products')
                ->where('id', $id)
                ->update(['status' => $status, 'updated_at' => now()]);

            return response()->json([
                'ok' => true,
                'status' => $status,
                'message' => "Product status updated to '{$status}' successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error("Update product status error (ID: {$id}): " . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    /**
     * 🗑️ Delete Product
     */
    public function destroy($id)
    {
        try {
            DB::table('products')->where('id', $id)->delete();
            DB::table('product_category_map')->where('product_id', $id)->delete();
            DB::table('product_attribute_terms')->where('product_id', $id)->delete();
            DB::table('product_images')->where('product_id', $id)->delete();
            DB::table('product_variants')->where('product_id', $id)->delete();

            return redirect()->back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Delete product error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete product.');
        }
    }

    /**
     * 🖼️ Fetch Product Images (for modal)
     */
    public function getImages($id)
    {
        $images = DB::table('product_images')
            ->where('product_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get(['path']);

        if ($images->isEmpty()) {
            return response()->json(['images' => []]);
        }

        $formatted = $images->map(fn($img) => [
            'url' => asset('storage/' . $img->path)
        ]);

        return response()->json(['images' => $formatted]);
    }

    /**
     * 🧩 Fetch Product Variants (for modal)
     */
    // public function getVariants($id)
    // {
    //     $variants = DB::table('product_variants')
    //         ->where('product_id', $id)
    //         ->get(['id', 'sku', 'combination_key', 'active', 'created_at']);

    //     if ($variants->isEmpty()) {
    //         return response()->json(['variants' => []]);
    //     }
    //     $formatted = $variants->map(fn($v) => [
    //         'name' => $v->combination_key,
    //         'sku' => $v->sku,
    //         'price' => null,
    //         'stock' => null,
    //     ]);

    //     return response()->json(['variants' => $formatted]);
    // }

    public function getVariants($id)
    {
        $variants = \App\Models\ProductVariant::with(['options.attribute', 'options.term'])
            ->where('product_id', $id)
            ->get();

        $formatted = $variants->map(function ($variant) {
            $combination = $variant->options->map(function ($opt) {
                return "{$opt->attribute->name}: {$opt->term->name}";
            })->join(' | ');

            return [
                'name' => $combination ?: 'Default',
                'sku' => $variant->sku,
                // 'price' => $variant->price ?? null,
                // 'stock' => $variant->stock ?? null,
            ];
        });

        return response()->json(['variants' => $formatted]);
    }


}




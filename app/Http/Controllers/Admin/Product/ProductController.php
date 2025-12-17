<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * 🧱 Product Create Page
     */
    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        $bootstrap = ['primaryCategory' => null];

        return view('admin.product.create_product.index', [
            'brands' => $brands,
            'PRODUCT_BOOTSTRAP' => $bootstrap,
            'product' => null,
            'productImages' => [],
            'productVariants' => [],
            'isEdit' => false,
        ]);
    }

    /**
     * ✏️ Product Edit Page
     */
    public function edit($id)
    {
        $brands = Brand::orderBy('name')->get();
        $bootstrap = ['primaryCategory' => null];

        // Get product with brand
        $product = DB::table('products')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('product_category_map as pcm', function ($join) {
                $join->on('products.id', '=', 'pcm.product_id')
                    ->where('pcm.is_primary', true);
            })
            ->leftJoin('product_categories as pc', 'pcm.category_id', '=', 'pc.id')
            ->where('products.id', $id)
            ->select(
                'products.*',
                'brands.name as brand_name',
                'pc.name as category_name',
                'pc.id as category_id'
            )
            ->first();

        if (!$product) {
            return redirect()->route('admin.product.all')->with('error', 'Product not found');
        }

        // Get product images
        $productImages = DB::table('product_images')
            ->where('product_id', $id)
            ->orderByDesc('is_cover')
            ->orderBy('sort_order')
            ->get();

        // Get product variants
        $productVariants = DB::table('product_variants')
            ->where('product_id', $id)
            ->get();

        $assignedCats = DB::table('product_category_map as pcm')
            ->join('product_categories as pc', 'pcm.category_id', '=', 'pc.id')
            ->where('pcm.product_id', $id)
            ->pluck('pc.slug')
            ->toArray();

        // Fix primary category logic to always return slug if available, else null
        $primaryCatSlug = null;
        if ($product->category_id) {
            $primaryCatSlug = DB::table('product_categories')
                ->where('id', $product->category_id)
                ->value('slug');
        }
        
        $bootstrap['primaryCategory'] = $primaryCatSlug;
        $bootstrap['assignedCategories'] = $assignedCats;

        return view('admin.product.create_product.index', [
            'brands' => $brands,
            'PRODUCT_BOOTSTRAP' => $bootstrap,
            'product' => $product,
            'productImages' => $productImages,
            'productVariants' => $productVariants,
            'isEdit' => true,
        ]);
    }

    /**
     * 🔄 Update Product
     */
    public function update(Request $request, $id)
    {
        // Check if product exists
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Update logic will be handled by the existing store method
        // For now, redirect to the store method with product ID
        $request->merge(['product_id' => $id]);
        return $this->store($request);
    }

    /**
     * 📦 All Products (for DataTables & Blade)
     */
    public function allProducts(Request $request)
    {
        Log::info('Entered allProducts. Ajax: ' . ($request->ajax() ? 'yes' : 'no') . ', Draw: ' . ($request->has('draw') ? 'yes' : 'no'));

        // Base Query (with joins)
        $query = DB::table('products')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('product_category_map as pcm', function ($join) {
                $join->on('products.id', '=', 'pcm.product_id')
                    ->where('pcm.is_primary', true);
            })
            ->leftJoin('product_categories as pc', 'pcm.category_id', '=', 'pc.id')
            ->whereNull('products.deleted_at')
            ->select(
                'products.id',
                'products.title',
                'products.sku',
                'brands.name as brand_name',
                'pc.name as category_name',
                'products.status',
                'products.created_at'
            )
            ->orderBy('products.created_at', 'desc');

        // Check if it's an AJAX request (DataTables Server-Side)
        if ($request->ajax() || $request->wantsJson() || $request->has('draw')) {
            try {
                // Log the count for debugging
                $count = $query->count();
                Log::info('DataTables Query Count: ' . $count);

                $dt = DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('product_info', function ($row) {
                        // Get cover image
                        $coverImg = DB::table('product_images')
                            ->where('product_id', $row->id)
                            ->where('is_cover', 1)
                            ->first();

                        $coverImg = $coverImg ?: DB::table('product_images')
                            ->where('product_id', $row->id)
                            ->first();

                        $title = e($row->title); // Escape title
                        $sku = e($row->sku ?? 'N/A');

                        $imageHtml = $coverImg && $coverImg->path ?
                            '<img src="' . asset('storage/' . $coverImg->path) . '" alt="' . $title . '" class="product-thumb">' :
                            '<div class="product-thumb-placeholder"><i class="fas fa-image"></i></div>';

                        return '
                            <div class="product-info">
                                ' . $imageHtml . '
                                <div>
                                    <div class="product-name" title="' . $title . '">' . $title . '</div>
                                    <div class="product-sku">SKU: ' . $sku . '</div>
                                </div>
                            </div>';
                    })
                    ->addColumn('brand_name', function($row) {
                        return e($row->brand_name ?? 'No Brand');
                    })
                    ->addColumn('category_name', function($row) {
                        return e($row->category_name ?? 'No Category');
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->status === 'Active' ? 'checked' : '';
                        return '
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                    data-id="' . $row->id . '" ' . $checked . '>
                            </div>';
                    })
                    ->addColumn('media', function ($row) {
                        // Recalculate counts per row (less efficient but safer for now)
                        $imagesCount = DB::table('product_images')->where('product_id', $row->id)->count();
                        $variantsCount = DB::table('product_variants')->where('product_id', $row->id)->count();
                        
                        $imagesBtn = '<button class="info-badge info-badge-images btn-view-images" data-product-id="' . $row->id . '"><i class="fas fa-images me-1"></i>' . $imagesCount . '</button>';
                        $variantsBtn = '<button class="info-badge info-badge-variants btn-view-variants" data-product-id="' . $row->id . '"><i class="fas fa-layer-group me-1"></i>' . $variantsCount . '</button>';
                        return '<div class="d-flex gap-2">' . $imagesBtn . ' ' . $variantsBtn . '</div>';
                    })
                    ->addColumn('action', function ($row) {
                        return '
                            <div class="btn-group">
                                <a href="' . route('admin.product.edit', $row->id) . '" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-danger deleteProduct" data-id="' . $row->id . '">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>';
                    })
                    ->rawColumns(['product_info', 'status', 'media', 'action']);

                $json = $dt->make(true);
                // Log::info('DataTables Response: ' . substr($json->content(), 0, 1000)); // Log first 1000 chars
                return $json;
            } catch (\Exception $e) {
                Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500);
            }
        }

        // Normal View Load - Fetch data for Client-Side rendering fallback
        $products = $query->get();
        
        // Enhance products with extra data needed for view
        foreach ($products as $row) {
            // Cover Image
            $coverImg = DB::table('product_images')->where('product_id', $row->id)->where('is_cover', 1)->first();
            $coverImg = $coverImg ?: DB::table('product_images')->where('product_id', $row->id)->first();
            $row->cover_image_url = $coverImg && $coverImg->path ? asset('storage/' . $coverImg->path) : null;
            
            // Counts
            $row->images_count = DB::table('product_images')->where('product_id', $row->id)->count();
            $row->variants_count = DB::table('product_variants')->where('product_id', $row->id)->count();
        }

        // Calculate stats for the view
        $totalProducts = DB::table('products')->whereNull('deleted_at')->count();
        $activeProducts = DB::table('products')->whereNull('deleted_at')->where('status', 'Active')->count();
        $inactiveProducts = DB::table('products')->whereNull('deleted_at')->where('status', '!=', 'Active')->count();

        return view('admin.product.all_products.index', compact('totalProducts', 'activeProducts', 'inactiveProducts', 'products'));
    }

    /**
     * 🔍 Resolve category id from path
     */
    private function resolveCategoryIdFromPath(string $path): ?int
    {
        $segments = array_filter(array_map('trim', explode('/', $path)));
        if (empty($segments))
            return null;

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

            if (!$row)
                return null;
            $parentId = $row->id;
        }
        return $parentId;
    }

    /**
     * 🧾 Store/Update Product
     */
    public function store(Request $request)
    {
        $payload = json_decode($request->input('data', '{}'), true);
        Log::info($payload);

        // Check if this is an update (product_id provided)
        $existingProductId = $payload['product_id'] ?? $request->input('product_id') ?? null;
        $isUpdate = !empty($existingProductId);

        return DB::transaction(function () use ($request, $payload, $existingProductId, $isUpdate) {
            $slug = $payload['slug'] ?? Str::slug($payload['title'] ?? (string) Str::uuid());

            $productData = [
                'brand_id' => $payload['brand_id'] ?? null,
                'attribute_set_id' => $payload['attribute_set_id'] ?? null,
                'variant_rule_id' => $payload['variant_rule_id'] ?? null,
                'title' => $payload['title'] ?? '',
                'slug' => $slug,
                'sku' => $payload['sku'] ?? null,
                'short_desc' => $payload['short_desc'] ?? null,
                'price' => $payload['price'] ?? 0,
                'sale_price' => $payload['sale_price'] ?? null,
                'stock_quantity' => $payload['stock_quantity'] ?? 0,
                'status' => $payload['status'] ?? 'Draft',
                'featured' => (bool) ($payload['featured'] ?? false),
                'allow_backorder' => (bool) ($payload['allow_backorder'] ?? false),
                'variant_wise_image' => (bool) ($payload['variant_wise_image'] ?? false),
                'seo_title' => $payload['seo']['title'] ?? null,
                'seo_desc' => $payload['seo']['desc'] ?? null,
                'seo_keys' => $payload['seo']['keys'] ?? null,
                'updated_at' => now(),
            ];

            if ($isUpdate) {
                // Update existing product
                DB::table('products')->where('id', $existingProductId)->update($productData);
                $productId = $existingProductId;

                // Clear existing category mappings for update
                DB::table('product_category_map')->where('product_id', $productId)->delete();

                // Clear existing attributes for update
                DB::table('product_attribute_terms')->where('product_id', $productId)->delete();

                // Clear existing variants for update (optional - you may want to keep them)
                // DB::table('product_variant_options')->whereIn('variant_id', 
                //     DB::table('product_variants')->where('product_id', $productId)->pluck('id')
                // )->delete();
                // DB::table('product_variants')->where('product_id', $productId)->delete();
            } else {
                // Create new product
                $productData['created_at'] = now();
                $productId = DB::table('products')->insertGetId($productData);
            }

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

            // 🗑️ Delete Removed Images
            $deletedImages = $payload['deleted_images'] ?? [];
            if (!empty($deletedImages)) {
                $imgsToDelete = DB::table('product_images')->whereIn('id', $deletedImages)->get();
                foreach ($imgsToDelete as $img) {
                    if ($img->path && \Illuminate\Support\Facades\Storage::disk('public')->exists($img->path)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($img->path);
                    }
                }
                DB::table('product_images')->whereIn('id', $deletedImages)->delete();
            }

            // 🖼️ Gallery Images
            $galleryFiles = $request->file('gallery');
            $galleryFiles = is_array($galleryFiles) ? $galleryFiles : ($galleryFiles ? [$galleryFiles] : []);
            $coverIdx = (int) $request->input('gallery_cover_index', 0);

            // Only process images if new files are uploaded
            if (count($galleryFiles) > 0) {
                // Get current max sort order for existing images
                $maxSort = DB::table('product_images')
                    ->where('product_id', $productId)
                    ->max('sort_order') ?? -1;
                $sort = $maxSort + 1;

                foreach ($galleryFiles as $idx => $file) {
                    if (!($file instanceof \Illuminate\Http\UploadedFile) || !$file->isValid())
                        continue;
                    $path = $file->store('product/images', 'public');
                    DB::table('product_images')->insert([
                        'product_id' => $productId,
                        'path' => $path,
                        'is_cover' => (!$isUpdate && (string) $idx === (string) $coverIdx) ? 1 : 0,
                        'sort_order' => $sort++,
                    ]);
                }
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

            return response()->json([
                'ok' => true,
                'product_id' => $productId,
                'message' => $isUpdate ? 'Product updated successfully!' : 'Product created successfully!',
                'is_update' => $isUpdate
            ], $isUpdate ? 200 : 201);
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

        // UI sends "active" / "inactive"; DB enum is "Active" / "Draft" / "Archived"
        if (!in_array($status, ['active', 'inactive'], true)) {
            return response()->json(['ok' => false, 'message' => 'Invalid status.'], 400);
        }

        // Map UI status to DB enum value
        $dbStatus = $status === 'active' ? 'Active' : 'Inactive';

        try {
            DB::table('products')
                ->where('id', $id)
                ->update(['status' => $dbStatus, 'updated_at' => now()]);

            return response()->json([
                'ok' => true,
                'status' => $dbStatus,
                'message' => "Product status updated to '{$dbStatus}' successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error("Update product status error (ID: {$id}): " . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    /**
     * 🗑️ Delete Product
     */
    public function destroy(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }
            $product->delete(); // Soft delete

            return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
        } catch (\Exception $e) {
            Log::error('Delete product error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete product.'], 500);
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

    /**
     * 📋 Get Product Details (for modal)
     */
    public function getProductDetails($id)
    {
        // Fetch product with brand
        $product = DB::table('products')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('product_category_map as pcm', function ($join) {
                $join->on('products.id', '=', 'pcm.product_id')
                    ->where('pcm.is_primary', true);
            })
            ->leftJoin('product_categories as pc', 'pcm.category_id', '=', 'pc.id')
            ->where('products.id', $id)
            ->select(
                'products.*',
                'brands.name as brand_name',
                'pc.name as category_name'
            )
            ->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Fetch images
        $images = DB::table('product_images')
            ->where('product_id', $id)
            ->orderByDesc('is_cover')
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'path', 'is_cover'])
            ->map(fn($img) => [
                'id' => $img->id,
                'url' => asset('storage/' . $img->path),
                'is_cover' => $img->is_cover,
            ]);

        // Fetch variants with options
        $variants = \App\Models\ProductVariant::with(['options.attribute', 'options.term'])
            ->where('product_id', $id)
            ->get()
            ->map(function ($variant) {
                $combination = $variant->options->map(function ($opt) {
                    return "{$opt->attribute->name}: {$opt->term->name}";
                })->join(' | ');

                return [
                    'id' => $variant->id,
                    'name' => $combination ?: 'Default',
                    'sku' => $variant->sku,
                    'price' => $variant->price ?? null,
                    'stock' => $variant->stock ?? null,
                ];
            });

        return response()->json([
            'success' => true,
            'product' => $product,
            'images' => $images,
            'variants' => $variants,
        ]);
    }
}




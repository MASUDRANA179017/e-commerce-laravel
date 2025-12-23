<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin\Brand\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
     * � All Products Data (JSON for DataTables)
     */
    public function allProductsData(Request $request)
    {
        Log::info('Entered allProductsData (Dedicated JSON Route)');
        
        try {
            $query = Product::with(['brand'])
                ->withCount(['images', 'variants'])
                ->with(['categories' => function($q) {
                    $q->wherePivot('is_primary', true);
                }])
                ->select('products.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('product_info', function ($row) {
                    $coverImg = $row->images->sortByDesc('is_cover')->first(); 
                    $title = e($row->title);
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
                    return $row->brand ? e($row->brand->name) : 'No Brand';
                })
                ->addColumn('category_name', function($row) {
                    $primaryCat = $row->categories->first();
                    return $primaryCat ? e($primaryCat->name) : 'No Category';
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
                    $imagesCount = $row->images_count;
                    $variantsCount = $row->variants_count;
                    
                    $imagesBtn = '<button class="info-badge info-badge-images btn-view-images" data-product-id="' . $row->id . '"><i class="fas fa-images me-1"></i>' . $imagesCount . '</button>';
                    $variantsBtn = '<button class="info-badge info-badge-variants btn-view-variants" data-product-id="' . $row->id . '"><i class="fas fa-layer-group me-1"></i>' . $variantsCount . '</button>';
                    return '<div class="d-flex gap-2">' . $imagesBtn . ' ' . $variantsBtn . '</div>';
                })
                ->addColumn('action', function ($row) {
                        return '
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info btn-view-product" data-product-id="' . $row->id . '" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="' . route('admin.product.edit', $row->id) . '" class="btn btn-sm btn-primary" title="Edit Product">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger deleteProduct" data-id="' . $row->id . '" title="Delete Product">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>';
                    })
                ->rawColumns(['product_info', 'status', 'media', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('DataTables Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 📦 All Products (View Only)
     */
    public function allProducts(Request $request)
    {
        Log::info('Entered allProducts (View)');

        // Calculate stats using Eloquent
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'Active')->count();
        $inactiveProducts = Product::where('status', '!=', 'Active')->count();

        return view('admin.product.all_products.index', compact('totalProducts', 'activeProducts', 'inactiveProducts'));
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
        try {
            $payload = json_decode($request->input('data', '{}'), true);
            Log::info($payload);

            // Check if this is an update (product_id provided)
            $existingProductId = $payload['product_id'] ?? $request->input('product_id') ?? null;
            $isUpdate = !empty($existingProductId);

            return DB::transaction(function () use ($request, $payload, $existingProductId, $isUpdate) {
                $slug = $payload['slug'] ?? Str::slug($payload['title'] ?? (string) Str::uuid());
                
                // Ensure unique slug
                $originalSlug = $slug;
                $counter = 1;
                while (DB::table('products')->where('slug', $slug)->when($existingProductId, function($q) use ($existingProductId) {
                    return $q->where('id', '!=', $existingProductId);
                })->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                // Normalize status to DB enum values
                $inStatus = $payload['status'] ?? 'Draft';
                $dbStatus = match (strtolower((string) $inStatus)) {
                    'active'   => 'Active',
                    'draft'    => 'Draft',
                    'archived' => 'Archived',
                    default    => ($inStatus ?: 'Draft'),
                };

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
                    'status' => $dbStatus,
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

                    // Clear existing variants for update
                    DB::table('product_variant_options')->whereIn('variant_id', 
                        DB::table('product_variants')->where('product_id', $productId)->pluck('id')
                    )->delete();
                    DB::table('product_variants')->where('product_id', $productId)->delete();
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

                $usedSkus = [];
                foreach ($variants as $i => $v) {
                    $pairs = array_map(
                        fn($o) => [(int) ($o['attribute_id'] ?? $o[0]), (int) ($o['term_id'] ?? $o[1])],
                        $v['options'] ?? ($v['map'] ?? [])
                    );
                    if (empty($pairs)) {
                        continue;
                    }
                    usort($pairs, fn($a, $b) => $a[0] <=> $b[0]);
                    $combo = implode('|', array_map(fn($p) => "{$p[0]}:{$p[1]}", $pairs));

                    $sku = trim($v['sku'] ?? '');
                    if ($sku === '') {
                        $sku = Str::upper(Str::random(8));
                    }
                    $baseSku = $sku;
                    $suffix = 1;
                    while (isset($usedSkus[$sku]) || DB::table('product_variants')->where('sku', $sku)->exists()) {
                        $sku = $baseSku . '-' . $suffix++;
                        if ($suffix > 100) break;
                    }
                    $usedSkus[$sku] = true;

                    $variantId = DB::table('product_variants')->insertGetId([
                        'product_id' => $productId,
                        'sku' => $sku,
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
                        if (Schema::hasTable('product_variant_images')) {
                            DB::table('product_variant_images')->insert([
                                'variant_id' => $variantId,
                                'path' => $path,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }

                return response()->json([
                    'ok' => true,
                    'product_id' => $productId,
                    'message' => $isUpdate ? 'Product updated successfully!' : 'Product created successfully!',
                    'is_update' => $isUpdate
                ], $isUpdate ? 200 : 201);
            });
        } catch (\Exception $e) {
            Log::error('Store product error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'ok' => false,
                'message' => 'Failed to save product: ' . $e->getMessage()
            ], 500);
        }
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
        $dbStatus = $status === 'active' ? 'Active' : 'Draft';

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

        $imageUrls = $images->map(function ($img) {
            return asset('storage/' . $img->path);
        });

        return response()->json($imageUrls);
    }

    /**
     * 🗑️ Delete Product Image
     */
    public function deleteImage($id)
    {
        try {
            $image = DB::table('product_images')->where('id', $id)->first();
            
            if (!$image) {
                return response()->json(['success' => false, 'message' => 'Image not found'], 404);
            }

            // Delete file from storage
            if ($image->path && \Illuminate\Support\Facades\Storage::disk('public')->exists($image->path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->path);
            }

            // Delete record from DB
            DB::table('product_images')->where('id', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete image error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete image'], 500);
        }
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




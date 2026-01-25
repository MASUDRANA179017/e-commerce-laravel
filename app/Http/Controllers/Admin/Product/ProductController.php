<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin\Brand\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Picqer\Barcode\BarcodeGeneratorPNG;

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

        // Get product attribute terms map for preselection on edit
        $productAttrRows = DB::table('product_attribute_terms')
            ->where('product_id', $id)
            ->get(['attribute_id', 'term_id']);
        $productAttrMap = [];
        foreach ($productAttrRows as $row) {
            $aid = (string) $row->attribute_id;
            $tid = (string) $row->term_id;
            if (!isset($productAttrMap[$aid])) $productAttrMap[$aid] = [];
            $productAttrMap[$aid][] = $tid;
        }

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
            'productAttrMap' => $productAttrMap,
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
                ->with(['categories' => function ($q) {
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
                        '';

                    return '
                        <div class="product-info">
                            ' . $imageHtml . '
                            <div>
                                <div class="product-name" title="' . $title . '">' . $title . '</div>
                                <div class="product-sku">SKU: ' . $sku . '</div>
                            </div>
                        </div>';
                })
                ->addColumn('brand_name', function ($row) {
                    return $row->brand ? e($row->brand->name) : 'No Brand';
                })
                ->addColumn('category_name', function ($row) {
                    $primaryCat = $row->categories->first();
                    return $primaryCat ? e($primaryCat->name) : 'No Category';
                })
                ->addColumn('price', function ($row) {
                    $currency = '৳';
                    $variants = $row->variants ?? collect();
                    if ($variants && $variants->count() > 0) {
                        $prices = [];
                        foreach ($variants as $v) {
                            $latestSell = \Illuminate\Support\Facades\DB::table('purchase_items')
                                ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                                ->where('purchase_items.variant_id', $v->id)
                                ->where('purchases.status', 'received')
                                ->orderByDesc('purchases.purchase_date')
                                ->value('purchase_items.sell_price');
                            if ($latestSell !== null && (float) $latestSell > 0) {
                                $prices[] = (float) $latestSell;
                            }
                        }
                        if (!empty($prices)) {
                            $min = min($prices);
                            $max = max($prices);
                            if ($min === $max) {
                                return '<span class="fw-semibold">' . $currency . number_format($min, 2) . '</span>';
                            }
                            return '<span class="fw-semibold">' . $currency . number_format($min, 2) . ' - ' . $currency . number_format($max, 2) . '</span>';
                        }
                    } else {
                        $range = \Illuminate\Support\Facades\DB::table('purchase_items')
                            ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                            ->where('purchase_items.product_id', $row->id)
                            ->whereNull('purchase_items.variant_id')
                            ->where('purchases.status', 'received')
                            ->selectRaw('MIN(purchase_items.sell_price) AS min_price, MAX(purchase_items.sell_price) AS max_price')
                            ->first();
                        if ($range && ((float) $range->min_price > 0 || (float) $range->max_price > 0)) {
                            $min = (float) $range->min_price;
                            $max = (float) $range->max_price;
                            if ($min === $max) {
                                return '<span class="fw-semibold">' . $currency . number_format($min, 2) . '</span>';
                            }
                            return '<span class="fw-semibold">' . $currency . number_format($min, 2) . ' - ' . $currency . number_format($max, 2) . '</span>';
                        }
                    }
                    return '<span class="text-muted">-</span>';
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
                ->addColumn('action', function ($row) use ($request) {
                    if ($request->has('barcode_mode')) {
                        return '
                            <a href="' . route('admin.product.barcode', $row->id) . '" class="btn btn-sm btn-secondary" title="Generate Barcode">
                                <i class="fas fa-barcode me-1"></i> Generate
                            </a>';
                    }
                    return '
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info btn-view-product" data-product-id="' . $row->id . '" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="' . route('admin.product.edit', $row->id) . '" class="btn btn-sm btn-primary" title="Edit Product">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="' . route('admin.product.barcode', $row->id) . '" class="btn btn-sm btn-secondary" title="Barcode">
                                <i class="fas fa-barcode"></i>
                            </a>
                            <a href="' . route('admin.product.notification', $row->id) . '" class="btn btn-sm btn-warning" title="Notification">
                                <i class="fas fa-bell"></i>
                            </a>
                            <button class="btn btn-sm btn-danger deleteProduct" data-id="' . $row->id . '" title="Delete Product">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
                })
                ->rawColumns(['product_info', 'price', 'status', 'media', 'action'])
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
        $activeProducts = Product::where(function ($q) {
            $q->where('status', 'Active')->orWhereRaw('LOWER(status) = ?', ['active']);
        })->count();
        $inactiveProducts = $totalProducts - $activeProducts;

        return view('admin.product.all_products.index', compact('totalProducts', 'activeProducts', 'inactiveProducts'));
    }

    public function stats()
    {
        $total = Product::count();
        $active = Product::where(function ($q) {
            $q->where('status', 'Active')->orWhereRaw('LOWER(status) = ?', ['active']);
        })->count();
        $inactive = $total - $active;
        return response()->json(['success' => true, 'total' => $total, 'active' => $active, 'inactive' => $inactive]);
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
                while (DB::table('products')->where('slug', $slug)->when($existingProductId, function ($q) use ($existingProductId) {
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
                    'sku' => $payload['sku'] ?? 'SKU-' . strtoupper(Str::random(8)),
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

                    // Note: Categories are cleared only if new categories are provided (see below)

                    // Clear existing attributes for update ONLY if attributes are provided
                    if (isset($payload['attributes'])) {
                        DB::table('product_attribute_terms')->where('product_id', $productId)->delete();
                    }

                    // Clear existing variants for update ONLY if variants are provided
                    if (isset($payload['variants'])) {
                        DB::table('product_variant_options')->whereIn(
                            'variant_id',
                            DB::table('product_variants')->where('product_id', $productId)->pluck('id')
                        )->delete();
                        DB::table('product_variants')->where('product_id', $productId)->delete();
                    }
                } else {
                    // Create new product
                    $productData['created_at'] = now();
                    $productId = DB::table('products')->insertGetId($productData);
                }

                // 🔗 Category mapping
                if (isset($payload['categories']) || isset($payload['primary_category'])) {
                    // Only clear existing mappings if we are updating categories
                    if ($isUpdate) {
                        DB::table('product_category_map')->where('product_id', $productId)->delete();
                    }

                    $catPaths = $payload['categories'] ?? [];
                    $primaryPath = $payload['primary_category'] ?? null;

                    $catIds = [];
                    foreach ($catPaths as $p) {
                        if (is_numeric($p)) {
                            $catIds[] = (int) $p;
                            continue;
                        }
                        // Try path resolution
                        if ($id = $this->resolveCategoryIdFromPath((string) $p)) {
                            $catIds[] = $id;
                            continue;
                        }
                        // Try slug resolution
                        $slugId = DB::table('product_categories')->where('slug', $p)->value('id');
                        if ($slugId) {
                            $catIds[] = $slugId;
                        }
                    }
                    $catIds = array_values(array_unique($catIds));

                    $primaryId = null;
                    if ($primaryPath) {
                        if (is_numeric($primaryPath)) {
                            $primaryId = (int) $primaryPath;
                        } else {
                            $primaryId = $this->resolveCategoryIdFromPath((string) $primaryPath);
                            if (!$primaryId) {
                                $primaryId = DB::table('product_categories')->where('slug', $primaryPath)->value('id');
                            }
                        }
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
                }

                // 🗑️ Delete Removed Images
                $deletedImages = $payload['deleted_images'] ?? [];
                if (!empty($deletedImages)) {
                    $imgsToDelete = DB::table('product_images')->whereIn('id', $deletedImages)->get();
                    foreach ($imgsToDelete as $img) {
                        if ($img->path && Storage::disk('public')->exists($img->path)) {
                            Storage::disk('public')->delete($img->path);
                        }
                    }
                    DB::table('product_images')->whereIn('id', $deletedImages)->delete();
                }

                // 🖼️ Gallery Images
                $galleryFiles = $request->file('gallery');
                $galleryFiles = is_array($galleryFiles) ? $galleryFiles : ($galleryFiles ? [$galleryFiles] : []);
                $coverIdx = (int) $request->input('gallery_cover_index', 0);
                
                // Filter out invalid files FIRST
                $validFiles = [];
                foreach ($galleryFiles as $idx => $file) {
                    if (!($file instanceof \Illuminate\Http\UploadedFile)) {
                        continue;
                    }
                    
                    if (!$file->isValid()) {
                        Log::warning('File ' . $idx . ' failed validation: ' . $file->getErrorMessage());
                        continue;
                    }
                    
                    $filePath = $file->getPathname();
                    if (empty($filePath)) {
                        Log::warning('File ' . $idx . ' has empty path');
                        continue;
                    }
                    
                    $validFiles[] = $file;
                }
                
                $galleryFiles = $validFiles;

                // Only process images if new files are uploaded
                if (count($galleryFiles) > 0) {
                    // Get current max sort order for existing images
                    $maxSort = DB::table('product_images')
                        ->where('product_id', $productId)
                        ->max('sort_order') ?? -1;
                    $sort = $maxSort + 1;

                    foreach ($galleryFiles as $idx => $file) {
                        try {
                            // Verify the temp file is a valid uploaded file
                            $pathname = $file->getPathname();
                            
                            if (!is_uploaded_file($pathname)) {
                                Log::warning('File is not a valid uploaded file: ' . $file->getClientOriginalName());
                                continue;
                            }
                            
                            // Create destination directory if needed
                            $destDir = storage_path('app/public/product/images');
                            if (!is_dir($destDir)) {
                                mkdir($destDir, 0755, true);
                            }
                            
                            // Generate unique filename and move file
                            $fileName = 'IMG_' . time() . '_' . uniqid() . '.' . $file->extension();
                            $fullPath = $destDir . DIRECTORY_SEPARATOR . $fileName;
                            $relPath = 'product/images/' . $fileName;
                            
                            if (move_uploaded_file($pathname, $fullPath)) {
                                DB::table('product_images')->insert([
                                    'product_id' => $productId,
                                    'path' => $relPath,
                                    'is_cover' => (!$isUpdate && (int) $idx === 0) ? 1 : 0,
                                    'sort_order' => $sort++,
                                ]);
                            } else {
                                Log::warning('Failed to move uploaded file: ' . $file->getClientOriginalName());
                            }
                        } catch (\Exception $fileError) {
                            Log::error('Image upload exception: ' . $fileError->getMessage());
                            continue;
                        }
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
                        'stock_quantity' => (int) ($v['stock_quantity'] ?? ($v['stock'] ?? ($v['quantity'] ?? 0))),
                        'price' => isset($v['price']) ? (float) $v['price'] : null,
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

                    if ($wantImages && isset($files[$i]) && $files[$i] instanceof \Illuminate\Http\UploadedFile) {
                        // Comprehensive file validation
                        if (!$files[$i]->isValid()) {
                            Log::warning('Invalid variant image at index ' . $i . ': ' . $files[$i]->getErrorMessage());
                        } else {
                            $pathname = $files[$i]->getPathname();
                            if (empty($pathname) || !file_exists($pathname) || filesize($pathname) === 0) {
                                Log::warning('Empty or missing variant image file at index ' . $i);
                            } else {
                                try {
                                    $path = $files[$i]->store('product/variants', 'public');
                                    
                                    // Only insert if path is valid
                                    if (!empty($path) && Schema::hasTable('product_variant_images')) {
                                        DB::table('product_variant_images')->insert([
                                            'variant_id' => $variantId,
                                            'path' => $path,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);
                                    }
                                } catch (\Exception $fileError) {
                                    Log::warning('Variant image upload failed for variant ' . $variantId . ': ' . $fileError->getMessage());
                                }
                            }
                        }
                    }
                }

                // Sync product stock as sum of variant quantities if variants provided
                if (!empty($variants)) {
                    $totalStock = (int) DB::table('product_variants')
                        ->where('product_id', $productId)
                        ->sum('stock_quantity');
                    DB::table('products')->where('id', $productId)->update([
                        'stock_quantity' => $totalStock,
                        'updated_at' => now(),
                    ]);
                }

                Log::info('Product save completed successfully. Product ID: ' . $productId . ', Is Update: ' . ($isUpdate ? 'yes' : 'no'));
                
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
            ->orderByDesc('is_cover')
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'path', 'is_cover'])
            ->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => asset('storage/' . $img->path),
                    'is_cover' => (bool) $img->is_cover,
                ];
            });

        return response()->json(['images' => $images]);
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
        $variants = \App\Models\ProductVariant::with(['options.attribute', 'options.term', 'product'])
            ->where('product_id', $id)
            ->get();

        $formatted = $variants->map(function ($variant) {
            $combination = $variant->options->map(function ($opt) {
                return "{$opt->attribute->name}: {$opt->term->name}";
            })->join(' | ');

            $base = $variant->price;
            if ($base === null || $base <= 0) {
                $purchaseSell = \Illuminate\Support\Facades\DB::table('purchase_items')
                    ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                    ->where('purchase_items.variant_id', $variant->id)
                    ->where('purchases.status', 'received')
                    ->orderByDesc('purchases.purchase_date')
                    ->value('purchase_items.sell_price');
                $base = $purchaseSell !== null && $purchaseSell > 0 ? $purchaseSell : null;
            }
            $p = $variant->product;
            $fallback = $p ? ($p->sale_price ?? $p->price) : null;
            $effective = ($base !== null && $base > 0) ? $base : ($fallback ?? null);

            return [
                'name' => $combination ?: 'Default',
                'sku' => $variant->sku,
                'price' => $effective,
                'stock' => $variant->stock_quantity,
            ];
        });

        return response()->json(['variants' => $formatted]);
    }

    /**
     * 📋 Get Product Details (for modal)
     */
    public function getProductDetails($id)
    {
        $product = Product::with(['brand', 'categories', 'images', 'variants.options.attribute', 'variants.options.term'])->findOrFail($id);

        $images = $product->images->map(function ($img) {
            return [
                'id' => $img->id,
                'url' => asset('storage/' . $img->path),
                'is_cover' => $img->is_cover
            ];
        });

        $variants = $product->variants->map(function ($v) use ($product) {
            $base = $v->price;
            if ($base === null || $base <= 0) {
                $purchaseSell = \Illuminate\Support\Facades\DB::table('purchase_items')
                    ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                    ->where('purchase_items.variant_id', $v->id)
                    ->where('purchases.status', 'received')
                    ->orderByDesc('purchases.purchase_date')
                    ->value('purchase_items.sell_price');
                $base = $purchaseSell !== null && $purchaseSell > 0 ? $purchaseSell : null;
            }
            $fallback = $product->sale_price ?? $product->price;
            $effective = ($base !== null && $base > 0) ? $base : $fallback;
            return [
                'id' => $v->id,
                'sku' => $v->sku,
                'price' => $effective,
                'stock' => $v->stock_quantity,
                'options' => $v->options->map(function ($opt) {
                    return [
                        'attribute' => $opt->attribute->name,
                        'value' => $opt->term->name
                    ];
                })
            ];
        });

        return response()->json([
            'success' => true,
            'product' => $product,
            'images' => $images,
            'variants' => $variants,
        ]);
    }

    /**
     * 🏷️ Barcode Settings Page
     */
    public function barcode($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.barcode.index', compact('product'));
    }

    /**
     * 🖨️ Print Barcode
     */
    public function printBarcode(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
            'type' => 'required|string',
        ]);

        $product = Product::findOrFail($request->id);
        $quantity = $request->quantity;
        $type = $request->type;

        $generator = new BarcodeGeneratorPNG();
        $barcodeData = $product->sku;

        // Default to Code 128
        $barcodeType = $generator::TYPE_CODE_128;
        $error = null;

        if ($type === 'UPC-A') {
            // Validate UPC-A: Must be numeric. 11 or 12 digits.
            if (is_numeric($barcodeData) && (strlen($barcodeData) == 11 || strlen($barcodeData) == 12)) {
                $barcodeType = $generator::TYPE_UPC_A;
            } else {
                $error = "SKU '{$barcodeData}' is not a valid UPC-A code (must be 11 or 12 digits numeric). Falling back to Code 128.";
                // Fallback to Code 128
                $barcodeType = $generator::TYPE_CODE_128;
            }
        }

        try {
            $barcode = base64_encode($generator->getBarcode($barcodeData, $barcodeType));
        } catch (\Exception $e) {
            $error = "Error generating barcode: " . $e->getMessage();
            $barcode = base64_encode($generator->getBarcode($barcodeData, $generator::TYPE_CODE_128));
        }

        return view('admin.product.barcode.print', compact('product', 'quantity', 'barcode', 'type', 'error'));
    }

    /**
     * 📋 Barcode List Page
     */
    public function barcodeList()
    {
        return view('admin.product.barcode.list');
    }

    /**
     * 🖨️ Print All Barcodes
     */
    public function printAllBarcodes(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $quantity = $request->quantity;
        // Fetch all active products with SKU
        $products = Product::where('status', 'Active')->whereNotNull('sku')->where('sku', '!=', '')->get();

        $generator = new BarcodeGeneratorPNG();
        $items = [];

        foreach ($products as $product) {
            $barcodeData = $product->sku;

            // Default to Code 128
            $barcodeType = $generator::TYPE_CODE_128;

            // Check UPC-A eligibility (numeric, 11 or 12 digits)
            if (is_numeric($barcodeData) && (strlen($barcodeData) == 11 || strlen($barcodeData) == 12)) {
                $barcodeType = $generator::TYPE_UPC_A;
            }

            try {
                $barcode = base64_encode($generator->getBarcode($barcodeData, $barcodeType));
                $items[] = [
                    'product' => $product,
                    'barcode' => $barcode,
                    'quantity' => $quantity
                ];
            } catch (\Exception $e) {
                continue;
            }
        }

        return view('admin.product.barcode.print_multi', compact('items', 'quantity'));
    }

    /**
     * 🔔 Product Notification Page
     */
    public function notification($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.notification.index', compact('product'));
    }

    /**
     * 📨 Send Product Notification
     */
    public function sendNotification(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'audience' => 'required|in:all,customers',
        ]);

        $product = Product::findOrFail($id);

        $users = collect();

        if ($request->audience === 'all') {
            $users = User::where('is_active', true)->get();
        } elseif ($request->audience === 'customers') {
            // Try to find users with Customer role
            try {
                $users = User::role('Customer')->where('is_active', true)->get();
            } catch (\Exception $e) {
                // Fallback if role doesn't exist or error
                $users = User::where('is_active', true)->get();
            }
        }

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No users found for the selected audience.');
        }

        // Send Notification
        try {
            Notification::send($users, new ProductNotification($product, $request->title, $request->message));
            return redirect()->back()->with('success', 'Notification sent successfully to ' . $users->count() . ' users!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }

    // Product Upload Images

    public function uploadImages(Request $request, $id)
    {
        try {

            $product = Product::findOrFail($id);

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'No Product found.'], 400);
            }

            $uploadedFiles = $request->file('gallery', []);
            $uploadedFiles = is_array($uploadedFiles) ? $uploadedFiles : ($uploadedFiles ? [$uploadedFiles] : []);

            if (count($uploadedFiles) === 0) {
                return response()->json(['success' => false, 'message' => 'No images uploaded.'], 400);
            }

            // Get current max sort order for existing images
            $maxSort = DB::table('product_images')
                ->where('product_id', $id)
                ->max('sort_order') ?? -1;
            $sort = $maxSort + 1;

            foreach ($uploadedFiles as $file) {
   
                if (!($file instanceof \Illuminate\Http\UploadedFile) || !$file->isValid())
                    continue;
                $path = $file->store('product/images', 'public');
                DB::table('product_images')->insert([
                    'product_id' => $id,
                    'path' => $path,
                    'is_cover' => $file->getClientOriginalName() === $request->input('gallery_cover_name', '') ? 1 : 0,
                    'sort_order' => $sort++,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Images uploaded successfully.']);
        } catch (\Exception $e) {
            Log::error('Upload images error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to upload images.'], 500);
        }
    }
}

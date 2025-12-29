<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin\Product\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        try {
            // Fetch Categories
            $categories = ProductCategory::select('id', 'name', 'slug', 'thumb_url')->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image' => $category->thumb_url ? url('storage/' . $category->thumb_url) : null,
                    ];
                });

            // Fetch Products
            $products = Product::where('status', 'Active')
                ->with(['categories:id,name,slug', 'brand:id,name,slug', 'coverImage'])
                ->select('id', 'title', 'slug', 'price', 'sale_price', 'short_desc', 'brand_id')
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->title,
                        'slug' => $product->slug,
                        'price' => (float)$product->price,
                        'discount_price' => (float)$product->sale_price,
                        'thumbnail_image' => $product->coverImage ? url('storage/' . $product->coverImage->path) : null,
                        'brand' => $product->brand ? $product->brand->name : null,
                        'categories' => $product->categories->pluck('name'),
                        'short_description' => $product->short_desc,
                    ];
                });

            return response()->json([
                'status' => 'success',
                'message' => 'Products fetched successfully',
                'data' => [
                    'categories' => $categories,
                    'products' => $products
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch data: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}

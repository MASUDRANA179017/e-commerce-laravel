<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand\Brand;
use App\Models\Admin\Brand\BrandTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    private function handleFileUpload($file, $path)
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('uploads/' . $path, $fileName, 'public');
    }

    private function handleFileDelete($filePath)
    {
        if ($filePath && Storage::exists('public/' . $filePath)) {
            Storage::delete('public/' . $filePath);
        }
    }
    public function index()
    {
        $brands = BrandTemplate::all()->groupBy('category')->map(function ($items, $key) {
            return [
                'cat' => $key,
                'items' => $items->map(function ($b) {
                    return [
                        'name' => $b->name,
                        'country' => $b->country,
                        'logo' => $b->logo
                    ];
                })->toArray()
            ];
        })->values();

        return view('admin.brand.index', compact('brands'));
        // return view('admin.brand.index');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'order' => 'nullable|integer',
            'country' => 'nullable|string|max:50',
        ]);

        // Prepare data
        $data = $request->only([
            'name', 'slug', 'website', 'country', 'order', 'description'
        ]);

        $data['slug'] = $request->slug ?? Str::slug($request->name);
        $data['featured'] = $request->input('featured', 0);
        $data['active'] = $request->input('active', 0);
        $data['top'] = $request->input('top', 0);

        // Check if updating existing brand
        $brand = Brand::find($request->id);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($brand && $brand->logo) {
                $this->handleFileDelete($brand->logo);
            }

            $data['logo'] = $this->handleFileUpload($request->file('logo'), 'brands');
        }

        // Create or update brand
        $brand = Brand::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'Brand saved successfully!',
            'brand' => $brand
        ]);
    }

    public function getBrands()
    {
        $brands = Brand::orderBy('order', 'asc')->get();

        return response()->json([
            'success' => true,
            'brands' => $brands->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                    'website' => $brand->website,
                    'country' => $brand->country,
                    'order' => $brand->order,
                    'featured' => $brand->featured,
                    'active' => $brand->active,
                    'top' => $brand->top,
                    'description' => $brand->description,
                    'logo_url' => $brand->logo ? asset('storage/'.$brand->logo) : null,
                ];
            })
        ]);
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Purano logo delete korbo
            if ($brand->logo) {
                $this->handleFileDelete($brand->logo);
            }

            $brand->delete();

            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully!'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete this brand because it is associated with other records (e.g. products).'
                ], 500);
            }
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

     // Toggle Featured
    public function toggleFeature(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:brands,id',
            'featured' => 'required|boolean',
        ]);

        $brand = Brand::find($request->id);
        $brand->featured = $request->featured;
        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Brand featured status updated successfully.'
        ]);
    }

    // Toggle Active
    public function toggleActive(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:brands,id',
            'active' => 'required|boolean',
        ]);

        $brand = Brand::find($request->id);
        $brand->active = $request->active;
        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Brand active status updated successfully.'
        ]);
    }

    public function storeIntoBrand(Request $request)
    {
        $brand = Brand::updateOrCreate(
            ['name' => $request->name], 
            [
                'country' => $request->country,
                'slug' => Str::slug($request->name),
                
            ]
        );

        return response()->json([
            'success' => true,
            'brand' => $brand
        ]);
    }




}

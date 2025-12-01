<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand\BrandTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandTemplateController extends Controller
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

    // public function index()
    // {
    //     // Fetch all brands grouped by category
    //     $brands = BrandTemplate::all()->groupBy('category')->map(function ($items, $key) {
    //         return [
    //             'cat' => $key,
    //             'items' => $items->map(function ($b) {
    //                 return [
    //                     'name' => $b->name,
    //                     'country' => $b->country,
    //                     'logo' => $b->logo
    //                 ];
    //             })->toArray()
    //         ];
    //     })->values();

    //     return view('admin.brand.index', compact('brands'));
    // }

    
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'top' => 'nullable|boolean',
        ]);

        // Find existing template if updating
        $brandTemplate = BrandTemplate::find($request->id);

        // Handle file upload
        if ($request->hasFile('logo')) {
            // Delete old file if exists
            if ($brandTemplate) {
                $this->handleFileDelete($brandTemplate->logo);
            }

            // Upload new file
            $logoPath = $this->handleFileUpload($request->file('logo'), 'brand_templates');
            $request->merge(['logo' => $logoPath]);
        }

        $brandTemplate = BrandTemplate::updateOrCreate(
            ['id' => $request->id],
            $request->only([
                'name',
                'slug',
                'website',
                'country',
                'order',
                'logo',
                'description',
                'featured',
                'active',
                'top',
                'category_name'
            ])
        );

        return response()->json([
            'success' => true,
            'message' => 'Brand Template saved successfully!',
            'data' => $brandTemplate
        ]);
    }

}

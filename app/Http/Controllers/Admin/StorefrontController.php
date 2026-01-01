<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Business_SetUp\BusinessSetup;
use App\Models\Banner;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorefrontController extends Controller
{
    public function customizer()
    {
        $business_setup = BusinessSetup::first();
        return view('admin.storefront.customizer', compact('business_setup'));
    }

    public function saveCustomizer(Request $request)
    {
        $business_setup = BusinessSetup::first();
        if ($business_setup) {
            $business_setup->update($request->only([
                'theme_color_primary',
                'theme_color_secondary',
                'theme_color_accent',
                'theme_font_primary',
                'theme_font_base_size',
                'theme_header_style',
                'theme_footer_style',
            ]));
        }
        return response()->json(['success' => true, 'message' => 'Theme settings saved']);
    }

    public function pages()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.storefront.pages', compact('pages'));
    }

    public function createPage()
    {
        return view('admin.storefront.pages-create');
    }

    public function storePage(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => true,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('admin.storefront.pages')->with('success', 'Page created successfully');
    }

    public function editPage($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.storefront.pages-edit', compact('page'));
    }

    public function updatePage(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->has('status'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('admin.storefront.pages')->with('success', 'Page updated successfully');
    }

    public function destroyPage($id)
    {
        Page::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Page deleted successfully');
    }

    public function menus()
    {
        return view('admin.storefront.menus');
    }

    public function storeMenu(Request $request)
    {
        // Store menu logic
        return response()->json(['success' => true]);
    }

    public function updateMenu(Request $request, $menu)
    {
        // Update menu logic
        return response()->json(['success' => true]);
    }

    public function destroyMenu($menu)
    {
        // Delete menu logic
        return response()->json(['success' => true]);
    }

    public function blog()
    {
        $posts = collect(); // BlogPost::all()
        return view('admin.storefront.blog', compact('posts'));
    }

    public function createBlog()
    {
        return view('admin.storefront.blog-create');
    }

    public function storeBlog(Request $request)
    {
        // Store blog post logic
        return redirect()->route('admin.storefront.blog')->with('success', 'Blog post created');
    }

    public function editBlog($post)
    {
        return view('admin.storefront.blog-edit', compact('post'));
    }

    public function updateBlog(Request $request, $post)
    {
        // Update blog post logic
        return redirect()->route('admin.storefront.blog')->with('success', 'Blog post updated');
    }

    public function destroyBlog($post)
    {
        // Delete blog post logic
        return response()->json(['success' => true]);
    }

    public function banners()
    {
        $hero_sliders = Banner::where('type', 'hero_slider')->orderBy('position')->get();
        $promotional_banners = Banner::where('type', 'promotional_banner')->orderBy('position')->get();
        return view('admin.storefront.banners', compact('hero_sliders', 'promotional_banners'));
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'required|in:hero_slider,promotional_banner',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $path,
            'link' => $request->link,
            'type' => $request->type,
            'position' => $request->position ?? 0,
            'status' => true,
        ]);

        return redirect()->back()->with('success', 'Banner added successfully');
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'link' => $request->link,
            'position' => $request->position ?? $banner->position,
            'status' => $request->has('status'),
        ];

        if ($request->hasFile('image')) {
             if (Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->back()->with('success', 'Banner updated successfully');
    }

    public function destroyBanner($id)
    {
        $banner = Banner::findOrFail($id);
        if (Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted successfully');
    }
}


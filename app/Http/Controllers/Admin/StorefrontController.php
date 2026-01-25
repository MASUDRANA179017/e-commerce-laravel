<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Admin\Business_SetUp\BusinessSetup;
use App\Models\Banner;
use App\Models\Page;
use App\Models\Menu;
use App\Models\MenuItem;
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
        if (!$business_setup) {
            $business_setup = BusinessSetup::create([
                'company_name' => 'My Company',
            ]);
        }
        
        $business_setup->update($request->only([
            'theme_color_primary',
            'theme_color_secondary',
            'theme_color_accent',
            'theme_button_text_color',
            'theme_secondary_button_bg',
            'theme_secondary_button_text',
            'theme_color_link',
            'theme_color_text',
            'theme_color_heading',
            'theme_color_badge',
            'theme_color_border',
            'theme_color_input_focus',
            'theme_color_success',
            'theme_color_danger',
            'theme_font_primary',
            'theme_font_base_size',
            'theme_header_style',
            'theme_footer_style',
        ]));
        
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
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'content' => $request->content,
            'status' => (int) ($request->input('status', 1)) === 1,
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
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'content' => 'required',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : $page->slug,
            'content' => $request->content,
            'status' => (int) ($request->input('status', $page->status ? 1 : 0)) === 1,
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
    
    public function uploadPageImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);
        $path = $request->file('image')->store('pages', 'public');
        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path),
            'path' => $path,
        ]);
    }

    public function menus()
    {
        $path = 'menus.json';
        if (Storage::disk('local')->exists($path)) {
            $menus = json_decode(Storage::disk('local')->get($path), true);
        } else {
            $menus = [
                'main' => [
                    ['label' => 'Home', 'url' => url('/')],
                    ['label' => 'Shop', 'url' => route('shop.index')],
                    ['label' => 'Blog', 'url' => route('blog.index')],
                    ['label' => 'Contact', 'url' => route('frontend.contact')],
                ],
                'footer' => [
                    ['label' => 'Shop', 'url' => route('shop.index')],
                    ['label' => 'About', 'url' => route('frontend.about')],
                    ['label' => 'Blog', 'url' => route('blog.index')],
                    ['label' => 'Contact', 'url' => route('frontend.contact')],
                ],
                'mobile' => [
                    ['label' => 'Home', 'url' => url('/')],
                    ['label' => 'Shop', 'url' => route('shop.index')],
                    ['label' => 'Categories', 'url' => route('shop.index')],
                    ['label' => 'Contact', 'url' => route('frontend.contact')],
                ],
            ];
            Storage::disk('local')->put($path, json_encode($menus));
        }
        $active = request('menu', 'main');
        return view('admin.storefront.menus', compact('menus', 'active'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $path = 'menus.json';
        $menus = [];
        if (Storage::disk('local')->exists($path)) {
            $menus = json_decode(Storage::disk('local')->get($path), true) ?: [];
        }
        $key = Str::slug($request->name);
        if (!isset($menus[$key])) {
            $menus[$key] = [];
            Storage::disk('local')->put($path, json_encode($menus));
        }
        return redirect()->route('admin.storefront.menus', ['menu' => $key])->with('success', 'Menu created');
    }

    public function updateMenu(Request $request, $menu)
    {
        $labels = $request->input('label', []);
        $urls = $request->input('url', []);
        $items = [];
        foreach ($labels as $i => $label) {
            $label = trim($label ?? '');
            $url = trim($urls[$i] ?? '');
            if ($label !== '' && $url !== '') {
                $items[] = ['label' => $label, 'url' => $url];
            }
        }
        $path = 'menus.json';
        $menus = [];
        if (Storage::disk('local')->exists($path)) {
            $menus = json_decode(Storage::disk('local')->get($path), true) ?: [];
        }
        $menus[$menu] = $items;
        Storage::disk('local')->put($path, json_encode($menus));
        return redirect()->route('admin.storefront.menus', ['menu' => $menu])->with('success', 'Menu saved');
    }

    public function destroyMenu($menu)
    {
        $path = 'menus.json';
        if (Storage::disk('local')->exists($path)) {
            $menus = json_decode(Storage::disk('local')->get($path), true) ?: [];
            if (isset($menus[$menu])) {
                unset($menus[$menu]);
                Storage::disk('local')->put($path, json_encode($menus));
            }
        }
        return redirect()->route('admin.storefront.menus')->with('success', 'Menu deleted');
    }

    public function blog()
    {
        $posts = Blog::with('author')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.storefront.blog', compact('posts'));
    }

    public function createBlog()
    {
        $categories = Blog::whereNotNull('category')->distinct()->pluck('category');
        return view('admin.storefront.blog-create', compact('categories'));
    }

    public function storeBlog(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'category' => isset($validated['category']) ? trim($validated['category']) : null,
            'tags' => null,
            'author_id' => auth()->id(),
            'is_published' => (bool)($request->has('is_published')),
        ];

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        if (!empty($validated['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        Blog::create($data);

        return redirect()->route('admin.storefront.blog')->with('success', 'Blog post created');
    }

    public function editBlog($post)
    {
        $post = Blog::findOrFail($post);
        $categories = Blog::whereNotNull('category')->distinct()->pluck('category');
        return view('admin.storefront.blog-edit', compact('post', 'categories'));
    }

    public function updateBlog(Request $request, $post)
    {
        $post = Blog::findOrFail($post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'category' => isset($validated['category']) ? trim($validated['category']) : null,
            'tags' => null,
            'is_published' => (bool)($request->has('is_published') ? $validated['is_published'] : $post->is_published),
        ];

        if (!empty($validated['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($post->featured_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        if ($data['is_published'] && !$post->published_at) {
            $data['published_at'] = now();
        }
        if (!$data['is_published']) {
            $data['published_at'] = null;
        }

        $post->update($data);

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
        $store_sections = Banner::where('type', 'store_section')->orderBy('position')->get();
        return view('admin.storefront.banners', compact('hero_sliders', 'promotional_banners', 'store_sections'));
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'required|in:hero_slider,promotional_banner,store_section',
        ]);

        if (!$request->hasFile('image')) {
            return redirect()->back()->withErrors(['image' => 'Image is required'])->withInput();
        }

        $file = $request->file('image');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->withErrors(['image' => 'Upload failed. Please ensure the file size is within limits.'])->withInput();
        }

        // Guard against missing temp path (can happen if PHP upload failed silently)
        if (empty($file->getRealPath())) {
            return redirect()->back()->withErrors(['image' => 'Upload failed: temporary file is missing. Try a smaller image or check PHP upload limits.'])->withInput();
        }

        try {
            $path = $file->store('banners', 'public');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['image' => 'Saving image failed. Please retry with a smaller file.'])->withInput();
        }

        if (empty($path)) {
            return redirect()->back()->withErrors(['image' => 'Saving image failed (empty path). Please retry.'])->withInput();
        }

        Banner::create([
            'title' => $request->title,
            'image' => $path,
            'link' => $request->link,
            'type' => $request->type,
            'position' => $request->position ?? 0,
            'status' => $request->has('status'),
        ]);

        return redirect()->back()->with('success', 'Banner added successfully');
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'nullable|in:hero_slider,promotional_banner,store_section',
        ]);

        $data = [
            'title' => $request->title,
            'link' => $request->link,
            'type' => $request->type ?? $banner->type,
            'position' => $request->position ?? $banner->position,
            'status' => $request->has('status'),
        ];

        if ($request->hasFile('image')) {
            if (!empty($banner->image) && Storage::disk('public')->exists($banner->image)) {
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
        if (!empty($banner->image) && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted successfully');
    }
}



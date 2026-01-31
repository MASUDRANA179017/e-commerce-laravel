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
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StorefrontController extends Controller
{
    public function customizer()
    {
        $business_setup = BusinessSetup::first();
        
        // Scan themes directory
        $themesPath = resource_path('views/themes');
        $themes = [];
        if (File::exists($themesPath)) {
            $themes = array_map('basename', File::directories($themesPath));
        } else {
            // Fallback if directory doesn't exist yet
            $themes = ['theme1']; 
        }

        return view('admin.storefront.customizer', compact('business_setup', 'themes'));
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
            'active_theme',
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
        $this->ensureMenusSeeded();

        $active = request('menu', 'main');
        $menuModels = Menu::orderBy('name')->get();
        $activeMenu = $menuModels->firstWhere('key', $active) ?? $menuModels->first();
        if (!$activeMenu) {
            $activeMenu = Menu::create(['key' => 'main', 'name' => 'Main']);
        }
        $active = $activeMenu->key;

        // Build associative array keyed by menu key to keep view compatible
        $menus = [];
        foreach ($menuModels as $menu) {
            $menus[$menu->key] = $this->buildMenuTree($menu);
        }

        // Always include static pages
        $pages = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'About Us', 'url' => '/about'],
            ['label' => 'Contact', 'url' => '/contact'],
            ['label' => 'Terms & Conditions', 'url' => '/terms-and-conditions'],
            ['label' => 'Privacy Policy', 'url' => '/privacy-policy'],
        ];

        // Add database pages
        $dbPages = Page::orderBy('title')->get(['title','slug'])->map(function($p){
            return [
                'label' => $p->title,
                'url' => '/page/' . $p->slug,
            ];
        })->values()->toArray();

        // Merge both lists, avoiding duplicates
        foreach ($dbPages as $page) {
            if (!in_array($page, $pages)) {
                $pages[] = $page;
            }
        }

        $categories = \App\Models\Admin\Product\ProductCategory::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderByRaw('CASE WHEN `order` = 0 OR `order` IS NULL THEN 1 ELSE 0 END, `order` ASC')
            ->get()
            ->map(function($c){
                $mapChild = function($child) use (&$mapChild){
                    return [
                        'label' => $child->name,
                        'url' => '/shop?category=' . $child->slug,
                        'children' => ($child->childrenRecursive ?? collect())->map(function($cc) use (&$mapChild){
                            return $mapChild($cc);
                        })->values()->toArray()
                    ];
                };
                return [
                    'label' => $c->name,
                    'url' => '/shop?category=' . $c->slug,
                    'children' => ($c->childrenRecursive ?? collect())->map(function($ch) use (&$mapChild){
                        return $mapChild($ch);
                    })->values()->toArray()
                ];
            })->values()->toArray();
        return view('admin.storefront.menus', compact('menus', 'active', 'pages', 'categories'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $key = Str::slug($request->name);
        Menu::firstOrCreate(['key' => $key], ['name' => $request->name]);

        return redirect()->route('admin.storefront.menus', ['menu' => $key])->with('success', 'Menu created');
    }

    public function updateMenu(Request $request, $menu)
    {
        $menuModel = Menu::firstOrCreate(['key' => $menu], ['name' => ucfirst($menu)]);

        $labels = $request->input('label', []);
        $urls = $request->input('url', []);
        $depths = $request->input('depth', []);
        $existingImages = $request->input('existing_image', []);
        $files = $request->file('image', []);

        $root = [];
        $parents = [];
        foreach ($labels as $i => $label) {
            $label = trim($label ?? '');
            $url = trim($urls[$i] ?? '');
            $depth = (int) ($depths[$i] ?? 0);

            // Handle Image
            $imagePath = $existingImages[$i] ?? null;
            // $files can be an array where keys match the input index, or reindexed.
            // When using name="image[]", PHP reindexes it sequentially for uploaded files.
            // If we want correct mapping, we must assume every item sends an input, even if empty.
            // However, browsers send empty files for empty inputs.
            // Let's check if $files[$i] exists.
            if (isset($files[$i]) && $files[$i]->isValid()) {
                $imagePath = uploadFile($files[$i], 'menu_items');
            }

            if ($label === '' || $url === '') {
                continue;
            }
            if ($depth < 0) $depth = 0;
            if ($depth > 3) $depth = 3;
            $node = ['label' => $label, 'url' => $url, 'image' => $imagePath];
            if ($depth === 0) {
                $root[] = $node;
                $parents = [];
                $parents[0] = &$root[count($root) - 1];
            } else {
                $parentDepth = $depth - 1;
                if (!isset($parents[$parentDepth])) {
                    $root[] = $node;
                    $parents = [];
                    $parents[0] = &$root[count($root) - 1];
                } else {
                    if (!isset($parents[$parentDepth]['children'])) {
                        $parents[$parentDepth]['children'] = [];
                    }
                    $parents[$parentDepth]['children'][] = $node;
                    $parents[$depth] = &$parents[$parentDepth]['children'][count($parents[$parentDepth]['children']) - 1];
                    foreach ($parents as $k => $v) {
                        if ($k > $depth) {
                            unset($parents[$k]);
                        }
                    }
                }
            }
        }

        // Replace menu items in DB
        \DB::transaction(function () use ($menuModel, $root) {
            MenuItem::where('menu_id', $menuModel->id)->delete();
            $this->saveMenuItems($menuModel->id, $root);
        });

        return redirect()->route('admin.storefront.menus', ['menu' => $menuModel->key])->with('success', 'Menu saved');
    }

    public function destroyMenu($menu)
    {
        if ($menuModel = Menu::where('key', $menu)->first()) {
            $menuModel->delete();
        }
        return redirect()->route('admin.storefront.menus')->with('success', 'Menu deleted');
    }

    /**
     * Ensure DB menus are seeded from existing file or defaults.
     */
    private function ensureMenusSeeded(): void
    {
        if (Menu::count() > 0) {
            return;
        }

        $menusData = [];
        // Prefer private/menus.json if present
        if (Storage::disk('local')->exists('private/menus.json')) {
            $menusData = json_decode(Storage::disk('local')->get('private/menus.json'), true) ?: [];
        } elseif (Storage::disk('local')->exists('menus.json')) {
            $menusData = json_decode(Storage::disk('local')->get('menus.json'), true) ?: [];
        } else {
            $menusData = [
                'main' => [
                    ['label' => 'Home', 'url' => '/'],
                    ['label' => 'Shop', 'url' => '/shop'],
                    ['label' => 'Blog', 'url' => '/blog'],
                    ['label' => 'Contact', 'url' => '/contact'],
                ],
                'footer' => [
                    ['label' => 'Shop', 'url' => '/shop'],
                    ['label' => 'About', 'url' => '/about'],
                    ['label' => 'Blog', 'url' => '/blog'],
                    ['label' => 'Contact', 'url' => '/contact'],
                ],
                'mobile' => [
                    ['label' => 'Home', 'url' => '/'],
                    ['label' => 'Shop', 'url' => '/shop'],
                    ['label' => 'Categories', 'url' => '/shop'],
                    ['label' => 'Contact', 'url' => '/contact'],
                ],
            ];
        }

        foreach ($menusData as $key => $items) {
            $menu = Menu::firstOrCreate(['key' => $key], ['name' => ucfirst($key)]);
            $this->saveMenuItems($menu->id, $items);
        }
    }

    /**
     * Save menu items recursively for a menu.
     */
    private function saveMenuItems(int $menuId, array $items, ?int $parentId = null): void
    {
        foreach (array_values($items) as $idx => $item) {
            $node = MenuItem::create([
                'menu_id' => $menuId,
                'parent_id' => $parentId,
                'label' => $item['label'] ?? '',
                'url' => $item['url'] ?? '',
                'sort_order' => $idx,
            ]);
            if (!empty($item['children']) && is_array($item['children'])) {
                $this->saveMenuItems($menuId, $item['children'], $node->id);
            }
        }
    }

    /**
     * Build nested array of menu items for the view.
     */
    private function buildMenuTree(Menu $menu): array
    {
        $items = MenuItem::where('menu_id', $menu->id)
            ->orderBy('sort_order')
            ->get();
        $byParent = $items->groupBy('parent_id');
        $build = function($parentId) use (&$build, $byParent) {
            return ($byParent[$parentId] ?? collect())->map(function($item) use (&$build) {
                return [
                    'label' => $item->label,
                    'url' => $item->url,
                    'children' => $build($item->id),
                ];
            })->values()->toArray();
        };
        return $build(null);
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
            'author_id' => Auth::id(),
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
        $ads_sections = Banner::where('type', 'ads_section')->orderBy('position')->get();
        return view('admin.storefront.banners', compact('hero_sliders', 'promotional_banners', 'store_sections', 'ads_sections'));
    }

    public function adsSections()
    {
        $ads_sections = Banner::where('type', 'ads_section')->orderBy('position')->get();
        return view('admin.storefront.ads-sections', compact('ads_sections'));
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'required|in:hero_slider,promotional_banner,store_section,ads_section',
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
            'type' => 'nullable|in:hero_slider,promotional_banner,store_section,ads_section',
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

    public function commonImages()
    {
        $images = [
            'footer_background' => SystemSetting::get('footer_background'),
            'flash_sale_image' => SystemSetting::get('flash_sale_image'),
            'shop_title_banner' => SystemSetting::get('shop_title_banner'),
        ];
        return view('admin.storefront.common_images', compact('images'));
    }

    public function updateCommonImages(Request $request)
    {
        $keys = [
            'footer_background',
            'flash_sale_image',
            'shop_title_banner'
        ];

        foreach ($keys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);

                // Validate file upload
                if (!$file->isValid()) {
                    return redirect()->back()->withErrors(['image' => "Upload failed for $key."])->withInput();
                }

                try {
                    // Manual storage to bypass getRealPath() issues on some Windows environments
                    $filename = $file->hashName();
                    $path = 'common_images/' . $filename;

                    // Try to read content safely
                    $content = file_get_contents($file->getPathname());
                    if ($content === false) {
                        throw new \Exception("Could not read uploaded file content.");
                    }

                    Storage::disk('public')->put($path, $content);
                } catch (\Throwable $e) {
                    return redirect()->back()->withErrors(['image' => "Failed to store image for $key: " . $e->getMessage()])->withInput();
                }

                // Delete old image if exists
                try {
                    $oldImage = SystemSetting::get($key);
                    if (!empty($oldImage) && is_string($oldImage) && trim($oldImage) !== '') {
                        if (Storage::disk('public')->exists($oldImage)) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                } catch (\Throwable $e) {
                    // Ignore deletion errors to prevent blocking the upload
                }

                SystemSetting::set($key, $path);
            }
        }

        return redirect()->back()->with('success', 'Images updated successfully');
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::with('author')->latest('created_at');
            return DataTables::of($blogs)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    if($row->featured_image){
                        return '<img src="'.asset('storage/' . $row->featured_image).'" alt="'.$row->title.'" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">';
                    }
                    return '<div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;"><i class="bx bx-image" style="font-size: 24px; color: #6c757d;"></i></div>';
                })
                ->addColumn('title', function($row){
                    $html = '<strong>'.Str::limit($row->title, 50).'</strong>';
                    if($row->excerpt){
                        $html .= '<br><small class="text-muted">'.Str::limit($row->excerpt, 60).'</small>';
                    }
                    return $html;
                })
                ->addColumn('category', function($row){
                    return $row->category ? '<span class="badge bg-info">'.$row->category.'</span>' : '<span class="text-muted">-</span>';
                })
                ->addColumn('author', function($row){
                    return $row->author->name ?? 'Unknown';
                })
                ->addColumn('status', function($row){
                    return $row->is_published ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-warning">Draft</span>';
                })
                ->editColumn('views', function($row){
                    return number_format($row->views);
                })
                ->editColumn('created_at', function($row){
                    return $row->formatted_date;
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.blogs.edit', $row->id);
                    $deleteUrl = route('admin.blogs.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    return '
                        <div class="btn-group" role="group">
                            <a href="'.$editUrl.'" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bx bx-edit"></i>
                            </a>
                            <form action="'.$deleteUrl.'" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this blog post?\');">
                                '.$csrf.'
                                '.$method.'
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>';
                })
                ->rawColumns(['image', 'title', 'category', 'status', 'action'])
                ->make(true);
        }

        return view('admin.blog.index');
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
        ]);

        $validated['author_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs', 'public');
        }

        // Convert tags string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = null;
        }

        // Set published_at if publishing
        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs', 'public');
        }

        // Convert tags string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = null;
        }

        // Set published_at if publishing for the first time
        if ($validated['is_published'] && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }
}

@extends('layouts.master')

@section('title', 'Page Builder')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Page Builder</h3>
            <a href="{{ route('admin.storefront.pages.create') }}" class="create-btn-base">
                <span class="material-symbols-outlined fs-14">add</span> Create Page
            </a>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Page Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Last Modified</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $page->title }}</td>
                                <td><code>/{{ $page->slug }}</code></td>
                                <td>
                                    @if($page->status)
                                        <span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Published</span>
                                    @else
                                        <span class="qbit-badge-danger"><i class="bx bx-x-circle"></i> Draft</span>
                                    @endif
                                </td>
                                <td>{{ $page->updated_at->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('admin.storefront.pages.edit', $page->id) }}" class="action-btn-success" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <form action="{{ route('admin.storefront.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-danger border-0" title="Delete">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="alert alert-info mb-0">
                                            <strong>Terms & Conditions</strong><br>
                                            This is your system's default Terms & Conditions page. You can add or edit content by clicking <b>Add New</b> above.<br>
                                            <span class="text-muted">Example: "By using this site, you agree to our terms and conditions. All purchases are subject to our policies. Please review carefully before ordering."</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-3 py-3">
                    {{ $pages->links() }}
                </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


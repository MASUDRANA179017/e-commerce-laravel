@extends('layouts.master')

@section('title', 'Navigation Menus')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Navigation Menus</h3>
            <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                <span class="material-symbols-outlined fs-14">add</span> Create Menu
            </button>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Available Menus</h5>
            </div>
            <div class="list-group list-group-flush">
                @php $menuKeys = array_keys($menus ?? []); @endphp
                @foreach($menuKeys as $key)
                <a href="{{ route('admin.storefront.menus', ['menu' => $key]) }}" class="list-group-item list-group-item-action {{ ($active ?? 'main') === $key ? 'active' : '' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="material-symbols-outlined fs-14 me-2">menu</i> {{ ucfirst($key) }} Menu</span>
                        <span class="{{ ($active ?? 'main') === $key ? 'qbit-badge-primary' : 'qbit-badge-gray' }}">{{ count($menus[$key] ?? []) }} items</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">{{ ucfirst($active ?? 'main') }} Menu Items</h5>
                <span class="text-muted small">Editing: {{ $active ?? 'main' }}</span>
            </div>
            <form action="{{ route('admin.storefront.menus.update', $active ?? 'main') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="menu-items">
                        @php $items = $menus[$active ?? 'main'] ?? []; @endphp
                        @foreach($items as $i => $item)
                        <div class="p-3 bg-light rounded mb-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="label[]" value="{{ $item['label'] ?? '' }}" placeholder="Label">
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="url[]" value="{{ $item['url'] ?? '' }}" placeholder="URL or route-generated link">
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @for($j=0;$j<3;$j++)
                        <div class="p-3 bg-light rounded mb-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="label[]" value="" placeholder="Label">
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="url[]" value="" placeholder="URL or route-generated link">
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <button type="submit" class="create-btn-base">Save Menu</button>
                    <form action="{{ route('admin.storefront.menus.destroy', $active ?? 'main') }}" method="POST" onsubmit="return confirm('Delete this menu?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn-danger">Delete Menu</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createMenuModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.storefront.menus.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Menu Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Main, Footer, Mobile" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="create-btn-base">Create</button>
        </div>
      </form>
    </div>
  </div>
  </div>
@endsection


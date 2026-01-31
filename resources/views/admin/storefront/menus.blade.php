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
            <form action="{{ route('admin.storefront.menus.update', $active ?? 'main') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-2">Menu Items</h6>
                                    <button type="button" class="create-btn-white btn-sm" id="btnAddItem">Add New Item</button>
                                </div>
                                <div class="menu-items">
                                    @php
                                        $itemsTree = $menus[$active ?? 'main'] ?? [];
                                        $flat = [];
                                        $flatten = function($list, $d = 0) use (&$flat, &$flatten) {
                                            foreach ($list as $it) {
                                                $flat[] = [
                                                    'label' => $it['label'] ?? '',
                                                    'url' => $it['url'] ?? '',
                                                    'image' => $it['image'] ?? null,
                                                    'depth' => $d
                                                ];
                                                if (isset($it['children']) && is_array($it['children'])) {
                                                    $flatten($it['children'], $d + 1);
                                                }
                                            }
                                        };
                                        $flatten($itemsTree, 0);
                                    @endphp
                                    @foreach($flat as $i => $item)
                                    <div class="p-3 bg-light rounded mb-2 menu-item-row" style="margin-left: {{ (int)($item['depth'] ?? 0) * 24 }}px; border-left: 2px solid #e5e7eb;">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-sm drag-handle" title="Drag" style="cursor:grab">
                                                    <span class="material-symbols-outlined fs-14">drag_indicator</span>
                                                </button>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" name="label[]" value="{{ $item['label'] ?? '' }}" placeholder="Label">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="url[]" value="{{ $item['url'] ?? '' }}" placeholder="URL">
                                                <input type="hidden" name="depth[]" value="{{ (int)($item['depth'] ?? 0) }}" class="depth-input">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2 gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btnOutdent" title="Outdent">
                                                <span class="material-symbols-outlined fs-14">chevron_left</span>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary btnIndent" title="Indent">
                                                <span class="material-symbols-outlined fs-14">chevron_right</span>
                                            </button>
                                            <button type="button" class="action-btn-danger btn-sm btnRemoveItem" title="Remove">
                                                <span class="material-symbols-outlined fs-14">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-2">Available Pages</h6>
                                    <button type="button" class="create-btn-white btn-sm" id="btnAddAllPages">Add All</button>
                                </div>
                                <div class="list-group small">
                                    @foreach(($pages ?? []) as $pg)
                                    <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btnAddPage" data-label="{{ $pg['label'] }}" data-url="{{ $pg['url'] }}">
                                        <span>{{ $pg['label'] }}</span>
                                        <span class="text-muted">{{ $pg['url'] }}</span>
                                    </button>
                                    @endforeach
                                    @if(empty($pages) || count($pages) === 0)
                                    <div class="small-muted">No pages found. Create pages in Page Builder.</div>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-2">Product Categories</h6>
                                    <button type="button" class="create-btn-white btn-sm" id="btnAddAllCats">Add All</button>
                                </div>
                                <div class="list-group small">
                                    @php
                                        $renderCats = function($cats, $indent = 0) use (&$renderCats) {
                                            foreach($cats as $c){
                                                echo '<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btnAddCat" data-label="'.e($c['label']).'" data-url="'.e($c['url']).'">';
                                                echo '<span style="padding-left:'.(12*$indent).'px">'.e($c['label']).'</span>';
                                                echo '<span class="text-muted">'.e($c['url']).'</span>';
                                                echo '</button>';
                                                if (!empty($c['children'])) {
                                                    $renderCats($c['children'], $indent + 1);
                                                }
                                            }
                                        };
                                    @endphp
                                    @if(!empty($categories) && count($categories) > 0)
                                        @php $renderCats($categories, 0); @endphp
                                    @else
                                        <div class="small-muted">No categories found.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <button type="submit" class="create-btn-base">Save Menu</button>
                    <button type="button" class="action-btn-danger" onclick="if(confirm('Delete this menu?')) document.getElementById('deleteMenuForm').submit();">Delete Menu</button>
                </div>
            </form>
            <form id="deleteMenuForm" action="{{ route('admin.storefront.menus.destroy', $active ?? 'main') }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
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
@push('scripts')
<script>
    (function(){
        const addAllBtn = document.getElementById('btnAddAllPages');
        const addAllCatsBtn = document.getElementById('btnAddAllCats');
        const addItemBtn = document.getElementById('btnAddItem');
        const pageBtns = Array.from(document.querySelectorAll('.btnAddPage'));
        const catBtns = Array.from(document.querySelectorAll('.btnAddCat'));
        function addItem(label, url){
            const wrap = document.querySelector('.menu-items');
            const div = document.createElement('div');
            div.className = 'p-3 bg-light rounded mb-2 menu-item-row';
            div.innerHTML = `
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm drag-handle" title="Drag" style="cursor:grab">
                            <span class="material-symbols-outlined fs-14">drag_indicator</span>
                        </button>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="label[]" value="${label||''}" placeholder="Label">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="url[]" value="${url||''}" placeholder="URL">
                        <input type="hidden" name="depth[]" value="0" class="depth-input">
                    </div>
                    <div class="col-3">
                        <input type="hidden" name="existing_image[]" value="">
                        <input type="file" class="form-control form-control-sm" name="image[]" accept="image/*">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-2 gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary btnOutdent" title="Outdent">
                        <span class="material-symbols-outlined fs-14">chevron_left</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary btnIndent" title="Indent">
                        <span class="material-symbols-outlined fs-14">chevron_right</span>
                    </button>
                    <button type="button" class="action-btn-danger btn-sm btnRemoveItem" title="Remove">
                        <span class="material-symbols-outlined fs-14">delete</span>
                    </button>
                </div>`;
            wrap.appendChild(div);
            bindRemoveButtons();
            bindIndentControls();
            updateIndentStyles();
        }
        function bindRemoveButtons(){
            document.querySelectorAll('.btnRemoveItem').forEach(btn => {
                if (!btn.dataset.bound) {
                    btn.dataset.bound = '1';
                    btn.addEventListener('click', function(){
                        const item = this.closest('.p-3.bg-light.rounded.mb-2');
                        if (item) item.remove();
                        updateIndentStyles();
                    });
                }
            });
        }
        function bindIndentControls(){
            document.querySelectorAll('.btnIndent').forEach(btn => {
                if (!btn.dataset.bound) {
                    btn.dataset.bound = '1';
                    btn.addEventListener('click', function(){
                        const item = this.closest('.menu-item-row');
                        const depthInput = item.querySelector('.depth-input');
                        let d = parseInt(depthInput.value || '0', 10);
                        if (d < 3) d++;
                        depthInput.value = d.toString();
                        updateIndentStyles();
                    });
                }
            });
            document.querySelectorAll('.btnOutdent').forEach(btn => {
                if (!btn.dataset.bound) {
                    btn.dataset.bound = '1';
                    btn.addEventListener('click', function(){
                        const item = this.closest('.menu-item-row');
                        const depthInput = item.querySelector('.depth-input');
                        let d = parseInt(depthInput.value || '0', 10);
                        if (d > 0) d--;
                        depthInput.value = d.toString();
                        updateIndentStyles();
                    });
                }
            });
        }
        function updateIndentStyles(){
            document.querySelectorAll('.menu-item-row').forEach(row => {
                const input = row.querySelector('.depth-input');
                let d = 0;
                if (input) {
                    d = parseInt(input.value || '0', 10);
                }
                const px = Math.max(0, Math.min(3, d)) * 24;
                row.style.marginLeft = px + 'px';
                row.style.borderLeft = '2px solid #e5e7eb';
            });
        }
        function initSortable(){
            if (typeof sortable === 'function') {
                try {
                    sortable(document.querySelector('.menu-items'), {
                        items: '.menu-item-row',
                        handle: '.drag-handle',
                        placeholderClass: 'sortable-ghost',
                        orientation: 'vertical'
                    });
                } catch(e) { console.warn('Sortable init failed', e); }
            }
        }
        addAllBtn?.addEventListener('click', () => {
            pageBtns.forEach(btn => addItem(btn.dataset.label, btn.dataset.url));
            initSortable();
            updateIndentStyles();
        });
        pageBtns.forEach(btn => btn.addEventListener('click', () => addItem(btn.dataset.label, btn.dataset.url)));
        addAllCatsBtn?.addEventListener('click', () => {
            catBtns.forEach(btn => addItem(btn.dataset.label, btn.dataset.url));
            initSortable();
            updateIndentStyles();
        });
        catBtns.forEach(btn => btn.addEventListener('click', () => addItem(btn.dataset.label, btn.dataset.url)));
        addItemBtn?.addEventListener('click', () => {
            addItem('', '');
            initSortable();
            updateIndentStyles();
        });
        bindRemoveButtons();
        bindIndentControls();
        initSortable();
        updateIndentStyles();
    })();
</script>
@endpush
@endsection

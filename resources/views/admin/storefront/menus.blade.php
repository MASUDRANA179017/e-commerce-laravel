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
            div.innerHTML = '<div class="row g-2 align-items-center"><div class="col-auto"><button type="button" class="btn btn-sm drag-handle" title="Drag" style="cursor:grab"><span class="material-symbols-outlined fs-14">drag_indicator</span></button></div><div class="col-5"><input type="text" class="form-control" name="label[]" value="'+(label||'')+'" placeholder="Label"></div><div class="col-7"><input type="text" class="form-control" name="url[]" value="'+(url||'')+'" placeholder="URL"><input type="hidden" name="depth[]" value="0" class="depth-input"></div></div><div class="d-flex justify-content-end mt-2 gap-2"><button type="button" class="btn btn-sm btn-outline-secondary btnOutdent" title="Outdent"><span class="material-symbols-outlined fs-14">chevron_left</span></button><button type="button" class="btn btn-sm btn-outline-secondary btnIndent" title="Indent"><span class="material-symbols-outlined fs-14">chevron_right</span></button><button type="button" class="action-btn-danger btn-sm btnRemoveItem" title="Remove"><span class="material-symbols-outlined fs-14">delete</span></button></div>';
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

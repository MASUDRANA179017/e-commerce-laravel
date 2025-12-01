@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

    @include('admin.business_settings.partials.all_attributes_css')

    <div class="row g-2">
        <div class="col-lg-5">
            <div class="panel h-100">
                <div class="panel-header">
                    <h3 class="panel-title">Attributes by Category</h3>
                    <select id="categoryFilter" class="form-select form-select-sm" style="max-width:220px;">
                        <option value="">-- Select a Category --</option>
                    </select>
                </div>
                <div class="panel-body scroll-col" id="attr-source">
                    <div class="initial-msg">
                        <i class='bx bx-category-alt' style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
                        <p>Please select a category to view attributes.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="panel h-100">
                <div class="panel-header">
                    <h3 class="panel-title">Attribute Sets</h3>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary" id="btnNewSet"><i class="bx bx-plus me-1"></i>New Set</button>
                        <button class="btn btn-warning " id="saveAttribute"><i class="bx bx-plus me-1"></i>Save
                            Attributtes</button>
                    </div>
                </div>
                <div class="panel-body scroll-col">
                    <div class="drop-wrap">
                        <div id="set-drop" class="drop-zone">
                            <div class="placeholder">
                                <i class='bx bx-collection ph-icon'></i>
                                <div class="ph-text">
                                    <span class="title">Drag values here to add to the newest set</span>
                                    <ul>
                                        <li>প্রথমে <b>New Set</b> বানান অথবা নিচের যেকোনো সেটের ড্রপ-জোনে ড্রপ করুন।</li>
                                        <li>রো-র <b>⋮</b> হ্যান্ডেল ধরে <b>ড্র্যাগ-সর্ট</b> করুন।</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="setsArea"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="termModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="termModalTitle">Manage Value</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="termModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSaveTerm">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="previewModalTitle">Set Preview</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewModalBody"></div>
            </div>
        </div>
    </div>

    @push('scripts')
   <script>
$(function () {
  // ---------- Globals ----------
  const ROUTES = {
    categories        : @json(route('catalog.categories.index')),
    attributes        : @json(route('catalog.attributes.index')), 
    attributeSetsIndex: @json(route('catalog.attribute_sets.index')),
    termsStore        : @json(route('catalog.terms.store')),
    attributeSetsSave : @json(route('catalog.attribute_sets.bulk_save')),
    attributeSetDelete : (id) => @json(url('catalog/attribute-sets')).replace(/\/$/,'') + '/' + id,
    termUpdate        : (id) => @json(url('catalog/terms')).replace(/\/$/,'') + '/' + id,
    termDelete        : (id) => @json(url('catalog/terms')).replace(/\/$/,'') + '/' + id,
  };
  const CSRF  = $('meta[name="csrf-token"]').attr('content') || '';
  const toast = Swal.mixin({ toast:true, position:'top-end', timer:1600, showConfirmButton:false });

  const $src           = $('#attr-source');
  const $setsArea      = $('#setsArea');
  const $categoryFilter= $('#categoryFilter');

  // Small helpers
  function ajaxJSON(url, method='GET', data) {
    return $.ajax({
      url, method,
      data: data ? JSON.stringify(data) : undefined,
      dataType: 'json',
      contentType: 'application/json',
      headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' }
    });
  }
  function ensureSortable(cb){
    if (window.Sortable) return cb();
    const s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js';
    s.onload = cb; s.onerror = ()=>{ console.warn('SortableJS failed to load.'); cb(); };
    document.head.appendChild(s);
  }
  function safeSortable(el, opts){ if (!el || !window.Sortable) return null; return new Sortable(el, opts); }

  // Cache attributes by id
  const ATTR_CACHE = {}; // { id: {id,slug,name,type,edit_fields,terms:[...] } }

  // ---------- UI builders ----------
  function getDynamicFormHTML(fields, term = {}, inline = false) {
    let h = inline ? '' : '<div class="form-grid">';
    if (fields.includes('name')) h += `<div><label class="form-label small">Name</label><input type="text" class="form-control form-control-sm" data-field="name" value="${term.name||''}"></div>`;
    if (fields.includes('code')) h += `<div><label class="form-label small">Code</label><input type="text" class="form-control form-control-sm" data-field="code" value="${term.code||''}"></div>`;
    if (fields.includes('unit')) h += `<div><label class="form-label small">Unit</label><select class="form-select form-select-sm" data-field="unit"><option value="">—</option><option value="EU" ${term.unit==='EU'?'selected':''}>EU</option><option value="US" ${term.unit==='US'?'selected':''}>US</option></select></div>`;
    if (fields.includes('color')) {
      h += `<div><label class="form-label small">Color</label><input type="color" class="form-control form-control-color w-100" data-field="color" value="${term.color||'#ffffff'}"></div>`;
      h += `<div class="form-check ms-1"><input class="form-check-input" type="checkbox" data-field="has_border" ${term.has_border?'checked':''} id="hasBorderChk"><label class="form-check-label small" for="hasBorderChk">Has Border</label></div>`;
    }
    return h + (inline ? '' : '</div>');
  }

  function createValuePill(term, attr, catSlug) {
    const $pill = $(`
      <div class="attr-pill is-draggable" data-attr-id="${attr.id}" data-term-id="${term.id}" data-cat-slug="${catSlug}">
        <div class="view-state">
          <span class="pill-icon"></span>
          <span class="pill-name">${term.name} <span class="small-muted">(${term.code ?? ''})</span></span>
          <span class="pill-actions">
            <button class="btn btn-sm btn-outline-secondary" data-action="edit-term"><i class='bx bxs-edit-alt'></i></button>
            <button class="btn btn-sm btn-outline-danger" data-action="delete-term"><i class='bx bxs-trash'></i></button>
          </span>
        </div>
        <div class="edit-state d-none">
          <div class="form-grid">${getDynamicFormHTML(attr.edit_fields || ['name','code'], term, true)}</div>
          <div class="edit-actions">
            <button class="btn btn-sm btn-cancel" data-action="cancel-edit"><i class='bx bx-x'></i></button>
            <button class="btn btn-sm btn-save" data-action="save-edit"><i class='bx bx-check'></i></button>
          </div>
        </div>
      </div>
    `);
    const icon = $pill.find('.pill-icon')[0];
    if (attr.type === 'swatch' && term.color) {
      icon.style.backgroundColor = term.color;
      icon.classList.add('has-color');
      if (term.has_border) icon.style.border = '1px solid #ccc';
    }
    return $pill[0];
  }

  function createAttributeCard(attr, catSlug) {
    const id = `pills-${attr.slug}-${catSlug}`;
    const $el = $(`
      <div class="source-card" data-attr-id="${attr.id}">
        <div class="attr-head">
          <div class="attr-name">${attr.name}</div>
          <span class="badge">${attr.terms_count} options</span>
        </div>
        <div class="pills-container" id="${id}"></div>
        <div class="new-attr-btn-wrap">
          <button class="btn btn-outline-secondary btn-sm w-100" data-action="new-term" data-attr-id="${attr.id}" data-cat-slug="${catSlug}">
            <i class='bx bx-plus'></i> Add New Value
          </button>
        </div>
      </div>
    `);
    const $container = $el.find('.pills-container');
    (attr.terms || []).forEach(t => $container.append(createValuePill(t, attr, catSlug)));
    safeSortable($container[0], { group:{name:'aset', pull:'clone', put:false}, animation:150, filter:'.edit-state' });
    return $el[0];
  }

  function renderLeftColumn(payload) {
    const { category, attributes } = payload;
    $src.empty();
    if (!attributes || !attributes.length) {
      $src.html(`<div class="initial-msg"><i class='bx bx-category-alt' style="font-size:2.5rem;margin-bottom:.5rem;"></i><p>No attributes for this category.</p></div>`);
      return;
    }
    Object.keys(ATTR_CACHE).forEach(k => delete ATTR_CACHE[k]);
    attributes.forEach(a => ATTR_CACHE[a.id] = a);
    attributes.forEach(a => $src.append(createAttributeCard(a, category.slug)));
  }

  // ---------- Modal & CRUD ----------
  const termModal = new bootstrap.Modal(document.getElementById('termModal'));
  function openTermModal(mode, ctx) {
    const { attrId, termId, catSlug, targetRow } = ctx;
    const attr = ATTR_CACHE[+attrId];
    const term = termId ? (attr.terms.find(t => +t.id === +termId) || {}) : {};

    $('#termModal').data({ mode, attrId, termId: termId || '', catSlug: catSlug || '', targetRowId: targetRow ? targetRow.id : '' });
    $('#termModalTitle').text(`${mode === 'add' ? 'Add' : 'Edit'} Value for "${attr.name}"`);
    $('#termModalBody').html(getDynamicFormHTML(attr.edit_fields || ['name','code'], term));

    const $name = $('#termModalBody [data-field="name"]');
    const $code = $('#termModalBody [data-field="code"]');
    if ($name.length && $code.length && mode === 'add') {
      let userEdited = false;
      $code.on('input', ()=> userEdited = true);
      $name.on('input', function(){
        if (userEdited) return;
        const v = ($(this).val()||'').toString().trim().replace(/[^A-Za-z0-9]+/g,'_').replace(/^_+|_+$/g,'').toUpperCase().slice(0,16);
        $code.val(v);
      });
    }
    termModal.show();
  }

  function saveTermFromModal() {
  const d = $('#termModal').data();
  const attr = ATTR_CACHE[+d.attrId];

  const payload = { attribute_id: +d.attrId };
  // ⬇️ collect every input/select with data-field (includes has_border)
  $('#termModalBody [data-field]').each(function () {
    const $el = $(this);
    const key = $el.data('field');
    payload[key] = ($el.attr('type') === 'checkbox') ? $el.is(':checked') : ($el.val() || '').trim();
  });

    if (d.mode === 'add') {
      ajaxJSON(ROUTES.termsStore,'POST',payload).done(res=>{
        attr.terms.push(res.term);
        attr.terms_count = (attr.terms_count||0)+1;
        const slug = $categoryFilter.val();
        if (slug) loadAttributesFor(slug);
        toast.fire({icon:'success', title:'Value saved!'});
        termModal.hide();
      }).fail(x=>{
        toast.fire({icon:'error', title:(x.responseJSON&&x.responseJSON.message)||'Save failed'});
      });
    } else {
      ajaxJSON(ROUTES.termUpdate(d.termId),'PATCH',payload).done(res=>{
        const up = res.term;
        const idx = attr.terms.findIndex(t=>+t.id===+d.termId);
        if (idx>-1) attr.terms[idx] = up;

        const $pill = $src.find(`.attr-pill[data-term-id="${d.termId}"]`);
        if ($pill.length){
          $pill.find('.pill-name').html(`${up.name} <span class="small-muted">(${up.code ?? ''})</span>`);
          if (attr.type==='swatch' && up.color){
            const icon = $pill.find('.pill-icon')[0];
            icon.style.backgroundColor = up.color;
            if (up.has_border) icon.style.border = '1px solid #ccc';
          }
        }
        $setsArea.find(`tbody tr[data-term-id="${d.termId}"]`).each(function(){
          const $row = $(this);
          let valueHTML = `${up.name} <span class="small-muted">(${up.code ?? ''})</span>`;
          if (attr.type==='swatch' && up.color) valueHTML = `<span class="swatch-icon" style="background-color:${up.color};"></span> ${valueHTML}`;
          $row.find('[data-col="value"]').html(valueHTML);
        });

        toast.fire({icon:'success', title:'Value updated!'});
        termModal.hide();
      }).fail(x=>{
        toast.fire({icon:'error', title:(x.responseJSON&&x.responseJSON.message)||'Update failed'});
      });
    }
  }

  function deleteTerm(attrId, termId){
    ajaxJSON(ROUTES.termDelete(termId),'DELETE').done(()=>{
      const attr = ATTR_CACHE[+attrId];
      const idx = attr.terms.findIndex(t=>+t.id===+termId);
      if (idx>-1) { attr.terms.splice(idx,1); attr.terms_count = Math.max(0,(attr.terms_count||1)-1); }

      const $pill = $src.find(`.attr-pill[data-term-id="${termId}"]`);
      if ($pill.length){
        const $card = $pill.closest('.source-card');
        $pill.remove();
        $card.find('.badge').text(`${attr.terms_count} options`);
      }
      $setsArea.find(`tbody tr[data-term-id="${termId}"]`).remove();
      toast.fire({icon:'success', title:'Value deleted.'});
    }).fail(x=>{
      toast.fire({icon:'error', title:(x.responseJSON&&x.responseJSON.message)||'Delete failed'});
    });
  }

  // ---------- Set table helpers ----------
  function makeRow(term, attr, catSlug){
    const typeColor = attr.type==='swatch' ? '#0d6efd' : '#6c757d';
    let valueHTML = `${term.name} <span class="small-muted">(${term.code ?? ''})</span>`;
    if (attr.type==='swatch' && term.color) valueHTML = `<span class="swatch-icon" style="background-color:${term.color};"></span> ${valueHTML}`;
    return $(`
      <tr id="set-row-${attr.slug}-${term.slug||term.id}-${term.id}" data-attr-id="${attr.id}" data-term-id="${term.id}" data-cat-slug="${catSlug}">
        <td class="drag-handle" style="cursor:grab;"><i class='bx bx-dots-vertical-rounded'></i></td>
        <td><span class="attr-type-badge" style="background:${typeColor}">${attr.type}</span></td>
        <td>${attr.name}</td>
        <td data-col="value">${valueHTML}</td>
        <td><input type="checkbox" class="form-check-input"></td>
        <td><input type="checkbox" class="form-check-input" checked></td>
        <td class="text-end">
          <button class="btn-icon" data-action="edit-set-term"><i class="bx bx-edit-alt"></i></button>
          <button class="btn-icon" data-action="delete-set-term"><i class="bx bx-trash"></i></button>
        </td>
      </tr>
    `);
  }

  function addDroppedItemToTbody(pillEl, $tbody){
    const $pill = $(pillEl);
    const attrId = +$pill.data('attrId');
    const termId = +$pill.data('termId');
    const catSlug= $pill.data('catSlug');

    if ($tbody.find(`tr[data-term-id="${termId}"]`).length){
      toast.fire({icon:'info', title:'This value is already in the set.'});
      return;
    }
    const attr = ATTR_CACHE[attrId];
    const term = (attr?.terms || []).find(t=>+t.id===termId);
    if (term) $tbody.append( makeRow(term, attr, catSlug) );
  }

  function onDrop(evt){
    const pill = evt.item;
    const $tbody = $(evt.to.tagName === 'TBODY' ? evt.to : $(evt.to).closest('.set-card').find('tbody')[0]);
    if ($tbody.length) addDroppedItemToTbody(pill, $tbody);
    $(pill).remove();
  }
  function onGlobalDrop(evt){
    const pill = evt.item;
    let $first = $setsArea.find('.set-card').first();
    if (!$first.length){ $first = $(createSetCard()); $setsArea.prepend($first); }
    const $tbody = $first.find('tbody');
    addDroppedItemToTbody(pill, $tbody);
    $(pill).remove();
  }

function createSetCard(name = 'Untitled Set', id = null, collapsed = false){
  const $card = $(`
    <div class="set-card mb-3">
      <div class="panel-header d-flex justify-content-between align-items-center">
        <div class="set-title d-flex align-items-center gap-2">
          <h5 class="m-0" data-title>Untitled Set</h5>
          <input class="form-control form-control-sm d-none" value="Untitled Set" data-title-input>
        </div>
        <div class="d-flex gap-2" data-actions-view>
          <button class="btn-icon" data-action="edit-set-name" title="Edit name"><i class="bx bx-edit-alt"></i></button>
          <button class="btn-icon" data-action="preview-set" title="Preview"><i class="bx bx-show"></i></button>
          <button class="btn-icon" data-action="delete-set" title="Delete"><i class="bx bx-trash"></i></button>
        </div>
        <div class="d-flex gap-2 d-none" data-actions-edit>
          <button class="btn-primary btn-sm" data-action="save-set-name"><i class="bx bx-save me-1"></i>Save</button>
          <button class="btn-icon" data-action="cancel-set-name" title="Cancel"><i class="bx bx-x"></i></button>
        </div>
      </div>
      <div class="set-dz"><i class='bx bx-move'></i><span>Drop values here</span></div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr>
            <th style="width:20px;"></th>
            <th>Type</th><th>Attribute</th><th>Value</th>
            <th>Variant?</th><th>Filter?</th><th class="text-end">Actions</th>
          </tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  `);

  // apply provided name and id safely
  $card.find('[data-title]').text(name || 'Untitled Set');
  $card.find('[data-title-input]').val(name || 'Untitled Set');
  if (id) $card.attr('data-set-id', id);

  // wire up DnD
  const tbody = $card.find('tbody')[0];
  const dz    = $card.find('.set-dz')[0];
  [tbody, dz].forEach(el => safeSortable(el, { group:{name:'aset',put:true}, animation:150, handle:'.drag-handle', onAdd:onDrop }));

  // optional collapsed view (table hidden on load)
  if (collapsed) {
    $card.find('.table-responsive').addClass('d-none');
    // keep drop-zone visible or hide if you prefer
    // $card.find('.set-dz').addClass('d-none');
  }

  return $card;
}


  function openPreview($setCard){
    const name = $.trim($setCard.find('[data-title]').text());
    const $rows = $setCard.find('tbody tr');
    $('#previewModalTitle').text(`Set Preview: ${name}`);
    if (!$rows.length) {
      $('#previewModalBody').html(`<div class="text-center p-3">No values added to this set.</div>`);
    } else {
      const html = $rows.map(function(){
        const $tr = $(this);
        return `
          <tr>
            <td>${$tr.find('td:nth-child(2)').text()}</td>
            <td>${$tr.find('td:nth-child(3)').text()}</td>
            <td>${$.trim($tr.find('[data-col="value"]').text())}</td>
          </tr>`;
      }).get().join('');
      $('#previewModalBody').html(`<table class="table table-sm table-bordered"><thead><tr><th>Type</th><th>Attribute</th><th>Value</th></tr></thead><tbody>${html}</tbody></table>`);
    }
    new bootstrap.Modal('#previewModal').show();
  }

  // ---------- Data loads ----------
  function loadCategories(){
    return ajaxJSON(ROUTES.categories,'GET').done(res=>{
      $categoryFilter.html(`<option value="">-- Select a Category --</option>`);
      (res.categories||[]).forEach(c => $categoryFilter.append(`<option value="${c.slug}">${c.name}</option>`));
    });
  }
  function loadAttributesFor(slug){
    $src.html(`<div class="initial-msg"><i class='bx bx-loader-alt bx-spin' style="font-size:2rem"></i><p>Loading...</p></div>`);
    return ajaxJSON(`${ROUTES.attributes}?category=${encodeURIComponent(slug)}`,'GET').done(renderLeftColumn);
  }

  // ---------- Events ----------
  // Press Enter in modal -> Save
  $('#termModal').on('keydown', function(ev){
    const tag = ev.target && ev.target.tagName;
    if (ev.key === 'Enter' && (tag === 'INPUT' || tag === 'SELECT')) {
      ev.preventDefault(); $('#btnSaveTerm').trigger('click');
    }
  });

  // Left column actions (inline edit/new/delete)
  $(document).on('click', '#attr-source [data-action]', async function () {
    const $btn = $(this);
    const action = $btn.data('action');
    const $pill = $btn.closest('.attr-pill');

    if (action === 'new-term') {
      openTermModal('add', { attrId: $btn.data('attrId'), catSlug: $btn.data('catSlug') });
      return;
    }
    if (!$pill.length) return;

    const toggle = (show)=> {
      $pill.toggleClass('is-draggable', !show);
      $pill.find('.view-state').toggleClass('d-none', show);
      $pill.find('.edit-state').toggleClass('d-none', !show);
      if (show) $pill.find('[data-field="name"]').trigger('focus');
    };

    if (action === 'edit-term') toggle(true);
    else if (action === 'cancel-edit') toggle(false);
    else if (action === 'save-edit') {
      const attrId = +$pill.data('attrId'), termId = +$pill.data('termId');
      const attr   = ATTR_CACHE[attrId];
      const fields = attr.edit_fields || ['name','code'];
      const body   = {};
      fields.forEach(f=>{
        const $inp = $pill.find(`[data-field="${f}"]`);
        body[f] = ($inp.attr('type')==='checkbox') ? $inp.is(':checked') : ($inp.val()||'').trim();
      });
      ajaxJSON(ROUTES.termUpdate(termId),'PATCH',body).done(res=>{
        const up = res.term;
        const idx = attr.terms.findIndex(t=>+t.id===termId);
        if (idx>-1) attr.terms[idx]=up;
        $pill.find('.pill-name').html(`${up.name} <span class="small-muted">(${up.code ?? ''})</span>`);
        if (attr.type==='swatch' && up.color){
          const icon = $pill.find('.pill-icon')[0];
          icon.style.backgroundColor = up.color;
          if (up.has_border) icon.style.border = '1px solid #ccc';
        }
        toggle(false);
        toast.fire({icon:'success', title:'Value updated!'});
      }).fail(x=> toast.fire({icon:'error', title:(x.responseJSON&&x.responseJSON.message)||'Update failed'}));
    }
    else if (action === 'delete-term') {
      const ask = await Swal.fire({ title:'Delete this value?', icon:'warning', showCancelButton:true, confirmButtonColor:'#d33', confirmButtonText:'Delete' });
      if (ask.isConfirmed) deleteTerm($pill.data('attrId'), $pill.data('termId'));
    }
  });

  // Sets area actions
  $(document).on('click', '#setsArea [data-action]', function(){
    const $btn = $(this);
    const action = $btn.data('action');
    const $card = $btn.closest('.set-card');
    const $row  = $btn.closest('tr');

    if ($card.length && !$row.length) {
      const $title = $card.find('[data-title]'), $input = $card.find('[data-title-input]');
      const $v = $card.find('[data-actions-view]'), $e = $card.find('[data-actions-edit]');
      const toggle = on => { $title.toggleClass('d-none', on); $input.toggleClass('d-none', !on); $v.toggleClass('d-none', on); $e.toggleClass('d-none', !on); if (on) $input.trigger('select'); };

      if (action==='edit-set-name') toggle(true);
      else if (action==='cancel-set-name') { $input.val($title.text()); toggle(false); }
      else if (action==='save-set-name')   { $title.text($.trim($input.val())||'Untitled Set'); toggle(false); }
      else if (action==='preview-set')     { openPreview($card); }
     else if (action==='delete-set') {
  Swal.fire({
    title:'Delete this set?', icon:'warning',
    showCancelButton:true, confirmButtonColor:'#d33', confirmButtonText:'Delete'
  }).then(res=>{
    if (!res.isConfirmed) return;

    const id = $card.attr('data-set-id');
    if (!id) { // not saved yet → UI only
      $card.remove();
      toast.fire({icon:'success', title:'Set removed'});
      return;
    }
    ajaxJSON(ROUTES.attributeSetDelete(id), 'DELETE')
      .done(()=>{ $card.remove(); toast.fire({icon:'success', title:'Set deleted'}); })
      .fail(x=>{
        const msg = (x.responseJSON && x.responseJSON.message) || 'Delete failed';
        Swal.fire({icon:'error', title: msg});
      });
  });
}

      return;
    }

    if ($row.length) {
      if (action==='delete-set-term') $row.remove();
      else if (action==='edit-set-term') {
        openTermModal('edit', { attrId:$row.data('attrId'), termId:$row.data('termId'), targetRow:$row[0] });
      }
    }
  });

  // Buttons & inputs
  $('#btnNewSet').on('click', () => $setsArea.prepend(createSetCard()));
  $('#btnSaveTerm').on('click', saveTermFromModal);
  $categoryFilter.on('change', function(){ const slug = $(this).val(); slug ? loadAttributesFor(slug) : $src.html(`<div class="initial-msg"><i class='bx bx-category-alt' style="font-size:2.5rem;margin-bottom:.5rem;"></i><p>Please select a category to view attributes.</p></div>`); });

  // Global drop zones
  function setupDnD(){
    safeSortable($setsArea[0], { handle:'.panel-header', animation:150 });
    safeSortable($('#set-drop')[0], { group:{name:'aset',put:true}, animation:150, onAdd:onGlobalDrop });
  }

  // Save Attribute Sets
  function serializeSets() {
    const sets = [];
    const catSlug = $categoryFilter.val() || null;
    $setsArea.find('.set-card').each(function(){
      const $c = $(this);
      const name = $.trim($c.find('[data-title]').text()) || 'Untitled Set';
      const idRaw= $c.attr('data-set-id');
      const id   = idRaw ? parseInt(idRaw,10) : null;

      const items = [];
      $c.find('tbody tr').each(function(idx){
        const $tr = $(this);
        const $ch = $tr.find('input.form-check-input');
        items.push({
          attribute_id      : parseInt($tr.data('attrId'),10),
          attribute_term_id : parseInt($tr.data('termId'),10),
          is_variant        : $ch.eq(0).is(':checked'),
          is_filter         : $ch.eq(1).length ? $ch.eq(1).is(':checked') : true,
          sort_order        : idx
        });
      });

      sets.push({ id, name, category_slug: catSlug, items });
    });
    return { sets };
  }
  $(document).on('click', '#saveAttribute', function(e){
    e.preventDefault();
    const payload = serializeSets();
    if (!payload.sets.length) { toast.fire({icon:'info', title:'No sets to save'}); return; }
    ajaxJSON(ROUTES.attributeSetsSave,'POST',payload).done(res=>{
      $.each(res.sets || [], function(i,s){
        const $card = $setsArea.find('.set-card').eq(i);
        if ($card.length) $card.attr('data-set-id', s.id);
      });
      toast.fire({icon:'success', title:'Attribute sets saved!'});
    }).fail(x=>{
      toast.fire({icon:'error', title:(x.responseJSON&&x.responseJSON.message)||'Save failed'});
    });
  });

  // ---------- Init ----------
function loadExistingSets(){
    const $setsArea = $('#setsArea');
    $setsArea.html(
      `<div class="initial-msg"><i class='bx bx-loader-alt bx-spin' style="font-size:2rem"></i><p>Loading saved sets...</p></div>`
    );
    return ajaxJSON(ROUTES.attributeSetsIndex,'GET').done(res=>{
      $setsArea.empty();
      (res.sets||[]).forEach(set => {
        // collapsed by default:
        const $card = createSetCard(set.name, set.id, false);
        $setsArea.append($card);
        const $tbody = $card.find('tbody');
        (set.items||[]).forEach(it => {
          const attr = { id: it.attribute.id, name: it.attribute.name, type: it.attribute.type, slug: it.attribute.slug };
          const term = it.term ? { id: it.term.id, name: it.term.name, code: it.term.code, color: it.term.color } : { id: 0, name: '-', code: '' };
          const $row = makeRow(term, attr, null);
          const $checks = $row.find('input.form-check-input');
          $checks.eq(0).prop('checked', !!it.is_variant);
          $checks.eq(1).prop('checked', !!it.is_filter);
          $tbody.append($row);
        });
      });
      if (!$('#setsArea').children().length) {
        $('#setsArea').html('<div class="initial-msg">No saved attribute sets yet.</div>');
      }
    });
  }

  // 3) On init, load categories + existing sets (then setup DnD)
  ensureSortable(function(){
    $.when(loadCategories(), loadExistingSets()).then(setupDnD); // setupDnD: your existing function
  });
});
</script>

       
    @endpush

@endsection

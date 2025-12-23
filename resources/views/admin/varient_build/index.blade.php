@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<style>
  :root{
    --line:#e5e7eb; --muted:#6b7280; --radius:14px;
    --primary:26,86,219;
  }
  body{background:#f6f8fb}
  .page-top{position:sticky;top:0;z-index:4;background:var(--bs-body-bg);padding:10px 0 12px}

  .card{border-radius:var(--radius);border:1px solid var(--line)}
  .small-muted{font-size:.85rem;color:var(--muted)}
  .pill{display:inline-flex;align-items:center;gap:.4rem;padding:.25rem .55rem;border:1px solid var(--line);border-radius:999px;font-size:.8rem;background:#fff}
  .kbd{border:1px solid var(--line);border-bottom-width:2px;border-radius:.4rem;padding:.1rem .35rem;font-size:.8rem;background:#fff}
  .table thead th{white-space:nowrap}
  .table td,.table th{vertical-align:middle}
  .form-hint{font-size:.8rem;color:#6b7280}
  .badge-soft{background:rgba(var(--primary),.08);color:rgb(var(--primary));border:1px solid rgba(var(--primary),.15)}
  .icon-btn{border:1px solid var(--line);background:#fff;border-radius:.6rem;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center}
  .icon-btn:hover{box-shadow:0 .1rem .35rem rgba(0,0,0,.08)}
  .opt-note{font-size:.85rem;color:#64748b}
  .chip{display:inline-flex;align-items:center;gap:.4rem;background:#fff;border:1px solid var(--line);border-radius:.6rem;padding:.25rem .5rem;font-size:.8rem}
  .divider{height:1px;background:var(--line);margin:10px 0}
  .required:after{content:"*";color:#ef4444;margin-left:.2rem}
  .sticky-side{position:sticky;top:80px}
  .list-unstyled{margin:0;padding:0;list-style:none}
  .rotate-180{transform:rotate(180deg)}
</style>

  <div class="row">
    <!-- LEFT: Controls (unchanged layout) -->
    <div class="col-lg-4">
      <div class="card sticky-side">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0">Variant Set</h6>
            <span class="pill"><i class="bx bx-cog"></i> Builder</span>
          </div>

          <div class="mb-3">
            <label class="form-label required">Variant Set Name</label>
            <input type="text" class="form-control" id="setName" placeholder="e.g., T-Shirt Variants">
          </div>

          <div class="mb-3">
            <label class="form-label">SKU Prefix</label>
            <input type="text" class="form-control" id="skuPrefix" placeholder="e.g., T-SHIRT">
            <div class="form-hint">Will be used when generating SKUs (e.g., <span class="kbd">T-SHIRT-RED-M</span>)</div>
          </div>

          <div class="mb-3">
            <label class="form-label required">Scope — Business Category</label>
            <select id="bizSelect" class="form-select">
              <option value="">Select business</option>
            </select>
            <div class="form-hint">Filters Attribute Sets.</div>
          </div>

          <div class="mb-3">
            <label class="form-label required">Attribute Set</label>
            <select id="attrSetSelect" class="form-select" disabled>
              <option value="">Select attribute set</option>
            </select>
            <div class="form-hint">Choose which attributes will be used to generate variants.</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Media Rules <span class="small-muted">(multi-select)</span></label>
            <select id="mediaRules" class="form-select" multiple size="3">
              <option value="size_chart">Require size chart</option>
              <option value="image_by_size">Variant image by Size</option>
              <option value="image_by_color">Variant image by Color</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Variant Rules</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="unique_sku" id="ruleUnique">
              <label class="form-check-label" for="ruleUnique">Require unique SKU</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="price_by_variant" id="rulePrice">
              <label class="form-check-label" for="rulePrice">Variant wise Price</label>
            </div>
          </div>

          <div class="d-grid gap-2">
            <button class="create-btn-base" id="btnGenerate"><i class="bx bx-grid-alt me-1"></i>Generate Variants</button>
            <button class="create-btn-white" id="btnReset"><i class="bx bx-reset me-1"></i>Reset</button>
            <button class="create-btn-success" id="btnSave"><i class="bx bx-save me-1"></i>Save Variant Set</button>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Variant Card (collapsible + inline title edit) -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between" id="variantHeader">
            <div class="d-flex align-items-center gap-2">
              <button class="icon-btn" id="toggleCard" aria-label="Collapse">
                <i class="bx bx-chevron-up" id="toggleIcon"></i>
              </button>

              <div class="set-title d-flex align-items-center gap-2">
                <h6 class="mb-0" data-title>Variant Card</h6>
                <input class="form-control form-control-sm d-none" value="Variant Card" data-title-input>
              </div>
            </div>

            <div class="d-flex align-items-center gap-2">
              <div class="d-flex gap-2" data-actions-view>
                <button class="icon-btn" data-action="edit-card-title" title="Edit title"><i class="bx bx-edit-alt"></i></button>
              </div>
              <div class="d-flex gap-2 d-none" data-actions-edit>
                <button class="btn btn-primary btn-sm" data-action="save-card-title"><i class="bx bx-save me-1"></i>Save</button>
                <button class="icon-btn" data-action="cancel-card-title" title="Cancel"><i class="bx bx-x"></i></button>
              </div>
              <span class="chip"><i class="bx bx-purchase-tag-alt"></i> <span id="variantCount">0</span> variants</span>
            </div>
          </div>
          <div class="small-muted">Assign later using your existing flow. Use buttons below.</div>

          <div id="variantPanel">
            <div class="divider"></div>

            <div class="row g-3 align-items-start">
              <div class="col-md-7">
                <!-- External Assign Buttons (keep your existing modals/actions) -->
                <div class="d-flex flex-wrap gap-2">
                  <button class="select-btn-primary" id="btnAssignCategories">
                    <i class="bx bx-category-alt me-1"></i>Assign Categories
                  </button>
                  <button class="select-btn-white d-none" id="btnAssignSizeChart">
                    <i class="bx bx-spreadsheet me-1"></i>Assign Size Chart
                  </button>
                </div>
                <div class="form-hint mt-1">Opens the modals/actions already present in your codebase.</div>
              </div>
              <div class="col-md-5">
                <label class="form-label">Selected Rules (Preview)</label>
                <ul id="rulesPreview" class="list-unstyled">
                  <li class="opt-note">—</li>
                </ul>
                <div class="mt-2">
                  <span class="qbit-badge-light me-1" id="bizBadge" style="display:none"></span>
                  <span class="qbit-badge-light" id="attrSetBadge" style="display:none"></span>
                </div>
                <div class="mt-3 opt-note">
                  Price & Quantity will be managed from Inventory/Purchase; Images from Product Add — hidden here.
                </div>
              </div>
            </div>

            <div class="divider"></div>

            <div class="table-responsive">
              <table class="table align-middle mb-0" id="variantsTable">
                <thead>
                  <tr>
                    <th style="width:60px">#</th>
                    <th>Variant</th>
                    <th style="width:280px">SKU</th>
                    <th style="width:80px">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-muted" id="emptyRow">
                    <td colspan="4">
                      <div class="d-flex align-items-center gap-2">
                        <i class="bx bx-info-circle"></i>
                        <span>No variants yet. Click <b>Generate Variants</b>.</span>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="mt-2 d-flex align-items-center justify-content-between">
              <div class="small-muted">SKUs must be unique if that rule is enabled.</div>
              <div id="skuError" class="text-danger small d-none"><i class="bx bx-error-circle me-1"></i>Duplicate SKUs detected.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
<script>
/** =========================
 * Demo data (replace with API/DB in production)
 * ========================= */
// const BUSINESSES = [
//   "Clothing","Phone","Laptop","Electronic Item","Organic Food","Eyewear","Cosmetic","Gadget","Gift Item","Sports Item","Adventure Gear Item","Animal Food & Accessories"
// ];
  const BUSINESSES = @json($categories);


const ATTRIBUTE_SETS = @json($attribute_sets);

/** =========================
 * State
 * ========================= */
let variants = []; // {id, label, sku, options:[{attrId, attrName, termId, termName, code}]}
let requireUniqueSKU = false;

const $ = (sel, root=document) => root.querySelector(sel);
const $$ = (sel, root=document) => Array.from(root.querySelectorAll(sel));

/** =========================
 * Helpers
 * ========================= */
function slugCode(s){
  return String(s||"").trim().replace(/[^A-Za-z0-9]+/g,'-').replace(/^-+|-+$/g,'').toUpperCase().slice(0,16);
}
function ensureUniqueSKUs(){
  const seen = new Map();
  let duplicate = false;
  variants.forEach(v => {
    const key = v.sku.trim().toUpperCase();
    if(seen.has(key)){ duplicate = true; }
    seen.set(key, true);
  });
  $('#skuError').classList.toggle('d-none', !(requireUniqueSKU && duplicate));
  $('#btnSave').disabled = (requireUniqueSKU && duplicate);
}
function renderRulesPreview(){
  const ul = $('#rulesPreview'); ul.innerHTML = "";
  const mediaSel = $$('#mediaRules option:checked').map(o=>o.textContent);
  const rules = [];
  if(mediaSel.length){ rules.push(`<li><span class="pill"><i class='bx bx-image'></i> ${mediaSel.join(', ')}</span></li>`); }
  if($('#ruleUnique').checked){ rules.push(`<li><span class="pill"><i class='bx bx-purchase-tag'></i> Require unique SKU</span></li>`); }
  if($('#rulePrice').checked){ rules.push(`<li><span class="pill"><i class='bx bx-money'></i> Variant wise Price</span></li>`); }
  ul.innerHTML = rules.length ? rules.join('') : "<li class='opt-note'>—</li>";
  // Toggle visibility of Assign Size Chart button
  const needsSizeChart = $$('#mediaRules option:checked').some(o => o.value === 'size_chart');
  $('#btnAssignSizeChart').classList.toggle('d-none', !needsSizeChart);
}
function populateBusinesses(){
  const sel = $('#bizSelect');
  BUSINESSES.forEach(b => {
    const op = document.createElement('option'); op.value = b.id; op.textContent = b.name; sel.appendChild(op);
  });
}
function getSelectedAttrSet(){
  const id = $('#attrSetSelect').value;
  return ATTRIBUTE_SETS.find(s => String(s.id)===String(id)) || null;
}
function populateAttrSets(bizId){
  const sel = $('#attrSetSelect');
  if (!sel) return;
  sel.innerHTML = '<option value="">Select attribute set</option>';
  let list = bizId ? ATTRIBUTE_SETS.filter(s => String(s.category_id)===String(bizId)) : ATTRIBUTE_SETS.slice();
  if (bizId && list.length === 0) {
    list = ATTRIBUTE_SETS.slice();
  }
  list.forEach(s => {
    const op = document.createElement('option'); op.value = s.id; op.textContent = s.name; sel.appendChild(op);
  });
  sel.disabled = list.length === 0;
}
function buildLabelFromOptions(opts){
  return opts.map(o => `${o.attrName}: ${o.termName}`).join(' / ');
}
function generateSKUSuffixFromOptions(opts){
  return opts.map(o => o.code || slugCode(o.termName)).join('-');
}
function renderVariantsTable(){
  const tbody = $('#variantsTable tbody');
  tbody.innerHTML = "";
  if(!variants.length){
    const tr = document.createElement('tr'); tr.className="text-muted";
    tr.innerHTML = `<td colspan="4"><div class="d-flex align-items-center gap-2"><i class="bx bx-info-circle"></i><span>No variants yet. Click <b>Generate Variants</b>.</span></div></td>`;
    tbody.appendChild(tr);
  } else {
    variants.forEach((v, idx) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${idx+1}</td>
        <td>${v.label}</td>
        <td>
          <input class="form-control form-control-sm sku-input" data-vid="${v.id}" value="${v.sku}">
          <div class="form-hint">Edit if needed</div>
        </td>
        <td class="text-end">
          <button class="icon-btn btn-remove" data-vid="${v.id}" title="Remove"><i class="bx bx-trash"></i></button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }
  $('#variantCount').textContent = variants.length;
  ensureUniqueSKUs();
}
function cartesianProduct(arrays){
  return arrays.reduce((acc, curr) => acc.flatMap(a => curr.map(b => a.concat([b]))), [[]]);
}

/** =========================
 * Events
 * ========================= */
// Collapse toggle
document.getElementById('toggleCard').addEventListener('click', () => {
  const panel = document.getElementById('variantPanel');
  const icon = document.getElementById('toggleIcon');
  const isHidden = panel.style.display === 'none';
  panel.style.display = isHidden ? '' : 'none';
  icon.classList.toggle('rotate-180', !isHidden);
});

// Inline title edit on Variant Card header
document.getElementById('variantHeader').addEventListener('click', (e) => {
  const target = e.target.closest('[data-action]');
  if(!target) return;
  const action = target.dataset.action;
  const header = document.getElementById('variantHeader');
  const titleEl = header.querySelector('[data-title]');
  const inputEl = header.querySelector('[data-title-input]');
  const actionsView = header.querySelector('[data-actions-view]');
  const actionsEdit = header.querySelector('[data-actions-edit]');
  const toggleTitleEdit = (on) => {
    titleEl.classList.toggle('d-none', on);
    inputEl.classList.toggle('d-none', !on);
    actionsView.classList.toggle('d-none', on);
    actionsEdit.classList.toggle('d-none', !on);
    if(on){ inputEl.focus(); inputEl.select(); }
  };

  if(action === 'edit-card-title'){ toggleTitleEdit(true); }
  else if(action === 'cancel-card-title'){ inputEl.value = titleEl.textContent; toggleTitleEdit(false); }
  else if(action === 'save-card-title'){
    const val = inputEl.value.trim() || 'Variant Card';
    titleEl.textContent = val; toggleTitleEdit(false);
  }
});

// Save on Enter key within the input
document.querySelector('#variantHeader [data-title-input]').addEventListener('keydown', (e) => {
  if(e.key === 'Enter'){
    const saveBtn = document.querySelector('#variantHeader [data-action=\"save-card-title\"]');
    if(saveBtn){ saveBtn.click(); }
  }
});

document.addEventListener('change', (ev) => {
  if(ev.target.id === 'bizSelect'){
    const biz = ev.target.value;
    populateAttrSets(biz || null);
    // Badge
    const cat = BUSINESSES.find(b => String(b.id)===String(biz));
    $('#bizBadge').textContent = (cat ? cat.name : "") || "";
    $('#bizBadge').style.display = biz ? 'inline-block':'none';
    $('#attrSetBadge').style.display = 'none';
  }
  if(ev.target.id === 'attrSetSelect'){
    const set = getSelectedAttrSet();
    $('#attrSetBadge').textContent = set ? set.name : "";
    $('#attrSetBadge').style.display = set ? 'inline-block':'none';
  }
  if(ev.target.id === 'mediaRules' || ev.target.id === 'ruleUnique' || ev.target.id === 'rulePrice'){
    requireUniqueSKU = $('#ruleUnique').checked;
    renderRulesPreview();
    ensureUniqueSKUs();
  }
});

document.addEventListener('input', (ev) => {
  if(ev.target.classList.contains('sku-input')){
    const id = ev.target.getAttribute('data-vid');
    const v = variants.find(x => String(x.id)===String(id));
    if(v){ v.sku = ev.target.value.trim(); }
    ensureUniqueSKUs();
  }
});

// External modals (keep your ids or update in functions)
function openAssignCategories(){
  const ids = ['assignCategoriesModal','categoryAssignModal','categoriesAssignModal'];
  for(const id of ids){
    const el = document.getElementById(id);
    if(el){
      if(window.bootstrap && bootstrap.Modal){
        new bootstrap.Modal(el).show();
      }else if(typeof $ !== 'undefined' && typeof jQuery !== 'undefined'){
        jQuery(el).modal('show');
      }else{
        el.style.display='block';
      }
      return true;
    }
  }
  alert('Assign Categories modal not found. Please wire #assignCategoriesModal (or update ids).');
  return false;
}
document.getElementById('btnAssignCategories').addEventListener('click', openAssignCategories);

function openAssignSizeChart(){
  const ids = ['sizeChartAssignModal','sizeChartModal','assignSizeChartModal'];
  for(const id of ids){
    const el = document.getElementById(id);
    if(el){
      if(window.bootstrap && bootstrap.Modal){
        new bootstrap.Modal(el).show();
      }else if(typeof $ !== 'undefined' && typeof jQuery !== 'undefined'){
        jQuery(el).modal('show');
      }else{
        el.style.display='block';
      }
      return true;
    }
  }
  alert('Assign Size Chart modal not found. Please wire #sizeChartAssignModal (or update ids).');
  return false;
}
document.getElementById('btnAssignSizeChart').addEventListener('click', openAssignSizeChart);

document.getElementById('btnGenerate').addEventListener('click', () => {
  const biz = document.getElementById('bizSelect').value;
  const set = getSelectedAttrSet();
  const prefix = document.getElementById('skuPrefix').value.trim();
  if(!biz){ return alert('Please select a Business Category.'); }
  if(!set){ return alert('Please select an Attribute Set.'); }
  const perAttr = set.attributes.map(attr => attr.terms.map(t => ({
    attrId: attr.id, attrName: attr.name, termId: t.id, termName: t.name, code: t.code || slugCode(t.name)
  })));
  const combos = cartesianProduct(perAttr);
  variants = combos.map((opts, i) => {
    const label = buildLabelFromOptions(opts);
    const suffix = generateSKUSuffixFromOptions(opts);
    const sku = (prefix ? (slugCode(prefix) + '-') : '') + suffix;
    return { id: Date.now() + '-' + i, label, sku, options: opts };
  });
  renderVariantsTable();
});

document.getElementById('btnReset').addEventListener('click', () => {
  variants = [];
  renderVariantsTable();
});

document.getElementById('variantsTable').addEventListener('click', (ev) => {
  const btn = ev.target.closest('.btn-remove');
  if(btn){
    const id = btn.getAttribute('data-vid');
    variants = variants.filter(v => String(v.id)!==String(id));
    renderVariantsTable();
  }
});

document.getElementById('btnSave').addEventListener('click', () => {
  const name = document.getElementById('setName').value.trim();
  const biz = document.getElementById('bizSelect').value;
  const set = getSelectedAttrSet();
  if(!name) return alert('Variant Set Name is required.');
  if(!biz) return alert('Business Category is required.');
  if(!set) return alert('Attribute Set is required.');
  const media = Array.from(document.querySelectorAll('#mediaRules option:checked')).map(o => o.value);
  if (!variants.length) { alert('Generate variants first.'); return; }
  const payload = {
    name,
    sku_prefix: document.getElementById('skuPrefix').value.trim(),
    business: biz,
    attribute_set_id: set.id,
    media_rules: media,
    variant_rules: {
      unique_sku: document.getElementById('ruleUnique').checked,
      price_by_variant: document.getElementById('rulePrice').checked
    },
    assign_later: {
      categories: true,
      size_chart: media.includes('size_chart')
    },
    variants: variants.map(v => ({
      sku: v.sku, label: v.label, options: v.options.map(o => ({
        attribute_id:o.attrId, attribute_name:o.attrName,
        term_id:o.termId, term_name:o.termName, code:o.code
      }))
    }))
  };
  fetch('{{ route('admin.users.varient-build.store') }}', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]')?.content || ''),
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(payload)
  }).then(async (res) => {
    if(!res.ok){
      let err = {};
      let text = '';
      try { err = await res.json(); } catch { try { text = await res.text(); } catch {} }
      if (window.toastr && typeof toastr.error === 'function') {
        toastr.error((err && err.message) || text || 'Failed to save Variant Set.');
      } else {
        alert((err && err.message) || text || 'Failed to save Variant Set.');
      }
      return;
    }
    const out = await res.json().catch(()=>null);
    if (window.toastr && typeof toastr.success === 'function') {
      toastr.success((out && out.message) || 'Variant Set saved');
    } else {
      alert((out && out.message) || 'Variant Set saved');
    }
    variants = [];
    renderVariantsTable();
  }).catch(() => alert('Failed to save Variant Set.'));
});

/** =========================
 * Init
 * ========================= */
populateBusinesses();
populateAttrSets(null);
renderRulesPreview();
renderVariantsTable();
</script>

<!-- Assign Categories Modal (inline) -->
<div class="modal fade" id="assignCategoriesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-category-alt me-2"></i>Assign Categories</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2 small-muted">Pick a business category context:</div>
        <select id="assignBizSelect" class="form-select">
          <option value="">— Select —</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
  <script>
    (function(){
      const sel = document.getElementById('assignBizSelect');
      (BUSINESSES||[]).forEach(b => {
        const op = document.createElement('option'); op.value = b.id; op.textContent = b.name; sel.appendChild(op);
      });
      sel.addEventListener('change', () => {
        const val = sel.value;
        if (val) {
          const bizSel = document.getElementById('bizSelect');
          if (bizSel) {
            const changed = String(bizSel.value) !== String(val);
            bizSel.value = val;
            if (changed) bizSel.dispatchEvent(new Event('change'));
          }
        }
      });
    })();
  </script>
</div>

@endpush

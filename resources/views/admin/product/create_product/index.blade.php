@extends('layouts.master')
@section('title', isset($isEdit) && $isEdit ? 'Edit Product' : 'Create Product')
@section('content')
    @include('admin.product.partials.create-product.create-product-css')

    <div class="container-fluid my-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h3 class="mb-0">{{ isset($isEdit) && $isEdit ? 'Edit Product' : 'Create Product' }}</h3>
                <div class="small-muted">
                    @if(isset($isEdit) && $isEdit)
                        Edit product details, media, attributes and variants
                    @else
                        Category কনফিগ, Media Rule ও Variant Rule অনুযায়ী ফর্ম ডাইনামিক হবে
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary" id="btnSaveDraft"><i class="bx bx-save me-1"></i>Save
                    Draft</button>
                <button type="button" class="btn btn-primary" id="btnPublish"><i
                        class="bx bx-rocket me-1"></i>Publish</button>
            </div>
        </div>

        <!-- Wizard -->
        <div class="qb-wizard-nav" id="wizard-nav">
            <div class="qb-wizard-tab is-active" data-target="#tab-basic">
                <div class="qb-wizard-tab-icon"><i class="bx bx-info-circle"></i></div>
                <div>
                    <h6 class="mb-0">Basic</h6><span class="small-muted">title, brand, categories</span>
                </div>
            </div>
            <div class="qb-wizard-tab" data-target="#tab-media">
                <div class="qb-wizard-tab-icon"><i class="bx bx-image-alt"></i></div>
                <div>
                    <h6 class="mb-0">Media</h6><span class="small-muted">gallery, rule</span>
                </div>
            </div>
            <div class="qb-wizard-tab" data-target="#tab-attrs">
                <div class="qb-wizard-tab-icon"><i class="bx bx-grid-alt"></i></div>
                <div>
                    <h6 class="mb-0">Attributes</h6><span class="small-muted">set & terms</span>
                </div>
            </div>
            <div class="qb-wizard-tab" data-target="#tab-variants">
                <div class="qb-wizard-tab-icon"><i class="bx bx-intersect"></i></div>
                <div>
                    <h6 class="mb-0">Variants</h6><span class="small-muted">rule, SKU</span>
                </div>
            </div>
        </div>

        <form id="productForm">
            <!-- BASIC -->
            <div class="tab-pane active" id="tab-basic">
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="panel">
                            <div class="panel-header">
                                <h5 class="panel-title">Basic Information</h5>
                            </div>
                            <div class="panel-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Product Title <span class="req">*</span></label>
                                        <input id="title" class="form-control" placeholder="e.g., Basic Tee for Men"
                                            value="{{ isset($product) && $product ? $product->title : '' }}" required>
                                        <div class="form-text">Slug auto-generate হবে (নিচে এডিট করতে পারবেন)</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Brand</label>
                                        <select id="brand" class="form-select">
                                            <option value="">— None —</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ isset($product) && $product && $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">SKU (Single)</label>
                                        <input id="skuSingle" class="form-control" placeholder="AUTO or custom"
                                            value="{{ isset($product) && $product && isset($product->sku) ? $product->sku : '' }}">
                                    </div>
                                    @if(isset($product) && $product)
                                        <input type="hidden" id="productId" value="{{ $product->id }}">
                                    @endif

                                    <!-- Multi-category assign -->
                                    <div class="col-12">
                                        <label class="form-label">Categories <span class="req">*</span></label>
                                        <div id="catChips"></div>
                                        <div class="d-flex gap-2 mt-2">
                                            <button class="btn btn-outline-secondary btn-sm" id="btnAssignCats"><i
                                                    class="bx bx-sitemap me-1"></i>Assign Categories</button>
                                            <span class="small-muted">Primary category থেকে কনফিগ এপ্লাই হবে</span>
                                        </div>
                                        <select id="category" class="form-select mt-2 d-none"></select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Attribute Set</label>
                                        <div class="input-group">
                                            <select id="attrSet" class="form-select">
                                                <option value="">— None —</option>
                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" id="btnSetPreview"
                                                title="Preview set"><i class="bx bx-show"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Variant Rule</label>
                                        <div class="input-group">
                                            <select id="variantRule" class="form-select">
                                                <option value="">— None —</option>
                                            </select>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="btnVariantRulePreview" title="Preview rule"><i
                                                    class="bx bx-show"></i></button>
                                        </div>
                                        <div class="form-text">রুল সিলেক্ট করলে Variant axes অটো সেট হবে</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select id="status" class="form-select">
                                            <option value="draft" {{ isset($product) && $product && strtolower($product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="active" {{ isset($product) && $product && strtolower($product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="archived" {{ isset($product) && $product && strtolower($product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Short Description</label>
                                        <textarea id="shortDesc" class="form-control" rows="2">{{ isset($product) && $product ? $product->short_desc : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right summary -->
                    <div class="col-lg-4">
                        <div class="panel">
                            <div class="panel-header d-flex justify-content-between align-items-center">
                                <h6 class="panel-title mb-0"><i class="bx bx-check-shield me-1"></i>Primary Category
                                    Config</h6>
                                <button class="btn btn-sm btn-outline-secondary btn-icon" id="btnMediaRulePreview"
                                    title="Media Rule Preview"><i class="bx bx-image-alt"></i></button>
                            </div>
                            <div class="panel-body">
                                <div class="d-flex flex-column gap-2" id="catConfigBox">
                                    <div class="small-muted">Primary category সিলেক্ট করুন…</div>
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <div class="d-none">
                                        <label class="form-label">Media Rule</label>
                                        <div class="input-group">
                                            <select id="mediaRule" class="form-select">
                                                <option value="">— None —</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="btnMediaRulePreview2" title="Preview rule"><i
                                                class="bx bx-show"></i></button>
                                    </div>
                                    <div class="form-text">Rule অনুযায়ী variant-wise image টগল হবে</div>
                                </div>
                                <div>
                                    <label class="form-label">Slug</label>
                                    <input id="slug" class="form-control" placeholder="auto-from-title"
                                        value="{{ isset($product) && $product ? $product->slug : '' }}">
                                    <div class="small-muted">URL key (unique)</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel mt-3">
                            <div class="panel-header">
                                <h6 class="panel-title mb-0"><i class="bx bx-check-shield me-1"></i>Publishing</h6>
                            </div>
                            <div class="panel-body">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="isFeatured"
                                        {{ isset($product) && $product && $product->featured ? 'checked' : '' }}><label
                                        class="form-check-label" for="isFeatured">Featured Product</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="allowBackorder"
                                        {{ isset($product) && $product && $product->allow_backorder ? 'checked' : '' }}><label
                                        class="form-check-label" for="allowBackorder">Allow Backorder</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MEDIA -->
            <div class="tab-pane" id="tab-media">
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="panel">
                            <div class="panel-header d-flex justify-content-between align-items-center">
                                <h5 class="panel-title">Gallery</h5>
                                <div class="small-muted">Max 8 images (ডেমো)</div>
                            </div>
                            <div class="panel-body">
                                <div class="drop mb-2">
                                    <div><i class="bx bx-cloud-upload"></i> <strong>Upload</strong> or drag files</div>
                                    <input type="file" id="galleryInput" name="gallery[]" accept="image/*" multiple class="form-control mt-2" />
                                </div>
                                <div id="gallery" class="gallery-grid"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel">
                            <div class="panel-header">
                                <h6 class="panel-title mb-0">Media Settings</h6>
                            </div>
                            <div class="panel-body">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="variantWiseImage"><label
                                        class="form-check-label" for="variantWiseImage">Variant-wise images</label>
                                </div>
                                <div class="row g-2">
                                    <div class="col-7">
                                        <label class="form-label">Max upload size</label>
                                        <select id="maxUpload" class="form-select">
                                            <option>1 MB</option>
                                            <option selected>2 MB</option>
                                            <option>5 MB</option>
                                            <option>10 MB</option>
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label">Max images</label>
                                        <input id="maxImages" type="number" class="form-control" value="8"
                                            min="1" max="20">
                                    </div>
                                </div>
                                <div class="small-muted mt-2">এই সেটিং Media Rule/Category থেকে প্রি-ফিল হয়</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ATTRIBUTES -->
            <div class="tab-pane" id="tab-attrs">
                <div class="panel">
                    <div class="panel-header d-flex justify-content-between align-items-center">
                        <h5 class="panel-title mb-0">Attributes</h5>
                        <div class="small-muted"><span class="pill"><i class="bx bx-layer"></i> Set: <span
                                    id="pillSet">None</span></span></div>
                    </div>
                    <div class="panel-body" id="attrFields">
                        <div class="small-muted">Attribute set সিলেক্ট করলে ফিল্ড আসবে…</div>
                    </div>
                </div>
            </div>

            <!-- VARIANTS -->
            <div class="tab-pane" id="tab-variants">
                <div class="panel">
                    <div class="panel-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="panel-title mb-0">Variant Builder</h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="d-flex align-items-center gap-2 mb-2">

                           <button type="button" class="btn btn-primary btn-sm" id="btnGenVariants">
                            <i class="bx bx-grid-alt me-1"></i>Generate Variants
                            </button>
                            <div id="variantAxes" class="ms-auto"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="variantTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width:220px">Variant</th>
                                        <th>SKU</th>
                                        <th class="vimg-col">Image</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="noVariantNote" class="small-muted">No variants yet. Rule/axes সিলেক্ট করে Generate করুন।
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="catAssignModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-sitemap me-1"></i>Assign Categories</h6><button
                        class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input id="catSearch" class="form-control form-control-sm" placeholder="Search category path…">
                        <div class="small-muted ms-2">প্রাইমারি বাছাই করতে রেডিও সিলেক্ট করুন</div>
                    </div>
                    <div id="catList" class="row g-2"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnCatSave"><i class="bx bx-save me-1"></i>Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="setPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-layer me-1"></i>Attribute Set Preview</h6><button
                        class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="setPreviewBody"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediaRulePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-image-alt me-1"></i>Media Rule Preview</h6><button
                        class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="mediaRuleBody"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="variantRulePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-intersect me-1"></i>Variant Rule Preview</h6><button
                        class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="variantRuleBody"></div>
            </div>
        </div>
    </div>


    @push('scripts')
       <script>
  (function() {
      'use strict';

      /* ===== Utils ===== */
      const $ = s => document.querySelector(s);
      const $$ = s => Array.from(document.querySelectorAll(s));
      const byId = id => document.getElementById(id);
      const hasBS = !!(window.bootstrap && bootstrap.Modal);
      const mkModal = id => {
          const el = byId(id);
          if (!el) return null;
          if (hasBS) return new bootstrap.Modal(el);
          return {
              show() {
                  el.style.display = 'block';
                  el.classList.add('show');
                  el.removeAttribute('aria-hidden');
              },
              hide() {
                  el.style.display = 'none';
                  el.classList.remove('show');
                  el.setAttribute('aria-hidden', 'true');
              }
          };
      };
      const getCsrf = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
      async function fetchJSON(url, opts = {}) {
          const res = await fetch(url, {
              credentials: 'same-origin',
              headers: {
                  'Accept': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': getCsrf()
              },
              ...opts
          });
          if (!res.ok) throw new Error(`HTTP ${res.status} for ${url}`);
          return res.json();
      }
      const indexBy = (arr, key = 'id') => (arr || []).reduce((m, o) => {
          if (o?.[key] != null) m[o[key]] = o;
          return m;
      }, {});
      const arrOf = (r) =>
          Array.isArray(r) ? r :
          Array.isArray(r?.sets) ? r.sets :
          Array.isArray(r?.attributes) ? r.attributes :
          Array.isArray(r?.data) ? r.data :
          Array.isArray(r?.items) ? r.items : [];

      const slugify = s => (s || '').toLowerCase().trim()
          .replace(/[\s_]+/g, '-').replace(/[^a-z0-9\-]/g, '').replace(/\-+/g, '-').replace(/^\-+|\-+$/g, '');

      /* ===== Wizard Nav ===== */
      const wizardTabs = $$('#wizard-nav .qb-wizard-tab');

      function getSelectedRuleAxes() {
          const rr = (STATE.RULES.variant || []).find(x => String(x.id) === String(varRuleSel?.value));
          if (!rr) return [];

          let axes = [];
          if (rr.set_of_rules && typeof rr.set_of_rules === 'object' && !Array.isArray(rr.set_of_rules)) {
              axes = Object.keys(rr.set_of_rules);
          } else if (Array.isArray(rr.set_of_rules)) {
              axes = rr.set_of_rules;
          } else if (Array.isArray(rr.axes)) {
              axes = rr.axes;
          }

          // normalize tokens -> attribute IDs
          axes = axes.map(tok => {
              if (/^\d+$/.test(String(tok))) return String(tok);
              const t = String(tok).toLowerCase();
              const hit = Object.values(STATE.ATTRS).find(a =>
                  String(a.id) === String(tok) ||
                  String(a.slug || '').toLowerCase() === t ||
                  String(a.code || '').toLowerCase() === t ||
                  String(a.name || '').toLowerCase() === t
              );
              return hit ? String(hit.id) : null;
          }).filter(Boolean);

          // keep only attrs inside the current set
          const setId = setSel?.value;
          const setObj = STATE.ATTR_SETS[setId] || {};
          const raw = setObj.attrs ?? setObj.items ?? [];
          const allowed = new Set(Array.isArray(raw) ? raw : Array.from(raw));
          return axes.filter(aid => allowed.has(aid) || allowed.has(Number(aid)));
      }

      function openTab(id) {
          wizardTabs.forEach(t => t.classList.toggle('is-active', t.dataset.target === id));
          $$('.tab-pane').forEach(p => {
              const on = '#' + p.id === id;
              p.classList.toggle('active', on);
              p.classList.toggle('show', on);
          });
          try {
              history.replaceState(null, null, id);
          } catch (e) {}
          window.scrollTo({
              top: 0,
              behavior: 'smooth'
          });
      }
      wizardTabs.forEach(tab => tab.addEventListener('click', () => openTab(tab.dataset.target)));

      /* ===== Modals ===== */
      const modalCats = mkModal('catAssignModal');
      const modalSetPrev = mkModal('setPreviewModal');
      const modalMediaPrev = mkModal('mediaRulePreviewModal');
      const modalVarPrev = mkModal('variantRulePreviewModal');

      /* ===== Endpoints ===== */
      const ROUTES = (window.PRODUCT_ROUTES || {
          catsLeaf: '/product/categories/leaf',
          catsTree: '/product/categories/tree',
          attributes: '/admin/all-attributes/data', // returns array OR {attributes:[...]}
          attrSets: '/catalog/attribute-sets/data', // returns {sets:[{id,name,items:[attrIds]}]}
          mediaRules: '/catalog/media-rules', // optional
          variantRules: '/product/get/varient-rules', // POST {attribute_set_id}
          catConfig: '/catalog/categories/:slug/config',
          saveProduct: '/admin/create-product/store'
      });
      const BOOT = window.PRODUCT_BOOTSTRAP || null;

      /* ===== State ===== */
      const STATE = {
          CATS: [],
          ATTRS: {},
          ATTR_SETS: {},
          RULES: {
              media: [],
              variant: []
          },
          CAT_CFG_CACHE: new Map()
      };

      function toAttrId(token) {
          const t = String(token).toLowerCase();
          for (const a of Object.values(STATE.ATTRS)) {
              if (String(a.id) === String(token)) return String(a.id);
              if (a.slug && String(a.slug).toLowerCase() === t) return String(a.id);
              if (a.code && String(a.code).toLowerCase() === t) return String(a.id);
              if (a.name && String(a.name).toLowerCase() === t) return String(a.id);
          }
          return null;
      }

      function normalizeRules(apiRows) {
          const rows = Array.isArray(apiRows) ? apiRows : [];
          const out = [];

          rows.forEach(r => {
              const sor = r?.set_of_rules;
              let axesIds = [];

              if (Array.isArray(sor)) {
                  // e.g. [1,4] or ['Color','Brand']
                  axesIds = sor
                      .map(x => toAttrId(x) || (/^\d+$/.test(String(x)) ? String(x) : null))
                      .filter(Boolean);
              } else if (sor && typeof sor === 'object') {
                  const keys = Object.keys(sor);
                  // e.g. {"1":"Color","4":"Brand"}  -> keys are attribute IDs
                  if (keys.length && keys.every(k => /^\d+$/.test(k))) {
                      axesIds = keys
                          .map(k => toAttrId(k) || String(k))
                          .filter(Boolean);
                  } else {
                      // fallback: { "My Rule": [1,4] }
                      Object.entries(sor).forEach(([nm, axes]) => {
                          const mapped = (Array.isArray(axes) ? axes : [])
                              .map(x => toAttrId(x) || (/^\d+$/.test(String(x)) ? String(x) :
                                  null))
                              .filter(Boolean);
                          if (mapped.length) out.push({
                              id: `rule:${r.id}:${nm}`,
                              name: nm,
                              axes: mapped
                          });
                      });
                  }
              }

              if (axesIds.length) {
                  out.push({
                      id: String(r.id),
                      name: r.name || r.category_name || `Rule ${r.id}`,
                      axes: axesIds
                  });
              }
          });

          return out.filter(x => x.axes && x.axes.length);
      }


      function toLeafList(raw) {
          let cats = raw;
          if (cats && typeof cats === 'object' && !Array.isArray(cats)) {
              if (Array.isArray(cats.data)) cats = cats.data;
              else if (Array.isArray(cats.items)) cats = cats.items;
              else cats = Object.values(cats);
          }
          if (!Array.isArray(cats)) return [];
          if (cats.length && (cats[0]?.slug || cats[0]?.path || cats[0]?.name)) {
              return cats.map(c => ({
                  slug: (c.slug ?? c.id ?? String(c.name ?? '')),
                  path: (c.path ?? c.full_path ?? c.name ?? c.slug ?? String(c.id))
              }));
          }
          const out = [];
          const childrenOf = n => n.children || n.childrenRecursive || n.children_recursive || [];
          const slugOf = n => (n.slug ?? n.id ?? String(n.name ?? ''));
          const nameOf = n => (n.name ?? n.title ?? slugOf(n));
          const walk = (nodes, trail = []) => {
              (nodes || []).forEach(n => {
                  const nextTrail = [...trail, nameOf(n)];
                  const kids = childrenOf(n);
                  if (!kids || kids.length === 0) out.push({
                      slug: slugOf(n),
                      path: nextTrail.join(' › ')
                  });
                  else walk(kids, nextTrail);
              });
          };
          walk(cats, []);
          return out;
      }

      async function loadBootstrap() {
          let leafs = [];
          try {
              leafs = toLeafList(await fetchJSON(ROUTES.catsLeaf));
          } catch (e) {}
          if (!leafs.length) {
              try {
                  leafs = toLeafList(await fetchJSON(ROUTES.catsTree));
              } catch (e) {}
          }
          STATE.CATS = leafs;

          const [attrsRes, setsRes] = await Promise.all([
              fetchJSON(ROUTES.attributes).catch(() => []),
              fetchJSON(ROUTES.attrSets).catch(() => []),
          ]);

          const attrsArr = arrOf(attrsRes);
          const setsArr = arrOf(setsRes);
          console.log('Fetched', {
              sets: setsArr.length
          });

          STATE.ATTRS = indexBy(attrsArr);
          STATE.ATTR_SETS = indexBy(setsArr);
          STATE.RULES.variant = []; // fetch only when set changes
      }



      async function getCatConfig(slug) {
          if (!slug) return null;
          if (STATE.CAT_CFG_CACHE.has(slug)) return STATE.CAT_CFG_CACHE.get(slug);
          const url = ROUTES.catConfig.replace(':slug', encodeURIComponent(slug));
          const cfg = await fetchJSON(url).catch(() => null);
          STATE.CAT_CFG_CACHE.set(slug, cfg || null);
          return cfg || null;
      }

      /* ===== Dropdowns ===== */
      const setSel = $('#attrSet'),
            mediaSel = $('#mediaRule'),
            varRuleSel = $('#variantRule');

      function fillSelect(sel, items, map) {
          if (!sel) return;
          sel.innerHTML = '<option value="">— None —</option>';
          (items || []).forEach(it => {
              const o = document.createElement('option');
              const m = map ? map(it) : {
                  value: (it?.id ?? it?.value ?? ''),
                  label: (it?.name ?? it?.label ?? String(it?.id ?? ''))
              };
              o.value = String(m.value ?? '');
              o.textContent = String(m.label ?? '');
              sel.appendChild(o);
          });
      }

      /* ===== Categories ===== */
      const categorySelectHidden = $('#category');
      const catChips = $('#catChips');
      let selectedCats = new Set();
      let primaryCat = '';

      function renderCatChips() {
          if (!catChips) return;
          catChips.innerHTML = '';
          if (selectedCats.size === 0) {
              catChips.innerHTML = `<span class="small-muted">কোনো ক্যাটাগরি অ্যাসাইন করা হয়নি</span>`;
              return;
          }
          [...selectedCats].forEach(sl => {
              const path = STATE.CATS.find(x => x.slug === sl)?.path || sl;
              const wrap = document.createElement('span');
              wrap.className = 'cat-chip';
              wrap.innerHTML =
                  `${path} ${sl===primaryCat?'<span class="badge ms-1">Primary</span>':''}
      <button class="btn btn-link text-danger btn-sm p-0 ms-1" data-rm="${sl}" title="remove"><i class="bx bx-x"></i></button>`;
              catChips.appendChild(wrap);
          });
      }

      catChips?.addEventListener('click', e => {
          const rm = e.target.closest?.('[data-rm]');
          if (!rm) return;
          selectedCats.delete(rm.dataset.rm);
          if (primaryCat === rm.dataset.rm) primaryCat = [...selectedCats][0] || '';
          syncPrimarySelect();
          renderCatChips();
          applyPrimaryConfig();
      });

      $('#btnAssignCats')?.addEventListener('click', e => {
          e.preventDefault();
          openCatAssign();
      });

      function openCatAssign() {
          const list = $('#catList');
          if (!list) return;
          list.innerHTML = '';
          STATE.CATS.forEach(item => {
              const col = document.createElement('div');
              col.className = 'col-md-6';
              const checked = selectedCats.has(item.slug);
              col.innerHTML = `
      <label class="border rounded p-2 d-flex align-items-center gap-2 w-100">
        <input type="checkbox" class="form-check-input me-1 cat-check" value="${item.slug}" ${checked?'checked':''}>
        <div><div class="fw-semibold">${item.path}</div><div class="small text-muted">${item.slug}</div></div>
        <div class="ms-auto">
          <input class="form-check-input primary-radio" type="radio" name="primary" value="${item.slug}" ${primaryCat===item.slug?'checked':''} ${checked?'':'disabled'}>
          <label class="small-muted">Primary</label>
        </div>
      </label>`;
              list.appendChild(col);
          });
          $('#catSearch') && ($('#catSearch').value = '');
          modalCats?.show?.();
      }

      $('#catList')?.addEventListener('change', e => {
          if (e.target.classList?.contains('cat-check')) {
              const slug = e.target.value;
              if (e.target.checked) {
                  selectedCats.add(slug);
              } else {
                  selectedCats.delete(slug);
                  if (primaryCat === slug) primaryCat = [...selectedCats][0] || '';
              }
              const radio = e.target.closest('label')?.querySelector('.primary-radio');
              if (radio) {
                  radio.disabled = !e.target.checked;
                  if (!radio.disabled && !primaryCat) {
                      radio.checked = true;
                      primaryCat = slug;
                  }
              }
          }
          if (e.target.classList?.contains('primary-radio')) primaryCat = e.target.value;
      });

      $('#catSearch')?.addEventListener('input', () => {
          const q = $('#catSearch')?.value.trim().toLowerCase();
          $$('#catList .col-md-6').forEach(col => col.classList.toggle('d-none', !!q && !col.innerText
              .toLowerCase().includes(q)));
      });

      function syncPrimarySelect() {
          if (!categorySelectHidden) return;
          categorySelectHidden.innerHTML = '';
          [...selectedCats].forEach(sl => {
              const o = document.createElement('option');
              o.value = sl;
              o.textContent = sl;
              categorySelectHidden.appendChild(o);
          });
          categorySelectHidden.value = primaryCat || '';
      }

      $('#btnCatSave')?.addEventListener('click', () => {
          if (selectedCats.size === 0) {
              alert('কমপক্ষে একটি ক্যাটাগরি সিলেক্ট করুন');
              return;
          }
          if (!primaryCat) primaryCat = [...selectedCats][0];
          modalCats?.hide?.();
          syncPrimarySelect();
          renderCatChips();
          applyPrimaryConfig();
      });

      /* ===== Basic ===== */
      const titleEl = $('#title'),
            slugEl = $('#slug');
      titleEl?.addEventListener('input', () => {
          if (!slugEl?.dataset.touched) {
              slugEl.value = slugify(titleEl.value);
          }
      });
      slugEl?.addEventListener('input', () => slugEl.dataset.touched = true);

      /* ===== Apply Primary Category Config ===== */
      function pill(txt, icon) {
          return `<div class="pill"><i class="bx ${icon||'bx-check'}"></i> ${txt}</div>`;
      }

      function attrsObjectToArray(obj) {
          // {attrId:[termId,...]} -> [{attribute_id, term_ids:[...]}]
          return Object.entries(obj || {}).map(([aid, tids]) => ({
              attribute_id: String(aid),
              term_ids: (tids || []).map(String)
          }));
      }

      function normalizeVariants() {
          // rows -> [{sku, options:[{attribute_id, term_id}], map:[[aid,tid],...]}]
          return [...($('#variantTable tbody')?.children || [])].map((tr, i) => {
              const map = JSON.parse(tr.dataset.variant || '[]');
              return {
                  sku: tr.querySelector('.v-sku')?.value.trim() || '',
                  options: map.map(([aid, tid]) => ({
                      attribute_id: String(aid),
                      term_id: String(tid)
                  })),
                  map
              };
          });
      }

      function buildFormData(base) {
          const fd = new FormData();

          // files: gallery  (<<< CHANGED: use gallery[] and include filename >>>)
          const gInput = $('#galleryInput');
          const galleryFiles = gInput?.files ? Array.from(gInput.files) : [];
          galleryFiles.forEach((file) => fd.append('gallery[]', file, file.name));
          const cover = document.querySelector('input[name="gallery_cover_index"]:checked')?.value ?? '0';
          fd.append('gallery_cover_index', cover);

          // files: variant images (aligned by variant index)
          const vRows = [...($('#variantTable tbody')?.children || [])];
          vRows.forEach((tr, i) => {
              const inp = tr.querySelector('.v-img');
              const file = inp?.files?.[0];
              if (file) fd.append('variant_images[]', file, file.name); // <<< CHANGED
          });

          // structured data (no files)
          const payload = {
              title: base.title,
              slug: base.slug,
              brand_id: base.brand || null,
              status: base.status,
              short_desc: $('#shortDesc')?.value || '',
              featured: !!base.featured,
              allow_backorder: $('#allowBackorder')?.checked || false,
              variant_wise_image: !!base.variantWiseImage,

              categories: base.categories, // all assigned
              primary_category: base.primaryCategory, // single

              attribute_set_id: base.attrSet || null,
              media_rule_id: base.mediaRule || null,
              variant_rule_id: base.variantRule || null,

              attributes: attrsObjectToArray(base.attributes),
              variants: normalizeVariants(), // includes map+options+sku

              seo: base.seo,
          };
          fd.append('data', JSON.stringify(payload));
          return fd;
      }
      async function sendProduct() {
          if (!validateBasic()) return;

          const base = collectData();
          const fd = buildFormData(base);

          const res = await fetch(ROUTES.saveProduct, {
              method: 'POST',
              credentials: 'same-origin',
              headers: {
                  'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]')?.content || '')
              },
              body: fd
          });

          if (!res.ok) {
              const err = await res.json().catch(() => ({}));
              console.error('SAVE ERROR', err);
              alert(err.message || 'Save failed.');
              return;
          }
        //   const out = await res.json().catch(() => null);
        //   console.log('SAVE OK', out);
        // //   alert('Product saved!');

          window.location.href = '/admin/all-products';

          // optional: redirect
          // if (out?.id) location.href = `/admin/products/${out.id}/edit`;
      }

      $('#btnSaveDraft')?.addEventListener('click', async (e) => {
          e.preventDefault();
          if (!validateBasic()) return;
          $('#status') && ($('#status').value = 'Draft');
          await sendProduct();
      });
      $('#btnPublish')?.addEventListener('click', async (e) => {
          e.preventDefault();
          if (!validateBasic()) return;
          $('#status') && ($('#status').value = 'Active');
          await sendProduct();
      });

      async function applyPrimaryConfig() {
          const key = primaryCat;
          const cfg = await getCatConfig(key);
          const box = $('#catConfigBox');
          if (!box) return;
          box.innerHTML = '';
          if (!cfg) {
              box.innerHTML = '<div class="small-muted">No preset for this primary category.</div>';
              return;
          }

          // set attr set from cfg and trigger dependent loads
          if (setSel) {
              const nextSet = cfg?.attrSet ?? '';
              const changed = String(setSel.value) !== String(nextSet);
              setSel.value = nextSet;
              if (changed) setSel.dispatchEvent(new Event('change'));
              else await refreshVariantRuleForSet();
          }

          if (mediaSel) mediaSel.value = cfg.mediaRule || '';

          const weightUnitEl = $('#weightUnit');
          if (weightUnitEl) weightUnitEl.value = (cfg.units?.weight ?? weightUnitEl.value ?? 'kg');
          const dimUnitEl = $('#dimUnit');
          if (dimUnitEl) dimUnitEl.value = (cfg.units?.dim ?? dimUnitEl.value ?? 'cm');

          const sizeWrap = $('#sizeChartWrap');
          if (sizeWrap) sizeWrap.classList.toggle('hidden', !cfg.sizeChart);

          const mr = (STATE.RULES.media || []).find(m => String(m.id) === String(mediaSel?.value || ''));
          const vwi = mr ? !!mr.variantWiseImage : !!cfg.variantWiseImage;
          const vwiEl = $('#variantWiseImage');
          if (vwiEl) {
              vwiEl.checked = vwi;
              toggleVariantImageColumn();
          }

          renderAttrFields();

          box.innerHTML = [
              pill(`Set: ${STATE.ATTR_SETS[cfg.attrSet]?.name||'—'}`, 'bx-layer'),
              pill(
                  `Media: ${(STATE.RULES.media||[]).find(m=>String(m.id)===String(mediaSel?.value||''))?.name||'—'}`,
                  'bx-image-alt'),
              pill(`Units: W=${cfg.units?.weight||'-'}, D=${cfg.units?.dim||'-'}`, 'bx-ruler'),
              cfg.sizeChart ? pill('Size Chart: Enabled', 'bx-table') : ''
          ].join('');
      }

      /* ===== Media Rule Preview ===== */
      function openMediaPreview() {
          const id = mediaSel?.value;
          const r = (STATE.RULES.media || []).find(x => String(x.id) === String(id));
          const body = $('#mediaRuleBody');
          if (!body) {
              modalMediaPrev?.show?.();
              return;
          }
          body.innerHTML = r ?
              `
          <div class="mb-2"><strong>${r.name}</strong></div>
          <div class="small-muted">${r.desc||''}</div>
          <hr>
          <ul class="small"><li>Variant-wise images: <strong>${r.variantWiseImage?'Enabled':'Disabled'}</strong></li></ul>` :
              `<div class="small-muted">No rule selected.</div>`;
          modalMediaPrev?.show?.();
      }
      $('#btnMediaRulePreview')?.addEventListener('click', openMediaPreview);
      $('#btnMediaRulePreview2')?.addEventListener('click', openMediaPreview);
      mediaSel?.addEventListener('change', () => {
          const r = (STATE.RULES.media || []).find(x => String(x.id) === String(mediaSel.value));
          const vwiEl = $('#variantWiseImage');
          if (vwiEl) {
              vwiEl.checked = !!r?.variantWiseImage;
              toggleVariantImageColumn();
          }
      });

      /* ===== Gallery ===== */
      const gInput = $('#galleryInput'),
            gWrap = $('#gallery');
      gInput?.addEventListener('change', () => {
          if (!gWrap) return;
          gWrap.innerHTML = '';
          const max = parseInt($('#maxImages')?.value || '8', 10);
          [...gInput.files].slice(0, max).forEach((f, idx) => {
              const url = URL.createObjectURL(f);
              const div = document.createElement('div');
              div.className = 'g-item';
              div.innerHTML =
              `<img src="${url}"><div class="form-check">
                  <input class="form-check-input" type="radio" name="gallery_cover_index" value="${idx}" ${idx===0?'checked':''}>
                  <label class="form-check-label small">Cover</label>
              </div>`;

              gWrap.appendChild(div);
          });
      });

      /* ===== Attributes UI ===== */
      const attrFields = $('#attrFields');
      const pillSet = $('#pillSet');

      function renderAttrFields() {
          const setId = setSel?.value || '';
          if (pillSet) pillSet.textContent = STATE.ATTR_SETS[setId]?.name || 'None';
          if (!attrFields) {
              return;
          }
          attrFields.innerHTML = '';
          if (!setId) {
              attrFields.innerHTML = '<div class="small-muted">No attribute set selected.</div>';
              return;
          }

          const setObj = STATE.ATTR_SETS[setId] || {};
          const raw = setObj.attrs ?? setObj.items ?? [];
          const ids = Array.isArray(raw) ? raw : Array.from(raw || []);
          const list = ids.map(k => STATE.ATTRS[k]).filter(Boolean);

          list.forEach(attr => {
              const chips = (attr.terms || []).map(t => {
                  const sw = attr.type === 'swatch' ?
                      `<span style="width:14px;height:14px;border-radius:50%;border:1px solid #e5e7eb;background:${t.color||'#fff'};display:inline-block"></span>` :
                      '';
                  return `<label class="chip"><input type="checkbox" class="term-check" data-attr="${attr.id}" value="${t.id}"> ${sw}<span>${t.name}</span></label>`;
              }).join('');
              const block = document.createElement('div');
              block.className = 'mb-3';
              block.innerHTML =
                  `<label class="form-label">${attr.name}${attr.useForVariant?' <span class="small-muted">(variant axis capable)</span>':''}</label><div>${chips||'<div class="small-muted">No terms</div>'}</div>`;
              attrFields.appendChild(block);
          });
      }

      // === Variant Rules fetch+lock ===
      const normVariantRules = (r) =>
          Array.isArray(r) ? r :
          Array.isArray(r?.rules) ? r.rules :
          Array.isArray(r?.data) ? r.data :
          r ? [r] : [];

      async function refreshVariantRuleForSet() {
          if (!varRuleSel) return;
          const setId = setSel?.value;
          fillSelect(varRuleSel, [], null);
          varRuleSel.removeAttribute('disabled');
          STATE.RULES.variant = [];

          if (!setId) return;

          let list = [];
          try {
              const res = await fetchJSON(ROUTES.variantRules, {
                  method: 'POST',
                  headers: {
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                      'X-Requested-With': 'XMLHttpRequest',
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                  },
                  body: JSON.stringify({
                      attribute_set_id: setId
                  })
              });
              list = normVariantRules(res);
          } catch (e) {
              list = [];
          }

          // cache for previews
          STATE.RULES.variant = list;

          fillSelect(varRuleSel, list, r => ({
              value: r.id,
              label: (r.name || r.rule_name || r.title || `Rule ${r.id}`)
          }));
          if (list.length) {
              varRuleSel.value = String(list[0].id);
              varRuleSel.setAttribute('disabled', '');
              varRuleSel.dispatchEvent(new Event('change'));
          }
      }

      setSel?.addEventListener('change', () => {
          renderAttrFields();
          resetVariants();
          refreshVariantRuleForSet();
      });

      /* ===== Variants ===== */
      let pickableAxes = [];

      function currentSelectedTerms() {
          const map = {};
          $$('.term-check:checked').forEach(c => {
              const a = c.dataset.attr;
              (map[a] || (map[a] = [])).push(c.value);
          });
          return map;
      }

      function renderAxesChips() {
          const wrap = $('#variantAxes');
          if (!wrap) return;
          wrap.innerHTML = '';
          pickableAxes.forEach(aid => {
              const a = STATE.ATTRS[aid];
              const chip = document.createElement('span');
              chip.className = 'pill';
              chip.innerHTML =
                  `<i class="bx bx-dialpad"></i> ${a?.name||aid} <button class="btn btn-link text-danger p-0 ms-1" data-remove="${aid}"><i class="bx bx-x"></i></button>`;
              wrap.appendChild(chip);
          });
          wrap.classList.toggle('hidden', pickableAxes.length === 0);
      }
      $('#variantAxes')?.addEventListener('click', e => {
          const rm = e.target.closest?.('[data-remove]');
          if (!rm) return;
          pickableAxes = pickableAxes.filter(x => x !== rm.dataset.remove);
          renderAxesChips();
      });

      varRuleSel?.addEventListener('change', () => {
          const chosen = (STATE.RULES.variant || []).find(x => String(x.id) === String(varRuleSel.value));
          if (!chosen) {
              pickableAxes = [];
              renderAxesChips();
              return;
          }

          const setId = setSel?.value;
          if (!setId) {
              alert('Select attribute set first.');
              varRuleSel.value = '';
              return;
          }

          const setObj = STATE.ATTR_SETS[setId] || {};
          const raw = setObj.attrs ?? setObj.items ?? [];
          const allowed = new Set((Array.isArray(raw) ? raw : Array.from(raw)).map(String));

          // axes already mapped to attribute IDs in normalizeRules()
          pickableAxes = (chosen.axes || []).filter(id => allowed.has(String(id)));
          renderAxesChips();

          // just help the user: pre-check terms for these axes (generation still needs the button)
          $$('.term-check').forEach(c => {
              if (pickableAxes.includes(String(c.dataset.attr))) c.checked = true;
          });
      });


      // Preview: Variant Rule (uses set_of_rules + selected terms)
      $('#btnVariantRulePreview')?.addEventListener('click', () => {
          const body = $('#variantRuleBody');
          if (!body) {
              modalVarPrev?.show?.();
              return;
          }

          const setId = setSel?.value;
          if (!setId) {
              body.innerHTML = '<div class="small-muted">Select attribute set first.</div>';
              modalVarPrev?.show?.();
              return;
          }

          const axes = getSelectedRuleAxes();
          if (!axes.length) {
              body.innerHTML =
                  '<div class="small-muted">No axes resolved from the selected rule (set_of_rules).</div>';
              modalVarPrev?.show?.();
              return;
          }

          const sel = currentSelectedTerms();
          const items = axes.map(aid => {
              const a = STATE.ATTRS[aid];
              const selected = (sel[aid] || []).length;
              const total = (a?.terms || []).length;
              const countText = selected ? `${selected} selected` : `${total} terms`;
              return `<li>${a?.name || aid} — ${countText}</li>`;
          }).join('');

          const totalComb = axes.reduce((acc, aid) => {
              const n = (sel[aid] || []).length || (STATE.ATTRS[aid]?.terms?.length || 0);
              return acc * (n || 0);
          }, 1) || 0;

          body.innerHTML = `
  <div><strong>Variant Rule Preview</strong></div>
  <ul>${items}</ul>
  <div class="mt-2"><strong>Estimated combinations:</strong> ${totalComb}</div>`;
          modalVarPrev?.show?.();
      });
      // Preview: Attribute Set (marks which attributes are axes per current rule)
      $('#btnSetPreview')?.addEventListener('click', () => {
          const body = $('#setPreviewBody');
          if (!body) {
              modalSetPrev?.show?.();
              return;
          }

          const setId = setSel?.value;
          if (!setId) {
              body.innerHTML = '<div class="small-muted">No attribute set selected.</div>';
              modalSetPrev?.show?.();
              return;
          }

          const setObj = STATE.ATTR_SETS[setId] || {};
          const raw = setObj.attrs ?? setObj.items ?? [];
          const ids = Array.isArray(raw) ? raw : Array.from(raw);
          const ruleAxes = new Set(getSelectedRuleAxes().map(String));

          const list = ids.map(id => {
              const a = STATE.ATTRS[id];
              if (!a) return '';
              const isAxis = ruleAxes.has(String(id));
              const cnt = (a.terms || []).length;
              return `<li>${a.name || id} ${isAxis ? '<span class="badge ms-1">Axis</span>' : ''} — ${cnt} terms</li>`;
          }).join('');

          body.innerHTML = `
  <div><strong>${setObj.name || 'Attribute Set'}</strong></div>
  <ul>${list || '<li class="small-muted">No attributes.</li>'}</ul>`;
          modalSetPrev?.show?.();
      });


      function cartesian(arr) {
          return arr.reduce((a, b) => a.flatMap(d => b.map(e => [].concat(d, e))), [
              []
          ]);
      }

      function axisTitle(pair) {
          return pair.map(([aid, tid]) => {
              const a = STATE.ATTRS[aid],
                    t = (a?.terms || []).find(x => String(x.id) === String(tid));
              return `${a?.name||aid}: ${t?.name||tid}`;
          }).join(' / ');
      }

      function resetVariants() {
          const tb = $('#variantTable tbody');
          if (tb) tb.innerHTML = '';
          $('#noVariantNote')?.classList.remove('hidden');
          pickableAxes = [];
          renderAxesChips();
          $('#skuSingle')?.removeAttribute('disabled');
      }

      function toggleVariantImageColumn() {
          const on = $('#variantWiseImage')?.checked;
          ['.vimg-col', 'td.vimg-cell'].forEach(sel => {
              $$('#variantTable ' + sel).forEach(el => {
                  el.classList.toggle('hidden', !on);
                  el.classList.toggle('d-none', !on);
              });
          });
      }

      $('#variantWiseImage')?.addEventListener('change', toggleVariantImageColumn);

      $('#btnGenVariants')?.addEventListener('click', (e) => {
          e.preventDefault();
          // prefer manual chips, else take axes from selected rule (set_of_rules)
          const axes = (pickableAxes && pickableAxes.length) ? pickableAxes.slice() :
              getSelectedRuleAxes();
          if (!axes.length) {
              alert('No variant rule axes resolved.');
              return;
          }

          const sel = currentSelectedTerms();
          const axesTerms = axes.map(aid => (sel[aid] || []));
          if (axesTerms.some(list => list.length === 0)) {
              const missing = axes.filter((_, i) => (axesTerms[i] || []).length === 0)
                  .map(aid => STATE.ATTRS[aid]?.name || aid);
              alert('Select terms for: ' + missing.join(', '));
              openTab('#tab-attrs');
              return;
          }

          const combos = cartesian(axesTerms.map(list => list.map(tid => tid)));
          const tbody = $('#variantTable tbody');
          if (!tbody) return;
          tbody.innerHTML = '';
          const wantImg = $('#variantWiseImage')?.checked;

          combos.forEach((combo) => {
              const pair = combo.map((tid, i) => [axes[i], tid]);
              const tr = document.createElement('tr');
              tr.innerHTML = `
                      <td>${axisTitle(pair)}</td>
                      <td><input class="form-control form-control-sm v-sku" placeholder="AUTO"></td>
                      <td class="vimg-cell ${wantImg?'':'hidden'}"><input type="file" accept="image/*" class="form-control form-control-sm v-img"></td>
                      <td class="text-end">
                          <button type="button" class="btn btn-sm btn-outline-secondary me-1 v-dup" title="Duplicate"><i class="bx bx-copy"></i></button>
                          <button type="button" class="btn btn-sm btn-outline-danger v-del" title="Delete"><i class="bx bx-trash"></i></button>
                      </td>`;

              tr.dataset.variant = JSON.stringify(pair);
              tbody.appendChild(tr);
          });

          $('#noVariantNote')?.classList.add('hidden');
          $('#skuSingle')?.setAttribute('disabled', '');
          toggleVariantImageColumn();

      });


      $('#variantTable')?.addEventListener('click', e => {
          const tr = e.target.closest?.('tr');
          if (!tr) return;
          if (e.target.closest?.('.v-del')) {
              tr.remove();
              if (!$('#variantTable tbody')?.children.length) {
                  resetVariants();
              }
          }
          if (e.target.closest?.('.v-dup')) {
              const clone = tr.cloneNode(true);
              $('#variantTable tbody')?.insertBefore(clone, tr.nextSibling);
          }
      });

      /* ===== SEO preview ===== */
      // $('#btnSeoPreview')?.addEventListener('click', () => {
      //     alert(`SEO Preview:
      //     Title: ${$('#metaTitle')?.value||$('#title')?.value||''}
      //     URL: /product/${$('#slug')?.value||slugify($('#title')?.value||'')}
      //     Description: ${( $('#metaDesc')?.value || $('#shortDesc')?.value || '' ).slice(0,160)}`);
      // });

      /* ===== Collect + validate ===== */
      function collectData() {
          const attrsPayload = {};
          $$('.term-check:checked').forEach(c => {
              const a = c.dataset.attr;
              (attrsPayload[a] || (attrsPayload[a] = [])).push(c.value);
          });
          const variants = [...($('#variantTable tbody')?.children || [])].map(tr => ({
              map: JSON.parse(tr.dataset.variant || '[]'),
              sku: tr.querySelector('.v-sku')?.value.trim() || ''
          }));
          return {
              title: $('#title')?.value.trim() || '',
              slug: $('#slug')?.value.trim() || slugify($('#title')?.value || ''),
              brand: $('#brand')?.value || '',
              categories: [...selectedCats],
              primaryCategory: primaryCat || '',
              attrSet: $('#attrSet')?.value || null,
              mediaRule: $('#mediaRule')?.value || null,
              variantRule: $('#variantRule')?.value || null,
              attributes: attrsPayload,
              variantWiseImage: $('#variantWiseImage')?.checked || false,
              variants,
              sizeChart: $('#sizeChart')?.value || null,
              seo: {
                  title: $('#metaTitle')?.value || '',
                  desc: $('#metaDesc')?.value || '',
                  keys: $('#metaKeys')?.value || ''
              },
              featured: $('#isFeatured')?.checked || false,
              visible: $('#visible')?.checked || true,
              status: $('#status')?.value || 'Draft'
          };
      }

      function validateBasic() {
          if (!($('#title')?.value || '').trim()) {
              openTab('#tab-basic');
              $('#title')?.focus();
              return false;
          }
          if (selectedCats.size === 0) {
              openTab('#tab-basic');
              alert('কমপক্ষে একটি ক্যাটাগরি লাগবে');
              return false;
          }
          return true;
      }


      /* ===== Init ===== */
      async function init() {
          openTab(location.hash && document.querySelector(location.hash) ? location.hash : '#tab-basic');
          try {
              await loadBootstrap();
              fillSelect(setSel, Object.values(STATE.ATTR_SETS), s => ({
                  value: s.id,
                  label: s.name
              }));
              fillSelect(mediaSel, STATE.RULES.media, r => ({
                  value: r.id,
                  label: r.name
              }));
              fillSelect(varRuleSel, [], null);
              renderCatChips();
              toggleVariantImageColumn();

              if (BOOT?.primaryCategory) {
                  selectedCats.add(BOOT.primaryCategory);
                  primaryCat = BOOT.primaryCategory;
                  syncPrimarySelect();
                  renderCatChips();
                  applyPrimaryConfig();
              }
              if (setSel?.value) await refreshVariantRuleForSet(); // pre-lock if needed
          } catch (err) {
              console.error('Bootstrap load failed:', err);
          }
      }
      init();

      // Load existing product data when editing
      @if(isset($isEdit) && $isEdit && isset($product) && $product)
      (function loadEditData() {
          // Pre-select attribute set if exists
          @if(isset($product->attribute_set_id) && $product->attribute_set_id)
          setTimeout(() => {
              const setSel = document.getElementById('attrSet');
              if (setSel) {
                  setSel.value = '{{ $product->attribute_set_id }}';
                  setSel.dispatchEvent(new Event('change'));
              }
          }, 500);
          @endif

          // Pre-select variant rule if exists
          @if(isset($product->variant_rule_id) && $product->variant_rule_id)
          setTimeout(() => {
              const varRuleSel = document.getElementById('variantRule');
              if (varRuleSel) {
                  varRuleSel.value = '{{ $product->variant_rule_id }}';
                  varRuleSel.dispatchEvent(new Event('change'));
              }
          }, 800);
          @endif

          // Load existing images into gallery
          @if(isset($productImages) && count($productImages) > 0)
          const existingImages = @json($productImages);
          const galleryEl = document.getElementById('gallery');
          if (galleryEl && existingImages.length > 0) {
              existingImages.forEach((img, index) => {
                  const imgUrl = '/storage/' + img.path;
                  const div = document.createElement('div');
                  div.className = 'gallery-item' + (img.is_cover ? ' is-cover' : '');
                  div.dataset.imageId = img.id;
                  div.innerHTML = `
                      <img src="${imgUrl}" alt="Product Image">
                      <div class="gallery-actions">
                          <button type="button" class="btn btn-sm btn-light" onclick="setCover(this)" title="Set as cover">
                              <i class="bx bx-star"></i>
                          </button>
                          <button type="button" class="btn btn-sm btn-danger" onclick="removeImage(this)" title="Remove">
                              <i class="bx bx-trash"></i>
                          </button>
                      </div>
                      ${img.is_cover ? '<span class="cover-badge">Cover</span>' : ''}
                  `;
                  galleryEl.appendChild(div);
              });
          }
          @endif

          console.log('Edit mode: Product ID = {{ $product->id }}');
      })();
      @endif

  })();
</script>

    @endpush

@endsection

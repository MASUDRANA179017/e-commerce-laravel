@extends('layouts.master')
@section('title', 'Size Chart Settings')
@section('content')

    @include('admin.business_settings.partials.size-chart-css')

    <div class="row g-2">
        <div class="col-lg-5">
            <div class="panel h-100">
                <div class="panel-header">
                    <h3 class="panel-title">Size Chart Templates (All Categories)</h3>
                </div>
                <div class="panel-body scroll-col" id="chart-templates"></div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="panel h-100">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h3 class="panel-title">Charts</h3>
                    <div class="d-flex gap-2">
                        <button class="create-btn-base" id="btnBlank"><i class="bx bx-table me-1"></i>Add Blank
                            Chart</button>
                    </div>
                </div>
                <div class="panel-body scroll-col">
                    <div class="drop-wrap">
                        <div id="chart-drop" class="drop-zone">
                            <div class="placeholder"><i class='bx bx-move ph-icon'></i>
                                <div>Drag a template chip here to create a chart</div>
                            </div>
                        </div>
                    </div>
                    <div id="chartsArea"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sizeChartModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scModalTitle">Size Chart</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Chart Name *</label>
                            <input id="scName" class="form-control" required placeholder="e.g., Unisex T-Shirt">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Unit</label>
                            <select id="scUnit" class="form-select">
                                <option value="cm">cm</option>
                                <option value="inch">inch</option>
                                <option value="mm">mm</option>
                                <option value="">None</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="scCategorySelect"></select>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="modal-section-title">Measurements</h6>
                    <div class="d-flex gap-2 mb-3">
                        <button class="select-btn-white" type="button" id="scAddColumn"><i
                                class="bx bx-plus"></i> Add Column</button>
                        <button class="select-btn-white" type="button" id="scAddRow"><i
                                class="bx bx-plus"></i> Add Row</button>
                        <button class="select-btn-info" type="button" id="scImportCsv"><i
                                class="bx bx-import"></i> Import CSV</button>
                        <button class="select-btn-info" type="button" id="scExportCsv"><i
                                class="bx bx-export"></i> Export CSV</button>
                    </div>
                    <div class="table-responsive">
                        <table id="scMeasurementsTable" class="table table-sm table-bordered align-middle"></table>
                    </div>

                    <hr class="my-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="modal-section-title">Notes</h6>
                            <textarea id="scNotes" class="form-control" rows="4" placeholder="e.g., Measure flat, tolerance ±1cm"></textarea>
                        </div>
                        <div class="col-md-6">
                            <h6 class="modal-section-title">Optional Chart Image</h6>
                            <input class="form-control" type="file" id="scImageInput" accept="image/*">
                        </div>
                    </div>

                    <hr class="my-4">
                    <div id="scLivePreview">
                        <h6 class="modal-section-title">Live Preview</h6>
                        <div class="table-responsive">
                            <table id="scPreviewTable" class="table table-sm table-striped"></table>
                        </div>
                        <div id="scPreviewNotes" class="mt-2 form-help"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="create-btn-white" type="button" id="scReset">Reset</button>
                    <button class="create-btn-info-alt" type="button" id="scSaveAndNew">Save & New</button>
                    <button class="create-btn-base" type="button" id="scSave">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="chartPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-show me-2"></i><span id="cpTitle">Preview</span></h6>
                    <button type="button" class="action-btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i></button>
                </div>
                <div class="modal-body" id="cpBody"></div>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ROUTES = {
                templatesIndex: @json(route('catalog.size_charts.templates.index')),
                saveChart: @json(route('catalog.size_charts.store')),
                updateChart: @json(route('catalog.size_charts.update', ['chart' => '__ID__'])),
                deleteChart: @json(route('catalog.size_charts.destroy', ['chart' => '__ID__'])),
                deleteChartImg: @json(route('catalog.size_charts.image.destroy', ['chart' => '__ID__'])),
                categories: @json(route('catalog.categories.index')),
                chartsIndex: @json(route('catalog.size_charts.data')),
            };
            const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

            const $ = s => document.querySelector(s);
            const $$ = s => Array.from(document.querySelectorAll(s));
            const toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                timer: 1800,
                showConfirmButton: false
            });

            function ensureSortable(cb) {
                if (window.Sortable) return cb();
                const s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js';
                s.onload = cb;
                s.onerror = () => {
                    console.warn('SortableJS failed to load');
                    cb();
                };
                document.head.appendChild(s);
            }

            async function ajax(url, opts = {}) {
                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        ...(opts.headers || {})
                    },
                    ...opts
                });
                const readText = async r => {
                    try {
                        return await r.text();
                    } catch {
                        return '';
                    }
                };
                if (!res.ok) {
                    const t = await readText(res);
                    let msg = `${res.status} ${res.statusText}`;
                    try {
                        const j = t ? JSON.parse(t) : null;
                        if (j?.message) msg = j.message;
                    } catch {}
                    throw new Error(msg);
                }
                const text = await readText(res);
                return text ? JSON.parse(text) : {};
            }

            let TPL_INDEX = {};
            let CATEGORIES = [];
            const chartsArea = $('#chartsArea');
            const chartDrop = $('#chart-drop');

            function createChartCard(tpl) {
                const card = document.createElement('div');
                card.className = 'chart-card';
                card.dataset.template = tpl.id ?? '';

                const chartData = {
                    name: tpl.name || 'Untitled',
                    unit: tpl.unit || '',
                    columns: Array.isArray(tpl.columns) ? [...tpl.columns] : ['Size'],
                    rows: Array.isArray(tpl.rows) ? JSON.parse(JSON.stringify(tpl.rows)) : [
                        ['']
                    ],
                    image: tpl.image || '',
                    notes: tpl.notes || '',
                };

                card.innerHTML = `
      <div class="panel-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <h5 class="m-0" data-title>${chartData.name}</h5>
          <input class="form-control form-control-sm d-none" style="max-width:260px" value="${chartData.name}" data-title-input>
        </div>
        <div class="d-flex gap-2" data-actions-view>
          <button class="create-btn-success" data-save-card>
            <i class="bx bx-save me-1"></i><span data-save-label>Save</span>
          </button>
          <button class="action-btn-success" data-edit-title title="Edit name"><i class="bx bx-edit-alt"></i></button>
          <button class="action-btn-info" data-preview title="Preview"><i class="bx bx-show"></i></button>
          <button class="action-btn-danger" data-remove title="Delete"><i class="bx bx-trash"></i></button>
        </div>
        <div class="d-flex gap-2 d-none" data-actions-edit>
          <button class="create-btn-base" data-save-title><i class="bx bx-save me-1"></i>Save</button>
          <button class="action-btn-secondary" data-cancel-title title="Cancel"><i class="bx bx-x"></i></button>
        </div>
      </div>

      <div class="panel-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="img-wrap">
            <img class="img-thumb ${chartData.image ? '' : 'd-none'}" data-img-prev ${chartData.image ? `src="${chartData.image}"` : ''}>
            <input type="file" accept=".jpg,.jpeg,.png,.webp,image/*" class="form-control form-control-sm" style="max-width:260px" data-img-input>
            <button class="action-btn-danger ${chartData.image ? '' : 'd-none'}" title="Remove image" data-img-remove><i class="bx bx-trash"></i></button>
          </div>
          <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width:auto" data-unit>
              <option value="cm"   ${chartData.unit==='cm'?'selected':''}>cm</option>
              <option value="inch" ${chartData.unit==='inch'?'selected':''}>inch</option>
              <option value="mm"   ${chartData.unit==='mm'?'selected':''}>mm</option>
              <option value=""     ${!chartData.unit?'selected':''}>—</option>
            </select>
            <button class="select-btn-white" data-add-col><i class="bx bx-plus me-1"></i>Column</button>
            <button class="select-btn-white" data-add-row><i class="bx bx-plus me-1"></i>Row</button>
          </div>
        </div>

        <div class="table-responsive"><table class="table mb-0"></table></div>

        <div class="mt-3">
          <label class="form-label small">Notes</label>
          <textarea class="form-control" data-notes placeholder="e.g., Measure flat, tolerance ±1cm">${chartData.notes}</textarea>
        </div>
      </div>`;

                const tableEl = card.querySelector('table');

                const renderTable = () => {
                    tableEl.innerHTML = `
        <thead>
          <tr>
            ${chartData.columns.map((col, cIdx) =>
              `<th><span class="col-title" data-col-idx="${cIdx}">${col}</span>
                     <i class="bx bx-x col-del" data-col-idx="${cIdx}" title="Remove column"></i></th>`
            ).join('')}
            <th style="width:54px;"></th>
          </tr>
        </thead>
        <tbody>
          ${chartData.rows.map((row, rIdx) => `
                <tr>
                  ${chartData.columns.map((_, cIdx) =>
                    `<td><input class="form-control form-control-sm" data-row="${rIdx}" data-col="${cIdx}" value="${row[cIdx] ?? ''}"></td>`
                  ).join('')}
                  <td class="text-end">
                    <button class="action-btn-danger" data-del-row="${rIdx}" title="Delete row"><i class="bx bx-trash"></i></button>
                  </td>
                </tr>`
          ).join('')}
        </tbody>`;
                };

                const wireTableEvents = () => {
                    tableEl.addEventListener('input', e => {
                        const inp = e.target;
                        if (inp.matches('input[data-row][data-col]')) {
                            const r = +inp.dataset.row,
                                c = +inp.dataset.col;
                            if (!Array.isArray(chartData.rows[r])) chartData.rows[r] = [];
                            chartData.rows[r][c] = inp.value;
                        }
                    });

                    tableEl.addEventListener('click', e => {
                        const del = e.target.closest('.col-del');
                        const title = e.target.closest('.col-title');
                        const rowDel = e.target.closest('[data-del-row]');

                        if (del) {
                            const cIdx = +del.dataset.colIdx;
                            if (chartData.columns.length <= 1) {
                                toast.fire({
                                    icon: 'error',
                                    title: 'Cannot delete last column'
                                });
                                return;
                            }
                            chartData.columns.splice(cIdx, 1);
                            chartData.rows.forEach(r => r.splice(cIdx, 1));
                            rerender();
                            return;
                        }

                        if (title) {
                            const cIdx = +title.dataset.colIdx;
                            Swal.fire({
                                    title: 'Rename Column',
                                    input: 'text',
                                    inputValue: chartData.columns[cIdx],
                                    showCancelButton: true,
                                    confirmButtonText: 'Rename'
                                })
                                .then(res => {
                                    if (res.isConfirmed && res.value.trim()) {
                                        chartData.columns[cIdx] = res.value.trim();
                                        rerender();
                                    }
                                });
                            return;
                        }

                        if (rowDel) {
                            const rIdx = +rowDel.dataset.delRow;
                            chartData.rows.splice(rIdx, 1);
                            rerender();
                        }
                    });
                };

                const rerender = () => {
                    renderTable();
                    wireTableEvents();
                };
                rerender();

                const tEl = card.querySelector('[data-title]');
                const tIn = card.querySelector('[data-title-input]');
                const vAct = card.querySelector('[data-actions-view]');
                const eAct = card.querySelector('[data-actions-edit]');
                const toggleTitleEdit = on => {
                    tEl.classList.toggle('d-none', on);
                    tIn.classList.toggle('d-none', !on);
                    vAct.classList.toggle('d-none', on);
                    eAct.classList.toggle('d-none', !on);
                    if (on) {
                        tIn.focus();
                        tIn.select();
                    }
                };
                card.querySelector('[data-edit-title]').onclick = () => toggleTitleEdit(true);
                card.querySelector('[data-cancel-title]').onclick = () => {
                    tIn.value = tEl.textContent.trim();
                    toggleTitleEdit(false);
                };
                card.querySelector('[data-save-title]').onclick = () => {
                    const v = tIn.value.trim() || 'Untitled';
                    tEl.textContent = v;
                    chartData.name = v;
                    toggleTitleEdit(false);
                };

                card.querySelector('[data-unit]').addEventListener('change', e => chartData.unit = e.target.value);
                card.querySelector('[data-notes]').addEventListener('input', e => chartData.notes = e.target.value);

                card.querySelector('[data-add-row]').onclick = () => {
                    chartData.rows.push(new Array(chartData.columns.length).fill(''));
                    rerender();
                };
                card.querySelector('[data-add-col]').onclick = () => {
                    Swal.fire({
                            title: 'New Column Name',
                            input: 'text',
                            showCancelButton: true,
                            returnFocus: false,
                            didOpen: () => {
                                const i = Swal.getInput();
                                if (i) i.focus();
                            }
                        })
                        .then(res => {
                            if (res.isConfirmed && res.value.trim()) {
                                chartData.columns.push(res.value.trim());
                                chartData.rows.forEach(r => r.push(''));
                                rerender();
                            }
                        });
                };

                // Delete chart (persisted if has id)
                card.querySelector('[data-remove]').onclick = async () => {
                    const r = await Swal.fire({
                        title: 'Delete this chart?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33'
                    });
                    if (!r.isConfirmed) return;
                    if (!card.dataset.chartId) {
                        card.remove();
                        toast.fire({
                            icon: 'success',
                            title: 'Chart deleted'
                        });
                        return;
                    }
                    try {
                        await ajax(ROUTES.deleteChart.replace('__ID__', card.dataset.chartId), {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': CSRF
                            }
                        });
                        card.remove();
                        toast.fire({
                            icon: 'success',
                            title: 'Chart deleted'
                        });
                    } catch (e) {
                        toast.fire({
                            icon: 'error',
                            title: e.message || 'Delete failed'
                        });
                    }
                };

                // Preview
                card.querySelector('[data-preview]').onclick = () => {
                    $('#cpTitle').textContent = `Preview — ${chartData.name} (unit: ${chartData.unit || '—'})`;
                    const imgHTML = chartData.image ?
                        `<div class="mb-3"><img src="${chartData.image}" style="max-width:160px;border-radius:8px"></div>` :
                        '';
                    const notesHTML = chartData.notes ?
                        `<div class="mt-2 fst-italic text-muted">${chartData.notes}</div>` : '';
                    $('#cpBody').innerHTML =
                        imgHTML +
                        `<div class="table-responsive"><table class="table table-sm">
          <thead><tr>${chartData.columns.map(h=>`<th>${h}</th>`).join('')}</tr></thead>
          <tbody>${chartData.rows.map(row=>`<tr>${row.map(cell=>`<td>${cell ?? ''}</td>`).join('')}</tr>`).join('')}</tbody>
        </table></div>` + notesHTML;
                    new bootstrap.Modal('#chartPreviewModal').show();
                };

                // Image upload/remove
                const imgInp = card.querySelector('[data-img-input]');
                const imgPrev = card.querySelector('[data-img-prev]');
                const imgRem = card.querySelector('[data-img-remove]');

                imgInp.addEventListener('change', e => {
                    const f = e.target.files?.[0];
                    if (!f) return;
                    const reader = new FileReader();
                    reader.onload = ev => {
                        chartData.image = ev.target.result;
                        if (imgPrev) {
                            imgPrev.src = chartData.image;
                            imgPrev.classList.remove('d-none');
                        }
                        if (imgRem) {
                            imgRem.classList.remove('d-none');
                        }
                    };
                    reader.readAsDataURL(f);
                });

                imgRem.addEventListener('click', async () => {
                    const r = await Swal.fire({
                        title: 'Remove image?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Remove'
                    });
                    if (!r.isConfirmed) return;

                    if (card.dataset.chartId) {
                        try {
                            await ajax(ROUTES.deleteChartImg.replace('__ID__', card.dataset.chartId), {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF
                                }
                            });
                        } catch (e) {
                            toast.fire({
                                icon: 'error',
                                title: e.message || 'Failed to remove image'
                            });
                            return;
                        }
                    }

                    chartData.image = '';
                    if (imgPrev) {
                        imgPrev.src = '';
                        imgPrev.classList.add('d-none');
                    }
                    imgInp.value = '';
                    imgRem.classList.add('d-none');
                    toast.fire({
                        icon: 'success',
                        title: 'Image removed'
                    });
                });

                // Save / Update
                const saveBtn = card.querySelector('[data-save-card]');
                const saveLabel = card.querySelector('[data-save-label]');

                function refreshSaveLabel() {
                    saveLabel.textContent = card.dataset.chartId ? 'Update' : 'Save';
                }
                refreshSaveLabel();

                function serializeCard() {
                    return {
                        name: (chartData.name || 'Untitled').trim(),
                        unit: chartData.unit || null,
                        columns: chartData.columns,
                        rows: (chartData.rows || []).filter(r => Array.isArray(r) && r.some(c => String(c || '')
                            .trim() !== '')),
                        notes: chartData.notes || null,
                        image_base64: (chartData.image && chartData.image.startsWith('data:')) ? chartData.image :
                            null,
                        remove_image: (!!card.dataset.chartId && chartData.image === '') ? true : undefined,
                    };
                }

                saveBtn.onclick = async () => {
                    try {
                        saveBtn.disabled = true;
                        saveBtn.innerHTML =
                            `<span class="spinner-border spinner-border-sm me-1"></span>${card.dataset.chartId ? 'Updating' : 'Saving'}`;
                        const body = serializeCard();

                        let json;
                        if (card.dataset.chartId) {
                            const url = ROUTES.updateChart.replace('__ID__', card.dataset.chartId);
                            json = await ajax(url, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': CSRF
                                },
                                body: JSON.stringify(body)
                            });
                        } else {
                            json = await ajax(ROUTES.saveChart, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': CSRF
                                },
                                body: JSON.stringify(body)
                            });
                            card.dataset.chartId = json.id;
                            refreshSaveLabel();
                        }

                        chartData.name = json.name ?? chartData.name;
                        chartData.unit = json.unit ?? chartData.unit;
                        chartData.columns = Array.isArray(json.columns) ? json.columns : chartData.columns;
                        chartData.rows = Array.isArray(json.rows) ? json.rows : chartData.rows;
                        chartData.notes = json.notes ?? chartData.notes;

                        const titleEl = card.querySelector('[data-title]');
                        if (titleEl) titleEl.textContent = chartData.name;

                        if (json.image) {
                            chartData.image = json.image;
                            if (imgPrev) {
                                imgPrev.src = json.image;
                                imgPrev.classList.remove('d-none');
                            }
                            imgRem.classList.remove('d-none');
                        }

                        toast.fire({
                            icon: 'success',
                            title: card.dataset.chartId ? 'Chart updated' : 'Chart saved'
                        });
                    } catch (e) {
                        toast.fire({
                            icon: 'error',
                            title: e.message || 'Save failed'
                        });
                    } finally {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML =
                            `<i class="bx bx-save me-1"></i><span data-save-label>${card.dataset.chartId ? 'Update' : 'Save'}</span>`;
                    }
                };

                card.refreshSaveLabel = refreshSaveLabel;
                return card;
            }

            async function loadCategories() {
                try {
                    const json = await ajax(ROUTES.categories);
                    CATEGORIES = (json.categories || []).map(c => ({
                        slug: c.slug,
                        name: c.name
                    }));
                } catch {
                    CATEGORIES = [];
                }
            }

            async function loadTemplatesAndRender() {
                const wrap = $('#chart-templates');
                wrap.innerHTML =
                    `<div class="initial-msg"><i class='bx bx-loader-alt bx-spin' style="font-size:2rem"></i><p>Loading templates...</p></div>`;
                try {
                    const json = await ajax(ROUTES.templatesIndex);
                    const grouped = json.templates_by_category || {};
                    TPL_INDEX = {};
                    wrap.innerHTML = '';

                    Object.keys(grouped).forEach(cat => {
                        const items = grouped[cat] || [];
                        const card = document.createElement('div');
                        card.className = 'source-card';
                        card.innerHTML = `
          <div class="attr-head">
            <div>
              <div class="attr-name">${cat}</div>
              <div class="small-muted">${items.length} templates</div>
            </div>
            <span class="badge">drag to use</span>
          </div>
          <div class="chips" data-cat="${cat}">
            ${items.map(t=>`<div class="chip" data-template-id="${t.id}"><i class="bx bx-move me-1"></i>${t.name}</div>`).join('')}
          </div>`;
                        const chipsEl = card.querySelector('.chips');
                        new Sortable(chipsEl, {
                            group: {
                                name: 'chart',
                                pull: 'clone',
                                put: false
                            },
                            sort: false,
                            animation: 150
                        });
                        chipsEl.addEventListener('click', e => {
                            const chip = e.target.closest('.chip');
                            if (!chip) return;
                            const tpl = TPL_INDEX[String(chip.dataset.templateId)];
                            if (!tpl) return;
                           chartsArea.prepend(createChartCard(tpl));
                            toast.fire({
                                icon: 'success',
                                title: 'Chart created'
                            });
                        });
                        items.forEach(t => {
                            TPL_INDEX[String(t.id)] = t;
                        });
                        wrap.appendChild(card);
                    });

                    if (!wrap.children.length) wrap.innerHTML =
                        `<div class="initial-msg">No templates found.</div>`;
                } catch {
                    wrap.innerHTML = `<div class="initial-msg text-danger">Failed to load templates</div>`;
                }
            }

            function setupDropzone() {
                if (!chartDrop) return;
                new Sortable(chartDrop, {
                    group: {
                        name: 'chart',
                        put: true,
                        pull: false
                    },
                    animation: 150,
                    onStart: () => chartDrop.classList.add('drag-over'),
                    onEnd: () => chartDrop.classList.remove('drag-over'),
                    onAdd: (evt) => {
                        const id = evt.item.dataset.templateId;
                        const tpl = TPL_INDEX[String(id)];
                        if (!tpl) {
                            evt.item.remove();
                            return;
                        }
                        chartsArea.prepend(createChartCard(tpl));
                        evt.item.remove();
                        toast.fire({
                            icon: 'success',
                            title: 'Chart created'
                        });
                    }
                });
            }

            const sizeChartModal = new bootstrap.Modal('#sizeChartModal', {
                focus: false
            });
            let modalChartData = {};
            let initialModalData = {};

            const DEFAULT_BLANK_CHART = {
                name: '',
                unit: 'cm',
                category: 'clothing',
                columns: ['Size', 'Chest', 'Length', 'Shoulder'],
                rows: [
                    ['', '', '', '']
                ],
                notes: '',
                image: ''
            };

            function renderLivePreview() {
                const table = $('#scPreviewTable');
                const notes = $('#scPreviewNotes');
                table.innerHTML = `
      <thead><tr>${modalChartData.columns.map(c => `<th>${c}</th>`).join('')}</tr></thead>
      <tbody>${modalChartData.rows.map(r => `<tr>${r.map(c => `<td>${c}</td>`).join('')}</tr>`).join('')}</tbody>`;
                notes.textContent = modalChartData.notes || '';
            }

            function renderModalTable() {
                const table = $('#scMeasurementsTable');
                table.textContent = '';

                if (!Array.isArray(modalChartData.columns) || !modalChartData.columns.length) modalChartData
                    .columns = ['Column 1'];
                if (!Array.isArray(modalChartData.rows) || !modalChartData.rows.length) modalChartData.rows = [
                    new Array(modalChartData.columns.length).fill('')
                ];
                modalChartData.rows = modalChartData.rows.map(r => {
                    const row = Array.isArray(r) ? r.slice(0, modalChartData.columns.length) : [];
                    while (row.length < modalChartData.columns.length) row.push('');
                    return row;
                });

                const thead = table.createTHead();
                const headerRow = thead.insertRow();
                modalChartData.columns.forEach((colName, colIndex) => {
                    const th = document.createElement('th');
                    th.style.position = 'relative';
                    th.style.paddingRight = '28px';

                    const title = document.createElement('span');
                    title.className = 'col-title';
                    title.title = 'Rename';
                    title.textContent = colName;
                    title.dataset.colIdx = colIndex;
                    title.onclick = () => {
                        Swal.fire({
                                title: 'Column Name',
                                input: 'text',
                                inputValue: modalChartData.columns[colIndex],
                                showCancelButton: true
                            })
                            .then(res => {
                                if (res.isConfirmed && res.value.trim()) {
                                    modalChartData.columns[colIndex] = res.value.trim();
                                    renderModalTable();
                                }
                            });
                    };

                    const del = document.createElement('i');
                    del.className = 'bx bx-x col-del';
                    del.title = 'Delete';
                    del.dataset.colIdx = colIndex;
                    Object.assign(del.style, {
                        position: 'absolute',
                        top: '50%',
                        right: '4px',
                        transform: 'translateY(-50%)',
                        cursor: 'pointer',
                        opacity: '.7'
                    });
                    del.onmouseenter = () => (del.style.opacity = '1');
                    del.onmouseleave = () => (del.style.opacity = '.7');
                    del.onclick = () => {
                        if (modalChartData.columns.length <= 1) return;
                        modalChartData.columns.splice(colIndex, 1);
                        modalChartData.rows.forEach(r => r.splice(colIndex, 1));
                        renderModalTable();
                    };

                    th.append(title, del);
                    headerRow.appendChild(th);
                });
                headerRow.insertCell().style.width = '50px';

                const tbody = table.createTBody();
                modalChartData.rows.forEach((rowData, rowIndex) => {
                    const tr = tbody.insertRow();
                    modalChartData.columns.forEach((_, colIndex) => {
                        const td = tr.insertCell();
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.autocomplete = 'off';
                        input.spellcheck = false;
                        input.className = 'form-control form-control-sm';
                        input.value = rowData[colIndex] ?? '';
                        input.oninput = () => {
                            modalChartData.rows[rowIndex][colIndex] = input.value;
                            renderLivePreview();
                        };
                        td.appendChild(input);
                    });
                    const actionCell = tr.insertCell();
                    const btn = document.createElement('button');
                    btn.className = 'action-btn-danger';
                    btn.innerHTML = '<i class="bx bx-trash"></i>';
                    btn.onclick = () => {
                        modalChartData.rows.splice(rowIndex, 1);
                        renderModalTable();
                    };
                    actionCell.appendChild(btn);
                });

                renderLivePreview();
            }

            function populateCategorySelect() {
                const catSelect = $('#scCategorySelect');
                const list = CATEGORIES.length ? CATEGORIES : [{
                    slug: 'clothing',
                    name: 'clothing'
                }];
                catSelect.innerHTML = list.map(c =>
                    `<option value="${c.slug}" ${c.slug===modalChartData.category?'selected':''}>${c.name}</option>`
                    ).join('');
                catSelect.onchange = e => {
                    modalChartData.category = e.target.value;
                };
            }

            function openSizeChartModal(initialData = null) {
                initialModalData = JSON.parse(JSON.stringify(initialData || DEFAULT_BLANK_CHART));
                modalChartData = JSON.parse(JSON.stringify(initialModalData));

                $('#scModalTitle').textContent = `Size Chart — ${modalChartData.name || 'New Chart'}`;

                const nameInput = $('#scName');
                nameInput.value = modalChartData.name;
                nameInput.oninput = () => {
                    modalChartData.name = nameInput.value;
                    $('#scModalTitle').textContent = `Size Chart — ${modalChartData.name || 'New Chart'}`;
                    renderLivePreview();
                };

                const unitInput = $('#scUnit');
                unitInput.value = modalChartData.unit;
                unitInput.oninput = () => {
                    modalChartData.unit = unitInput.value;
                    renderLivePreview();
                };

                const notesInput = $('#scNotes');
                notesInput.value = modalChartData.notes;
                notesInput.oninput = () => {
                    modalChartData.notes = notesInput.value;
                    renderLivePreview();
                };

                $('#scImageInput').value = '';
                populateCategorySelect();
                renderModalTable();
                sizeChartModal.show();
            }

            async function saveChartFromModal() {
                if (!modalChartData.name.trim()) {
                    toast.fire({
                        icon: 'error',
                        title: 'Chart Name is required'
                    });
                    return false;
                }
                const payload = {
                    name: modalChartData.name,
                    unit: modalChartData.unit || null,
                    category_slug: modalChartData.category || null,
                    columns: modalChartData.columns,
                    rows: modalChartData.rows.filter(r => r.some(c => String(c).trim() !== '')),
                    notes: modalChartData.notes || null,
                    image_base64: modalChartData.image || null,
                };
                try {
                    const saved = await ajax(ROUTES.saveChart, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF
                        },
                        body: JSON.stringify(payload)
                    });
                    const tpl = {
                        id: 'chart_' + saved.id,
                        name: saved.name,
                        unit: saved.unit,
                        columns: saved.columns,
                        rows: saved.rows,
                        image: saved.image || ''
                    };
                    const card = createChartCard(tpl);
                    card.dataset.chartId = saved.id;
                    card.refreshSaveLabel?.();
                    chartsArea.appendChild(card);
                    toast.fire({
                        icon: 'success',
                        title: 'Chart saved'
                    });
                    return true;
                } catch (e) {
                    toast.fire({
                        icon: 'error',
                        title: e.message || 'Save failed'
                    });
                    return false;
                }
            }

            $('#btnBlank').addEventListener('click', () => openSizeChartModal());
            $('#scAddRow').addEventListener('click', () => {
                modalChartData.rows.push(new Array(modalChartData.columns.length).fill(''));
                renderModalTable();
            });
            $('#scAddColumn').addEventListener('click', () => {
                Swal.fire({
                        title: 'New Column Name',
                        input: 'text',
                        showCancelButton: true,
                        returnFocus: false,
                        didOpen: () => {
                            const i = Swal.getInput();
                            if (i) i.focus();
                        }
                    })
                    .then(res => {
                        if (res.isConfirmed && res.value.trim()) {
                            modalChartData.columns.push(res.value.trim());
                            modalChartData.rows.forEach(r => r.push(''));
                            renderModalTable();
                        }
                    });
            });
            $('#scImageInput').addEventListener('change', e => {
                const file = e.target.files?.[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = ev => {
                    modalChartData.image = ev.target.result;
                };
                reader.readAsDataURL(file);
            });
            $('#scImportCsv').onclick = () => toast.fire({
                icon: 'info',
                title: 'CSV Import (coming soon)'
            });
            $('#scExportCsv').onclick = () => toast.fire({
                icon: 'info',
                title: 'CSV Export (coming soon)'
            });
            $('#scReset').onclick = () => openSizeChartModal(initialModalData);
            $('#scSave').onclick = async () => {
                if (await saveChartFromModal()) sizeChartModal.hide();
            };
            $('#scSaveAndNew').onclick = async () => {
                if (await saveChartFromModal()) openSizeChartModal();
            };

            async function loadExistingCharts() {
                const area = document.getElementById('chartsArea');
                area.innerHTML =
                    `<div class="initial-msg"><i class='bx bx-loader-alt bx-spin' style="font-size:2rem"></i><p>Loading saved charts...</p></div>`;
                try {
                    const json = await ajax(ROUTES.chartsIndex);
                    const charts = Array.isArray(json.charts) ? json.charts : [];
                    area.innerHTML = '';
                    if (!charts.length) {
                        area.innerHTML = `<div class="initial-msg">No saved charts yet.</div>`;
                        return;
                    }
                    charts.forEach(ch => {
                        const tpl = {
                            id: ch.id,
                            name: ch.name || 'Untitled',
                            unit: ch.unit || '',
                            columns: Array.isArray(ch.columns) ? ch.columns : ['Size'],
                            rows: Array.isArray(ch.rows) ? ch.rows : [
                                ['']
                            ],
                            image: ch.image || '',
                            notes: ch.notes || '',
                        };
                        const card = createChartCard(tpl);
                        card.dataset.chartId = ch.id;
                        card.refreshSaveLabel?.();
                        area.appendChild(card);
                    });
                } catch (e) {
                    console.error('chartsIndex failed:', e);
                    area.innerHTML = `<div class="initial-msg text-danger">Failed to load saved charts</div>`;
                }
            }

            ensureSortable(async () => {
                await loadCategories();
                setupDropzone();
                loadTemplatesAndRender();
                loadExistingCharts();
            });
        });
    </script>
@endpush

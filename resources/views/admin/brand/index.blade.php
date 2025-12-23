@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @include('admin.brand.partials.css.brand-css')
 
    <div class="row g-2">
        <div class="col-lg-4">
            <div class="panel h-100">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h3 class="panel-title">Brand Presets</h3>
                    <span class="badge">Drag to add →</span>
                </div>
                <div class="panel-body scroll-col" id="preset-source"></div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="panel h-100">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h3 class="panel-title">Manage Brands</h3>
                    <button class="create-btn-base" id="btnAddBrand"><i class="bx bx-plus me-1"></i>Add Brand</button>
                </div>
                <div class="panel-body scroll-col">
                    <div class="drop-wrap">
                        <div id="brandDrop" class="drop-zone">
                            <div class="placeholder"><i class='bx bx-move ph-icon'></i>
                                <div>Drag brand chips here to add</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" id="brandTable">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Brand</th>
                                    <th>Slug</th>
                                    <th>Country</th>
                                    <th>Website</th>
                                    <th>Featured</th>
                                    <th>Active</th>
                                    <th class="text-end" style="width:180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="brand-table-body"></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Brand Modal -->
    <div class="modal fade" id="brandModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-buildings me-2"></i><span id="bmTitle">Add Brand</span></h6>
                    <button type="button" class="action-btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i></button>
                </div>
                <form id="brandForm">
                    <div class="modal-body">
                        <input type="hidden" id="bmId">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Brand Name</label><input id="bmName"
                                    class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">Slug</label><input id="bmSlug"
                                    class="form-control" placeholder="auto"></div>
                            <div class="col-md-6"><label class="form-label">Website</label><input id="bmWebsite"
                                    class="form-control" placeholder="https://"></div>
                            <div class="col-md-3"><label class="form-label">Country</label><select id="bmCountry"
                                    class="form-select">
                                    <option value="">—</option>
                                    <option>US</option>
                                    <option>UK</option>
                                    <option>DE</option>
                                    <option>FR</option>
                                    <option>JP</option>
                                    <option>KR</option>
                                    <option>CN</option>
                                    <option>IN</option>
                                    <option>BD</option>
                                </select></div>
                            <div class="col-md-3"><label class="form-label">Order</label><input id="bmOrder" type="number"
                                    class="form-control" value="0"></div>
                            <div class="col-md-6"><label class="form-label">Logo</label><input id="bmLogo" type="file"
                                    class="form-control" accept="image/*">
                                <div class="small-muted mt-1">Square 256×256 PNG/WebP.</div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end gap-2"><img id="bmLogoPreview" class="brand-logo"
                                    src="https://via.placeholder.com/64?text=LOGO" alt=""></div>
                            <div class="col-12"><label class="form-label">Description</label><textarea id="bmDesc"
                                    class="form-control" rows="2"></textarea></div>
                            <div class="col-md-4">
                                <div class="form-check form-switch mt-4"><input class="form-check-input" type="checkbox"
                                        id="bmFeatured"><label class="form-check-label" for="bmFeatured">Featured</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch mt-4"><input class="form-check-input" type="checkbox"
                                        id="bmActive" checked><label class="form-check-label" for="bmActive">Active</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch mt-4"><input class="form-check-input" type="checkbox"
                                        id="bmTop"><label class="form-check-label" for="bmTop">Show on Top</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button class="create-btn-base" type="submit"><i
                                class="bx bx-save me-1"></i>Save</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="brandPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-show me-2"></i>Brand Preview</h6><button type="button"
                        class="btn-icon" data-bs-dismiss="modal"><i class="bx bx-x"></i></button>
                </div>
                <div class="modal-body" id="bpBody"></div>
            </div>
        </div>
    </div>







    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var $ = function (s) { return document.querySelector(s) }, $$ = function (s) { return Array.prototype.slice.call(document.querySelectorAll(s)) };
                var toast = Swal.mixin({ toast: true, position: 'top-end', timer: 1600, showConfirmButton: false });
                function slugify(s) { return (s || '').toString().trim().toLowerCase().replace(/[\s_]+/g, '-').replace(/[^a-z0-9\-]/g, '').replace(/\-+/g, '-').replace(/^\-+|\-+$/g, ''); }
                function placeholderUrl(text, size) {
                    var s = size || 36;
                    var t = (String(text || '').slice(0, 2) || 'B').toUpperCase();
                    var svg = "<svg xmlns='http://www.w3.org/2000/svg' width='" + s + "' height='" + s + "'><rect width='100%' height='100%' fill='#EEE'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-size='" + Math.round(s * 0.5) + "' fill='#888' font-family='Arial, sans-serif'>" + t + "</text></svg>";
                    return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
                }

               

                var PRESETS = @json($brands); // Laravel blade directive
                var pre = $('#bmLogoPreview'); if (pre) pre.src = placeholderUrl('LOGO', 64);

                function renderPresetCards() {
                    var wrap = $('#preset-source'); wrap.innerHTML = '';
                    PRESETS.forEach(function (group) {
                        var card = document.createElement('div'); card.className = 'source-card';
                        var h = ''; h += '<div class="attr-head"><div><div class="attr-name">' + group.cat + '</div><div class="small-muted">' + group.items.length + ' brands</div></div></div>';
                        h += '<div class="chips" data-cat="' + group.cat + '">';
                        group.items.forEach(function (b) {
                            h += '<div class="chip" data-name="' + b.name + '" data-country="' + (b.country || '') + '"><img class="brand-logo" src="' + placeholderUrl((b.name[0] || 'B'), 36) + '" alt=""><span>' + b.name + '</span></div>';
                        });
                        h += '</div>'; card.innerHTML = h;
                        new Sortable(card.querySelector('.chips'), { group: { name: 'brandshare', pull: 'clone', put: false }, sort: false, animation: 150 });
                        card.querySelector('.chips').addEventListener('click', function (e) {
                            var chip = e.target.closest('.chip'); if (!chip) return;
                            addBrand({ name: chip.dataset.name, country: chip.dataset.country });
                        });
                        wrap.appendChild(card);
                    });
                }


                var BRANDS = [];
                var drop = $('#brandDrop'), tbody = $('#brandTable tbody'), bModal = new bootstrap.Modal('#brandModal'), prevModal = new bootstrap.Modal('#brandPreviewModal');

                function rid() { return 'b_' + Math.random().toString(36).slice(2, 8); }
                function rowHTML(b) {
                    var w = b.website ? '<a href="' + b.website + '" target="_blank">Visit</a>' : '';
                    return '<tr data-id="' + b.id + '">' +
                        '<td><img class="brand-logo" src="' + (b.logo || placeholderUrl('LOGO', 64)) + '" alt=""></td>' +
                        '<td><span class="fw-semibold">' + b.name + '</span></td>' +
                        '<td class="kbd">' + b.slug + '</td>' +
                        '<td>' + (b.country || '') + '</td>' +
                        '<td>' + w + '</td>' +
                        '<td><div class="form-check form-switch"><input class="form-check-input featureToggle" type="checkbox" ' + (b.featured ? 'checked' : '') + '></div></td>' +
                        '<td><div class="form-check form-switch"><input class="form-check-input activeToggle" type="checkbox" ' + (b.active ? 'checked' : '') + '></div></td>' +
                        '<td class="text-end">' +
                        '<button class="action-btn-info" data-preview title="Preview"><i class="bx bx-show"></i></button> ' +
                        '<button class="action-btn-success" data-edit title="Edit"><i class="bx bx-edit-alt"></i></button> ' +
                        '<button class="action-btn-danger" data-del title="Delete"><i class="bx bx-trash"></i></button>' +
                        '</td></tr>';
                }

                // function renderTable() {
                //     tbody.innerHTML = ''; BRANDS.sort(function (a, b) { return (a.order || 0) - (b.order || 0); });
                //     BRANDS.forEach(function (b) { tbody.insertAdjacentHTML('beforeend', rowHTML(b)); });
                //     bindRowEvents();

                // }




                // function bindRowEvents() {
                //     $$('#brandTable .featureToggle').forEach(function (t) { t.onchange = function (e) { var id = e.target.closest('tr').dataset.id; var b = BRANDS.find(function (x) { return x.id === id }); if (b) b.featured = e.target.checked; }; });
                //     $$('#brandTable .activeToggle').forEach(function (t) { t.onchange = function (e) { var id = e.target.closest('tr').dataset.id; var b = BRANDS.find(function (x) { return x.id === id }); if (b) b.active = e.target.checked; }; });
                //     $$('#brandTable [data-preview]').forEach(function (btn) {
                //         btn.onclick = function () {
                //             var id = btn.closest('tr').dataset.id; var b = BRANDS.find(function (x) { return x.id === id });
                //             $('#bpBody').innerHTML = '<div class="d-flex align-items-center gap-2 mb-2"><img class="brand-logo" src="' + (b.logo || 'https://via.placeholder.com/64?text=LOGO') + '"><div><div class="fw-semibold">' + b.name + '</div><div class="small-muted">' + b.slug + ' • ' + (b.country || '') + '</div></div></div><div class="mb-1"><strong>Website:</strong> ' + (b.website ? ('<a href="' + b.website + '" target="_blank">' + b.website + '</a>') : '—') + '</div><div class="mb-1"><strong>Featured:</strong> ' + (b.featured ? 'Yes' : 'No') + '</div><div class="mb-1"><strong>Status:</strong> ' + (b.active ? 'Active' : 'Inactive') + '</div><div class="mb-1"><strong>Order:</strong> ' + (b.order || 0) + '</div><div class="mb-1"><strong>Description:</strong><br>' + (b.desc || '—') + '</div>';
                //             prevModal.show();
                //         };
                //     });
                //     $$('#brandTable [data-edit]').forEach(function (btn) { btn.onclick = function () { var id = btn.closest('tr').dataset.id; var b = BRANDS.find(function (x) { return x.id === id }); openBrandModal(b); }; });
                //     $$('#brandTable [data-del]').forEach(function (btn) { btn.onclick = function () { var id = btn.closest('tr').dataset.id; Swal.fire({ title: 'Delete brand?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33' }).then(function (ok) { if (ok.isConfirmed) { BRANDS = BRANDS.filter(function (x) { return x.id !== id }); renderTable();  toast.fire({ icon: 'success', title: 'Brand deleted' }); } }); }; });
                // }



                // function addBrand(obj) {
                //     var slug = slugify(obj.name);
                //     for (var i = 0; i < BRANDS.length; i++) { if (BRANDS[i].slug === slug) { Swal.fire({ icon: 'info', title: 'Brand exists', text: obj.name + ' already in list.' }); return; } }
                //     BRANDS.push({ id: rid(), name: obj.name, slug: slug, country: obj.country || '', website: '', featured: false, active: true, order: BRANDS.length + 1, logo: 'https://via.placeholder.com/64?text=' + encodeURIComponent((obj.name[0] || 'B').toUpperCase()), desc: '' });
                //     renderTable(); toast.fire({ icon: 'success', title: 'Brand added' });
                // }



               
                // drag & drop with brand template store into brand table
                new Sortable(document.getElementById('brandDrop'), {
                    group: { name:'brandshare', pull:true, put:true },
                    animation: 150,
                    fallbackOnBody: true,
                    onAdd: function(evt){
                        var chip = evt.item;
                        var name = chip.dataset.name;
                        var country = chip.dataset.country || '';

                        // AJAX store into backend
                        jQuery.ajax({
                            url: "{{ route('admin.brand.storeIntoBrand') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                name: name,
                                country: country
                            },
                            success: function(response){
                                if(response.success){
                                    toast.fire({ icon:'success', title: response.message || 'Brand added' });
                                    // remove the dragged chip
                                    chip.parentNode && chip.parentNode.removeChild(chip);
                                    loadBrands(); // reload table from backend
                                } else {
                                    Swal.fire({ icon:'error', title:'Error', text: response.message });
                                    chip.parentNode && chip.parentNode.removeChild(chip);
                                }
                            },
                            error: function(xhr){
                                Swal.fire({ icon:'error', title:'Failed', text:'Server error' });
                                chip.parentNode && chip.parentNode.removeChild(chip);
                            }
                        });
                    }
                });


                // left presets
                renderPresetCards();


                // modal handlers
                var brandModal = new bootstrap.Modal('#brandModal');
                function openBrandModal(b) {
                    $('#bmTitle').textContent = b ? 'Edit Brand' : 'Add Brand';
                    $('#bmId').value = b ? b.id : '';
                    $('#bmName').value = b ? b.name : ''; $('#bmSlug').value = b ? b.slug : ''; $('#bmWebsite').value = b ? b.website : ''; $('#bmCountry').value = b ? b.country : ''; $('#bmOrder').value = b ? (b.order || 0) : 0; $('#bmDesc').value = b ? b.desc : ''; $('#bmFeatured').checked = !!(b && b.featured); $('#bmActive').checked = !(b && b.active === false); $('#bmTop').checked = !!(b && b.top); $('#bmLogoPreview').src = b ? (b.logo || 'https://via.placeholder.com/64?text=LOGO') : 'https://via.placeholder.com/64?text=LOGO';
                    brandModal.show(); setTimeout(function () { $('#bmName').focus(); }, 100);
                }
                $('#btnAddBrand').onclick = function () { openBrandModal(null); };
                $('#bmLogo').onchange = function (e) { var f = e.target.files && e.target.files[0]; if (!f) return; var r = new FileReader(); r.onload = function (ev) { $('#bmLogoPreview').src = ev.target.result; }; r.readAsDataURL(f); };












                $('#bmName').oninput = function () { if (!$('#bmSlug').dataset.touched) $('#bmSlug').value = slugify($('#bmName').value); };
                $('#bmSlug').oninput = function () { $('#bmSlug').dataset.touched = true; };

                // ============== Brand create or update ===================== //
                $('#brandForm').onsubmit = function(e) {
                    e.preventDefault();

                    var formData = new FormData();
                    formData.append('id', $('#bmId').value);
                    formData.append('name', $('#bmName').value.trim());
                    formData.append('slug', $('#bmSlug').value.trim() || slugify($('#bmName').value));
                    formData.append('website', $('#bmWebsite').value.trim());
                    formData.append('country', $('#bmCountry').value);
                    formData.append('order', +($('#bmOrder').value || 0));
                    formData.append('description', $('#bmDesc').value);
                    formData.append('featured', $('#bmFeatured').checked ? 1 : 0);
                    formData.append('active', $('#bmActive').checked ? 1 : 0);
                    formData.append('top', $('#bmTop').checked ? 1 : 0);

                    var logoFile = $('#bmLogo').files[0];
                    if (logoFile) formData.append('logo', logoFile);

                    jQuery.ajax({
                        url: "{{ route('admin.brand.storeOrUpdate') }}",
                        type: "POST",
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                toast.fire({ icon: 'success', title: response.message });

                                brandModal.hide(); 
                                // Optionally, reload the table with the saved brand
                                if (response.brand) {
                                    var b = response.brand;
                                    var existingIndex = BRANDS.findIndex(x => x.id == b.id);
                                    if (existingIndex > -1) BRANDS[existingIndex] = b;
                                    else BRANDS.push(b);
                                    loadBrands();
                                }
                            } else {
                                toast.fire({ icon: 'error', title: 'Failed to save brand.' });
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseJSON);
                            Swal.fire({ icon: 'error', title: 'Error occurred!', text: JSON.stringify(xhr.responseJSON.errors) });
                        }
                    });
                };

    



                // $('#brandForm').onsubmit = function (e) {
                //     e.preventDefault();
                //     var obj = { name: $('#bmName').value.trim(), slug: ($('#bmSlug').value.trim() || slugify($('#bmName').value)), website: $('#bmWebsite').value.trim(), country: $('#bmCountry').value, order: +($('#bmOrder').value || 0), desc: $('#bmDesc').value, featured: $('#bmFeatured').checked, active: $('#bmActive').checked, top: $('#bmTop').checked, logo: $('#bmLogoPreview').src.indexOf('placeholder.com') > -1 ? '' : $('#bmLogoPreview').src };
                //     var id = $('#bmId').value;
                //     if (id) {
                //         for (var i = 0; i < BRANDS.length; i++) { if (BRANDS[i].id === id) { for (var k in obj) { BRANDS[i][k] = obj[k]; } break; } }
                //         toast.fire({ icon: 'success', title: 'Brand updated' });
                //     } else {
                //         for (var j = 0; j < BRANDS.length; j++) { if (BRANDS[j].slug === obj.slug) { Swal.fire({ icon: 'error', title: 'Duplicate slug' }); return; } }
                //         obj.id = rid(); BRANDS.push(obj); toast.fire({ icon: 'success', title: 'Brand added' });
                //     }
                //     brandModal.hide(); renderTable();
                // };

                // init table
                renderTable();
                
            });






            // ============== Load all Brand in the Table ===================== //
            function loadBrands() {
                $.ajax({
                    url: '/admin/brand/list',
                    type: 'GET',
                    success: function(response) {
                        if(response.success) {
                            let tbody = $('#brandTable tbody');
                            tbody.empty();

                            response.brands.forEach(function(brand) {
                                tbody.append(`
                                    <tr data-id="${brand.id}">
                                        <td><img class="brand-logo" src="${brand.logo_url ?? '/default-logo.png'}" width="50"></td>
                                        <td>${brand.name}</td>
                                        <td class="kbd">${brand.slug}</td>
                                        <td>${brand.country ?? ''}</td>
                                        <td>${brand.website ?? ''}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input featureToggle" type="checkbox" ${brand.featured ? 'checked' : ''}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input activeToggle" type="checkbox" ${brand.active ? 'checked' : ''}>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <button onclick="viewBrand(${brand.id})" class="action-btn-info" data-preview title="Preview"><i class="bx bx-show"></i></button>
                                            <button onclick="editBrand(${brand.id})" data-id="${brand.id}" data-edit title="Edit" class="action-btn-success"><i class="bx bx-edit-alt"></i></button>
                                            <button onclick="deleteBrand(${brand.id})" data-id="${brand.id}" data-del title="Delete" class="action-btn-danger"><i class="bx bx-trash"></i></button>
                                        </td>
                                    </tr>
                                    `);
                               
                            });
                        }
                    }
                });
            }

            // ============== Delete Brand from the Table ===================== //
            function deleteBrand(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/brand/delete/' + id,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if(response.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    loadBrands();
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            }


            // ============= Edit Brand ===================== //
            function editBrand(id) {
                $.ajax({
                    url: '/admin/brand/list',
                    type: 'GET',
                    success: function(response) {
                        if(response.success) {
                            let brand = response.brands.find(b => b.id === id);
                            if(brand) {
                                $('#bmId').val(brand.id);
                                $('#bmName').val(brand.name);
                                $('#bmSlug').val(brand.slug);
                                $('#bmWebsite').val(brand.website);
                                $('#bmCountry').val(brand.country);
                                $('#bmOrder').val(brand.order);
                                $('#bmDesc').val(brand.description);
                                $('#bmFeatured').prop('checked', brand.featured);
                                $('#bmActive').prop('checked', brand.active);
                                $('#bmTop').prop('checked', brand.top);
                                // Set logo preview
                                $('#bmLogoPreview').attr('src', brand.logo_url ? brand.logo_url : 'https://via.placeholder.com/64?text=LOGO');

                                $('#brandModal').modal('show');
                            }
                        }
                    }
                });
            }


            // ============= preview Brand ===================== //
            function viewBrand(id) { 
                $.ajax({
                    url: '/admin/brand/list',
                    type: 'GET',
                    success: function(response) {
                        if(response.success) {
                            let brand = response.brands.find(b => b.id === id);
                            console.log(brand);
                            if(brand) {
                                 $('#bpBody').html(`
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <img class="brand-logo" src="${brand.logo_url || '/default-logo.png'}" width="64" alt="">
                                        <div>
                                            <div class="fw-semibold">${brand.name}</div>
                                            <div class="small-muted">${brand.slug} • ${brand.country || ''}</div>
                                        </div>
                                    </div>
                                    <div class="mb-1"><strong>Website:</strong> ${brand.website ? `<a href="${brand.website}" target="_blank">${brand.website}</a>` : '—'}</div>
                                    <div class="mb-1"><strong>Featured:</strong> ${brand.featured ? 'Yes' : 'No'}</div>
                                    <div class="mb-1"><strong>Status:</strong> ${brand.active ? 'Active' : 'Inactive'}</div>
                                    <div class="mb-1"><strong>Order:</strong> ${brand.order || 0}</div>
                                    <div class="mb-1"><strong>Description:</strong><br>${brand.description || '—'}</div>
                                `);

                                $('#brandPreviewModal').modal('show');
                            }
                        }
                    }
                });
            }

            // // ============= Feature Toggle ===================== //
            $(document).on('change', '.featureToggle', function() {
                let checkbox = $(this);
                let row = checkbox.closest('tr');
                let brandId = row.data('id');
                let featured = checkbox.is(':checked') ? 1 : 0;

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${featured ? 'feature' : 'unfeature'} this brand?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/brand/toggle-feature',
                            type: 'POST',
                            data: {
                                id: brandId,
                                featured: featured,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                if(res.success) {
                                    Swal.fire({
                                        title: 'Updated!',
                                        text: res.message,
                                        icon: 'success',
                                        timer: 2000,       
                                        showConfirmButton: false
                                    });

                                } else {
                                    Swal.fire('Error!', res.message, 'error');
                                    checkbox.prop('checked', !featured); // revert change on error
                                }
                            }
                        });
                    } else {
                        checkbox.prop('checked', !featured); // revert change if canceled
                    }
                });
            });

            // ============= Active Toggle ===================== // 
            $(document).on('change', '.activeToggle', function() {
                let checkbox = $(this);
                let row = checkbox.closest('tr');
                let brandId = row.data('id');
                let active = checkbox.is(':checked') ? 1 : 0;

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${active ? 'activate' : 'deactivate'} this brand?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/brand/toggle-active',
                            type: 'POST',
                            data: {
                                id: brandId,
                                active: active,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                if(res.success) {
                                    Swal.fire({
                                        title: 'Updated!',
                                        text: res.message,
                                        icon: 'success',
                                        timer: 2000,       
                                        showConfirmButton: false
                                    });

                                } else {
                                    Swal.fire('Error!', res.message, 'error');
                                    checkbox.prop('checked', !active); // revert change on error
                                }
                            }
                        });
                    } else {
                        checkbox.prop('checked', !active); // revert change if canceled
                    }
                });
            });

            loadBrands()
        </script>

    @endpush

@endsection

@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <!-- Select2 Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap-5-theme@1.6.2/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />


    @include('admin.product_category.partials.css.product-category-css')

    <div class="card card-round">
        <div class="card-header">
            <div class="toolbar">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0"><i class="bx bx-sitemap me-2"></i>Category Structure</h4>
                    <span class="chip" id="chipCats"><i class='bx bx-folder-open'></i> Categories: 0</span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <select id="sortSelect" class="form-select form-select-sm" style="width:190px">
                        <option value="order">Sort: Display Order</option>
                        <option value="az">Sort: Name A–Z</option>
                        <option value="za">Sort: Name Z–A</option>
                    </select>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleRollup" checked>
                        <label class="form-check-label small" for="toggleRollup"
                            title="Count includes descendants">Roll-up</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleMenuOnly">
                        <label class="form-check-label small" for="toggleMenuOnly">Menu only</label>
                    </div>
                    <button class="select-btn-white" id="btnExpandAll"><i
                            class="bx bx-chevrons-down me-1"></i>Expand</button>
                    <button class="select-btn-white" id="btnCollapseAll"><i
                            class="bx bx-chevrons-up me-1"></i>Collapse</button>
                    <button class="create-btn-base" id="btnOpenAdd"><i class="bx bx-folder-plus me-1"></i>Add
                        Category</button>
                </div>
            </div>
            <div class="sticky-tools">
                <div class="input-group mt-3">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input id="searchBox" type="text" class="form-control" placeholder="Search categories...">
                </div>
            </div>
        </div>


        <div class="card-body category-list">
            <ul class="tree" id="treeRoot"><!-- JS renders --></ul>
            <div class="search-empty d-none" id="searchEmpty"><i class="bx bx-search"></i> No categories match your search.
            </div>
        </div>
    </div>




    <!-- Add/Edit Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-folder-plus me-2"></i><span id="modalTitle">Add Category</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="categoryForm1">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Name</label>
                                <input id="catName" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Parent</label>
                                <select id="parentSelect" class="form-select">
                                    <option value="">None (top)</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Order</label>
                                <input id="catOrder" type="number" class="form-control" value="0">
                            </div>
                            <div class="col-3 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input id="catMenu" class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label" for="catMenu">Show on Menu</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Icon (Boxicons)</label>
                                <input id="catIcon" class="form-control" placeholder="e.g., bx-mobile-alt">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Thumb URL (optional)</label>
                                <input id="catThumb" class="form-control" placeholder="https://…/thumb.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="create-btn-white" type="button" id="btnSaveNew"><i
                                class="bx bx-plus me-1"></i>Save & New</button>
                        <button class="create-btn-base" type="submit"><i class="bx bx-save me-1"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inventory Modal -->
    <div class="modal fade" id="invModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-package me-2"></i>Products — <span id="imCat"></span></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input id="imSearch" class="form-control form-control-sm" placeholder="Search SKU/Name/Variant">
                        <button class="create-btn-info-alt" id="imExport"><i
                                class="bx bx-download me-1"></i>Export CSV</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm" id="imTable">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Variant</th>
                                    <th>Category</th>
                                    <th class="text-end">Stock</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer"><button class="create-btn-white" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

    <!-- Orders Modal -->
    <div class="modal fade" id="ordersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-receipt me-2"></i>Orders — <span id="omCat"></span></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input id="omSearch" class="form-control form-control-sm"
                            placeholder="Search orders (no/customer/status)">
                        <button class="create-btn-info-alt" id="omExport"><i
                                class="bx bx-download me-1"></i>Export CSV</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm" id="omTable">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer"><button class="create-btn-white" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

    <!-- Assigned Variants Modal -->
    <div class="modal fade" id="variantsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-category-alt me-2"></i>Variants — <span id="vmCat"></span></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input id="vmSearch" class="form-control form-control-sm" placeholder="Search variant name/SKU">
                        <button class="create-btn-primary" id="btnOpenAssign"><i
                                class="bx bx-link-alt me-1"></i>Assign Variants</button>
                    </div>
                    <ul class="list-group" id="vmList"><!-- JS --></ul>
                    <div class="small text-muted mt-2">Click on a variant name to see preview.</div>
                </div>
                <div class="modal-footer"><button class="create-btn-white" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

    <!-- Variant Preview Modal -->
    <div class="modal fade" id="variantPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-show me-2"></i><span id="vpName"></span></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="vpBody"><!-- JS --></div>
            </div>
        </div>
    </div>

    <!-- Variant Assign Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="bx bx-link-alt me-2"></i>Assign Variants — <span id="amCat"></span>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input id="amSearch" class="form-control form-control-sm" placeholder="Search variants">
                        <div class="d-flex gap-2">
                            <button class="select-btn-info" id="amSelAll">Select all</button>
                            <button class="select-btn-white" id="amClear">Clear</button>
                        </div>
                    </div>
                    <div id="amList" class="row g-2"><!-- JS --></div>
                </div>
                <div class="modal-footer">
                    <button class="create-btn-base" id="amSave"><i class="bx bx-save me-1"></i>Save</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                // Initialize Select2 dropdowns
                $('#parentSelect').select2({
                    theme: "bootstrap-5",
                    width: '100%',
                    dropdownParent: $('#categoryModal')
                });
            });
        </script>


        <script>
            // CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            // Load parent categories into dropdown
            function loadParentCategories(selectedId = null) {
                $.ajax({
                    url: "/admin/product/categories/parents",
                    type: "GET",
                    success: function (res) {
                        let parentSelect = $("#parentSelect");
                        parentSelect.empty();
                        parentSelect.append('<option value="">None (top)</option>');

                        res.categories.forEach(function (cat) {
                            let selected = selectedId == cat.id ? 'selected' : '';
                            parentSelect.append('<option value="' + cat.id + '" ' + selected + '>' + cat.name + '</option>');
                        });
                    }
                });
            }

            // Open modal on button click
            $("#btnOpenAdd").on("click", function () {
                // Reset form and data-id
                $("#categoryForm1").trigger("reset").data("id", "");
                $("#modalTitle").text("Add Category");

                // Load parent categories into dropdown
                loadParentCategories();

                // Show modal
                $("#categoryModal").modal("show");
            });



            // Save category via AJAX
            $("#categoryForm1").on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "/admin/product/categories/store",
                    type: "POST",
                    data: {
                        id: $("#categoryForm1").data("id"),
                        name: $("#catName").val(),
                        parent_id: $("#parentSelect").val(),
                        order: $("#catOrder").val(),
                        show_on_menu: $("#catMenu").is(":checked") ? 1 : 0,
                        icon: $("#catIcon").val(),
                        thumb_url: $("#catThumb").val()
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Category saved successfully!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $("#categoryModal").modal("hide");
                            loadParentCategories(); // refresh parent dropdown
                            // load updated tree
                            updateTreeOnSave(res.data);
                        } else {
                            alert(res.message || "Failed to save category");
                        }
                    }
                });
            });

            // Save & New
            $("#btnSaveNew").on("click", function (e) {
                e.preventDefault(); // prevent default form submit

                $.ajax({
                    url: "/admin/product/categories/store",
                    type: "POST",
                    data: {
                        id: $("#categoryForm1").data("id"),
                        name: $("#catName").val(),
                        parent_id: $("#parentSelect").val(),
                        order: $("#catOrder").val(),
                        show_on_menu: $("#catMenu").is(":checked") ? 1 : 0,
                        icon: $("#catIcon").val(),
                        thumb_url: $("#catThumb").val()
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Category saved successfully!',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            // Reset form for next entry
                            $("#categoryForm1").trigger("reset").data("id", "");
                            loadParentCategories(); // refresh parent dropdown
                            // load updated tree
                            updateTreeOnSave(res.data);
                        } else {
                            alert(res.message || "Failed to save category");
                        }
                    }
                });
            });


        </script>


<script>
    $(document).ready(function () {

        // Expand All
        $('#btnExpandAll').on('click', function () {
            $('#treeRoot li').each(function () {
                if ($(this).find('ul').length) {
                    $(this).removeClass('collapsed');
                    // update toggle icon
                    $(this).find('> .category-item .node-toggle i').removeClass('bx-chevron-right').addClass('bx-chevron-down');
                }
            });
        });

        // Collapse All
        $('#btnCollapseAll').on('click', function () {
            $('#treeRoot li').each(function () {
                if ($(this).find('ul').length) {
                    $(this).addClass('collapsed');
                    // update toggle icon
                    $(this).find('> .category-item .node-toggle i').removeClass('bx-chevron-down').addClass('bx-chevron-right');
                }
            });
        });

    });

</script>



        <script>
            // ================= CREATE LI =================
            function createLi(category) {
                const li = document.createElement('li');
                li.dataset.id = category.id;

                if (category.children_recursive?.length) li.classList.add('collapsed');

                li.innerHTML = `
                        <div class="category-item">
                            <div class="cat-left">
                                ${category.children_recursive?.length
                        ? `<button class="node-toggle" title="Toggle"><i class="bx bx-chevron-right"></i></button>`
                        : `<span class="node-toggle" style="visibility:hidden"><i class="bx bx-chevron-right"></i></span>`}
                                <img class="thumb" src="${category.thumb_url || 'https://via.placeholder.com/28x28?text=%20'}" alt="">
                                <i class="bx ${category.icon || 'bx-folder'} text-secondary"></i>
                                <div class="cat-title">${category.name}</div>
                                <div class="cat-meta">
                                    ${category.show_on_menu ? `<span class="badge-soft rounded-pill px-2">Menu</span>` : ''}
                                    <span class="badge badge-products rounded-pill px-2 badge-pill-click" title="View products">0</span>
                                    <span class="badge badge-orders rounded-pill px-2 badge-pill-click" title="View orders">0</span>
                                    <span class="badge badge-variants rounded-pill px-2 badge-pill-click" title="View variants">0</span>
                                    <span class="badge badge-order rounded-pill px-2">order: ${category.order || 0}</span>
                                </div>
                            </div>
                            <div class="cat-actions">
                                <button class="action-btn-primary" data-assign title="Assign Variants"><i class="bx bx-link-alt"></i></button>
                                <button class="action-btn-success" data-edit title="Edit"><i class="bx bx-edit"></i></button>
                                <button class="action-btn-danger" data-del title="Delete"><i class="bx bx-trash"></i></button>
                            </div>
                        </div>
                    `;

                // collapse / expand toggle
                li.querySelector('.node-toggle')?.addEventListener('click', () => {
                    const ul = li.querySelector('ul');
                    if (!ul) return;
                    li.classList.toggle('collapsed');
                    const icon = li.querySelector('.node-toggle i');
                    if (icon) icon.className = li.classList.contains('collapsed')
                        ? 'bx bx-chevron-right'
                        : 'bx bx-chevron-down';
                });

                // edit button
                li.querySelector('[data-edit]')?.addEventListener('click', () => {
                    $.get('/admin/product/categories/' + category.id + '/edit', function (res) {
                        $('#modalTitle').text('Edit Category');
                        $('#categoryForm1').data('id', res.id);
                        $('#catName').val(res.name);
                        $('#catOrder').val(res.order);
                        $('#catMenu').prop('checked', res.show_on_menu == 1);
                        $('#catIcon').val(res.icon);
                        $('#catThumb').val(res.thumb_url);
                        loadParentCategories(res.parent_id);
                        $('#categoryModal').modal('show');
                    });
                });

                // delete button
                li.querySelector('[data-del]')?.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will delete the category and all its children!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/product/categories/' + category.id,
                                type: 'DELETE',
                                data: { _token: '{{ csrf_token() }}' },
                                success: function (res) {
                                    if (res.success) {
                                        li.remove();
                                        document.getElementById('chipCats').textContent =
                                            ' Categories: ' + document.querySelectorAll('#treeRoot li').length;
                                        Swal.fire('Deleted!', res.message, 'success');
                                    } else {
                                        Swal.fire('Failed!', 'Could not delete category', 'error');
                                    }
                                },
                                error: function (xhr) {
                                    console.error(xhr.responseText);
                                    Swal.fire('Error!', 'Error occurred while deleting category', 'error');
                                }
                            });
                        }
                    });
                });

                // children
                if (category.children_recursive?.length) {
                    const ul = document.createElement('ul');
                    category.children_recursive.forEach(c => ul.appendChild(createLi(c)));
                    li.appendChild(ul);
                }

                return li;
            }


            // ================= FIND PARENT =================
            function findParentLi(treeRoot, parentId) {
                if (!parentId) return treeRoot; // top-level
                return treeRoot.querySelector(`li[data-id='${parentId}']`);
            }

            // ================= UPDATE TREE ON SAVE =================
            function updateTreeOnSave(category) {
                const treeRoot = document.getElementById('treeRoot');
                let existingLi = treeRoot.querySelector(`li[data-id='${category.id}']`);

                // find parent
                const parentLi = findParentLi(treeRoot, category.parent_id);

                // ensure UL exists
                const parentUl = parentLi === treeRoot ? treeRoot : (parentLi.querySelector('ul') || (() => {
                    const ul = document.createElement('ul');
                    parentLi.appendChild(ul);
                    return ul;
                })());

                if (existingLi) {
                    const oldParentLi = existingLi.closest('ul')?.closest('li') || null;
                    const oldParentId = oldParentLi ? oldParentLi.dataset.id : null;

                    if ((category.parent_id || null) != oldParentId) {
                        existingLi.remove();
                        parentUl.appendChild(createLi(category));
                    } else {
                        existingLi.replaceWith(createLi(category));
                    }
                } else {
                    parentUl.appendChild(createLi(category));
                }

                //  parent toggle visible if it has children
                if (parentLi !== treeRoot) {
                    let toggleBtn = parentLi.querySelector('.node-toggle');
                    if (toggleBtn) {
                        toggleBtn.style.visibility = "visible";
                        const icon = toggleBtn.querySelector("i");
                        if (icon) icon.className = "bx bx-chevron-down";
                    }
                }

                // update count
                document.getElementById('chipCats').textContent =
                    ' Categories: ' + treeRoot.querySelectorAll('li').length;
            }

            // ================= RENDER FULL TREE =================
            function renderTree(TREE) {
                const root = document.getElementById('treeRoot');
                root.innerHTML = '';
                TREE.forEach(n => root.appendChild(createLi(n)));
                document.getElementById('chipCats').textContent = ' Categories: ' + root.querySelectorAll('li').length;
            }

            // ================= LOAD FROM SERVER =================
            function loadCategoryTree() {
                $.get("/admin/product/categories/tree", function (data) {
                    renderTree(data);
                });
            }

            $(document).ready(function () {
                loadCategoryTree();
            });
        </script>










                            <!--

                                <script>
                                    (function () {
                                        const $ = s => document.querySelector(s), $$ = s => Array.from(document.querySelectorAll(s));
                                        const modalAdd = new bootstrap.Modal('#categoryModal');
                                        const modalInv = new bootstrap.Modal('#invModal');
                                        const modalOrd = new bootstrap.Modal('#ordersModal');
                                        const modalVars = new bootstrap.Modal('#variantsModal');
                                        const modalPrev = new bootstrap.Modal('#variantPreviewModal');
                                        const modalAssign = new bootstrap.Modal('#assignModal');

                                        /* =========================
                                           3-লেয়ার ক্যাটাগরি ডাটা
                                        ========================= */
                                        const TREE = [
                                            {
                                                name: 'Clothing', order: 1, menu: 1, icon: 'bx-t-shirt', children: [
                                                    {
                                                        name: 'Men', order: 1, children: [
                                                            { name: 'T-Shirts', order: 1 }, { name: 'Shirts', order: 2 }, { name: 'Jeans', order: 3 }, { name: 'Jackets', order: 4 }
                                                        ]
                                                    },
                                                    {
                                                        name: 'Women', order: 2, children: [
                                                            { name: 'Tops', order: 1 }, { name: 'Dresses', order: 2 }, { name: 'Skirts', order: 3 }, { name: 'Ethnic Wear', order: 4 }
                                                        ]
                                                    },
                                                    { name: 'Kids', order: 3, children: [{ name: 'Boys', order: 1 }, { name: 'Girls', order: 2 }, { name: 'Baby', order: 3 }] },
                                                    { name: 'Accessories', order: 4, children: [{ name: 'Belts', order: 1 }, { name: 'Caps & Hats', order: 2 }, { name: 'Socks', order: 3 }] }
                                                ]
                                            },
                                            {
                                                name: 'Phone', order: 2, menu: 1, icon: 'bx-mobile-alt', children: [
                                                    { name: 'Android', order: 1, children: [{ name: 'Samsung', order: 1 }, { name: 'Xiaomi', order: 2 }, { name: 'OnePlus', order: 3 }] },
                                                    { name: 'iPhone', order: 2, children: [{ name: 'iPhone 12', order: 1 }, { name: 'iPhone 13', order: 2 }, { name: 'iPhone 14', order: 3 }] },
                                                    { name: 'Accessories', order: 3, children: [{ name: 'Chargers', order: 1 }, { name: 'Cables', order: 2 }, { name: 'Cases', order: 3 }] },
                                                    { name: 'Wearables', order: 4, children: [{ name: 'Smartwatches', order: 1 }, { name: 'Bands', order: 2 }] }
                                                ]
                                            },
                                            {
                                                name: 'Laptop', order: 3, menu: 1, icon: 'bx-laptop', children: [
                                                    { name: 'Windows', order: 1, children: [{ name: 'Ultrabook', order: 1 }, { name: 'Gaming', order: 2 }, { name: '2-in-1', order: 3 }] },
                                                    { name: 'Mac', order: 2, children: [{ name: 'MacBook Air', order: 1 }, { name: 'MacBook Pro', order: 2 }] },
                                                    { name: 'Accessories', order: 3, children: [{ name: 'Bags', order: 1 }, { name: 'Mice', order: 2 }, { name: 'Keyboards', order: 3 }] },
                                                    { name: 'Components', order: 4, children: [{ name: 'RAM', order: 1 }, { name: 'SSD', order: 2 }, { name: 'HDD', order: 3 }] }
                                                ]
                                            },
                                            {
                                                name: 'Electronic Item', order: 4, menu: 1, icon: 'bx-chip', children: [
                                                    { name: 'TV & Display', order: 1, children: [{ name: 'LED TV', order: 1 }, { name: 'Monitor', order: 2 }, { name: 'Projector', order: 3 }] },
                                                    { name: 'Audio', order: 2, children: [{ name: 'Headphones', order: 1 }, { name: 'Speakers', order: 2 }, { name: 'Soundbar', order: 3 }] },
                                                    { name: 'Camera', order: 3, children: [{ name: 'DSLR', order: 1 }, { name: 'Mirrorless', order: 2 }, { name: 'Action', order: 3 }] },
                                                    { name: 'Gaming', order: 4, children: [{ name: 'Consoles', order: 1 }, { name: 'Controllers', order: 2 }] }
                                                ]
                                            },
                                            {
                                                name: 'Organic Food', order: 5, menu: 1, icon: 'bx-leaf', children: [
                                                    { name: 'Staples', order: 1, children: [{ name: 'Rice', order: 1 }, { name: 'Lentils', order: 2 }, { name: 'Flour', order: 3 }] },
                                                    { name: 'Spices', order: 2, children: [{ name: 'Turmeric', order: 1 }, { name: 'Chili', order: 2 }, { name: 'Cumin', order: 3 }] },
                                                    { name: 'Beverages', order: 3, children: [{ name: 'Tea', order: 1 }, { name: 'Coffee', order: 2 }, { name: 'Juice', order: 3 }] },
                                                    { name: 'Snacks', order: 4, children: [{ name: 'Nuts', order: 1 }, { name: 'Dried Fruit', order: 2 }] }
                                                ]
                                            },
                                            {
                                                name: 'Eyewear', order: 6, menu: 1, icon: 'bx-glasses', children: [
                                                    { name: 'Men', order: 1, children: [{ name: 'Sunglasses', order: 1 }, { name: 'Frames', order: 2 }, { name: 'Blue Light', order: 3 }] },
                                                    { name: 'Women', order: 2, children: [{ name: 'Sunglasses', order: 1 }, { name: 'Frames', order: 2 }] },
                                                    { name: 'Kids', order: 3, children: [{ name: 'Eyeglasses', order: 1 }, { name: 'Sunglasses', order: 2 }] },
                                                    { name: 'Accessories', order: 4, children: [{ name: 'Cases', order: 1 }, { name: 'Cleaning Cloths', order: 2 }] }
                                                ]
                                            },
                                            {
                                                name: 'Cosmetic', order: 7, menu: 1, icon: 'bx-brush', children: [
                                                    { name: 'Face', order: 1, children: [{ name: 'Foundation', order: 1 }, { name: 'Concealer', order: 2 }, { name: 'Primer', order: 3 }] },
                                                    { name: 'Eyes', order: 2, children: [{ name: 'Mascara', order: 1 }, { name: 'Eyeliner', order: 2 }, { name: 'Shadow', order: 3 }] },
                                                    { name: 'Lips', order: 3, children: [{ name: 'Lipstick', order: 1 }, { name: 'Gloss', order: 2 }] },
                                                    { name: 'Skin Care', order: 4, children: [{ name: 'Cleanser', order: 1 }, { name: 'Moisturizer', order: 2 }, { name: 'Serum', order: 3 }] }
                                                ]
                                            },
                                            {
                                                name: 'Gadget', order: 8, menu: 1, icon: 'bx-joystick', children: [
                                                    { name: 'Smart Home', order: 1, children: [{ name: 'Smart Bulb', order: 1 }, { name: 'Smart Plug', order: 2 }] },
                                                    { name: 'Audio', order: 2, children: [{ name: 'Earbuds', order: 1 }, { name: 'Bluetooth Speaker', order: 2 }] },
                                                    { name: 'Wearables', order: 3, children: [{ name: 'Fitness Band', order: 1 }, { name: 'Smartwatch', order: 2 }] },
                                                    { name: 'Computer Peripherals', order: 4, children: [{ name: 'USB Hub', order: 1 }, { name: 'Webcam', order: 2 }] }
                                                ]
                                            },
                                            {
                                                name: 'Gift Item', order: 9, menu: 1, icon: 'bx-gift', children: [
                                                    { name: 'Occasions', order: 1, children: [{ name: 'Birthday', order: 1 }, { name: 'Anniversary', order: 2 }, { name: 'Corporate', order: 3 }] },
                                                    { name: 'Personalized', order: 2, children: [{ name: 'Mugs', order: 1 }, { name: 'T-Shirts', order: 2 }, { name: 'Photo Frames', order: 3 }] },
                                                    { name: 'Hampers', order: 3, children: [{ name: 'Snack Hamper', order: 1 }, { name: 'Beauty Hamper', order: 2 }] },
                                                    { name: 'Cards', order: 4, children: [{ name: 'Greeting Cards', order: 1 }, { name: 'Gift Cards', order: 2 }] }
                                                ]
                                            }
                                        ];

                                        /* =========================
                                           Demo PRODUCTS & ORDERS
                                        ========================= */
                                        const PRODINV = [
                                            { sku: 'TEE-CL-RED-S', name: 'Classic Tee', variant: 'Red / S', stock: 42, path: 'Clothing > Men > T-Shirts' },
                                            { sku: 'TEE-CL-BLK-M', name: 'Classic Tee', variant: 'Black / M', stock: 18, path: 'Clothing > Men > T-Shirts' },
                                            { sku: 'IPH-13-128', name: 'iPhone 13', variant: '128GB', stock: 9, path: 'Phone > iPhone > iPhone 13' },
                                            { sku: 'SAM-A54-8-128', name: 'Samsung A54', variant: '8/128', stock: 25, path: 'Phone > Android > Samsung' },
                                            { sku: 'WIN-UB-512', name: 'Ultrabook 14', variant: 'i5/8/512', stock: 7, path: 'Laptop > Windows > Ultrabook' },
                                            { sku: 'LED-50', name: 'LED TV 50"', variant: '4K', stock: 12, path: 'Electronic Item > TV & Display > LED TV' },
                                            { sku: 'RICE-5KG', name: 'Organic Rice', variant: '5kg', stock: 60, path: 'Organic Food > Staples > Rice' },
                                            { sku: 'SUN-MEN-AVI', name: 'Aviator Sunglass', variant: 'Men', stock: 30, path: 'Eyewear > Men > Sunglasses' },
                                            { sku: 'LIP-MAT-01', name: 'Matte Lipstick', variant: 'Ruby', stock: 45, path: 'Cosmetic > Lips > Lipstick' },
                                            { sku: 'SMART-BULB', name: 'Smart Bulb', variant: '9W', stock: 80, path: 'Gadget > Smart Home > Smart Bulb' },
                                            { sku: 'MUG-PERS', name: 'Personalized Mug', variant: '11oz', stock: 100, path: 'Gift Item > Personalized > Mugs' }
                                        ];

                                        const ORDERS = [
                                            { no: 'SO-1001', date: '2025-08-10', customer: 'Rakib Hasan', status: 'Shipped', total: 12500, path: 'Clothing > Men > T-Shirts' },
                                            { no: 'SO-1002', date: '2025-08-11', customer: 'Nusrat', status: 'Delivered', total: 9800, path: 'Clothing > Women > Dresses' },
                                            { no: 'SO-1003', date: '2025-08-11', customer: 'Imran', status: 'Paid', total: 69900, path: 'Phone > Android > Samsung' },
                                            { no: 'SO-1004', date: '2025-08-12', customer: 'Sadi', status: 'Picking', total: 125900, path: 'Laptop > Windows > Ultrabook' },
                                            { no: 'SO-1005', date: '2025-08-12', customer: 'Anika', status: 'Paid', total: 119000, path: 'Electronic Item > Camera > Mirrorless' },
                                            { no: 'SO-1006', date: '2025-08-13', customer: 'Jewel', status: 'Paid', total: 1890, path: 'Organic Food > Staples > Rice' },
                                            { no: 'SO-1007', date: '2025-08-14', customer: 'Sadia', status: 'Paid', total: 2990, path: 'Eyewear > Women > Sunglasses' },
                                            { no: 'SO-1008', date: '2025-08-15', customer: 'Rumi', status: 'Delivered', total: 1590, path: 'Gadget > Audio > Earbuds' },
                                            { no: 'SO-1009', date: '2025-08-16', customer: 'Parvez', status: 'Shipped', total: 5990, path: 'Gift Item > Occasions > Birthday' }
                                        ];

                                        /* =========================
                                           Variants (with preview)
                                        ========================= */
                                        const VARIANTS = [
                                            {
                                                id: 'V-TEE-CL', name: 'Classic Tee', skuPrefix: 'TEE-CL', price: 1290, cover: 'https://i.ibb.co/6r11wBw/img-prod-3.jpg',
                                                attrs: [{ name: 'Color', type: 'swatch', values: [{ name: 'Red', color: '#EF4444' }, { name: 'Black', color: '#111827' }, { name: 'Blue', color: '#3B82F6' }] },
                                                { name: 'Size', type: 'text', values: [{ name: 'S' }, { name: 'M' }, { name: 'L' }] }],
                                                gallery: ['https://i.ibb.co/6r11wBw/img-prod-3.jpg', 'https://i.ibb.co/LCwzQF6/men.jpg']
                                            },
                                            {
                                                id: 'V-IPH-13', name: 'iPhone 13', skuPrefix: 'IPH-13', price: 69900, cover: 'https://i.ibb.co/9w7p5rb/iphone.jpg',
                                                attrs: [{ name: 'Storage', type: 'text', values: [{ name: '128GB' }, { name: '256GB' }] },
                                                { name: 'Color', type: 'swatch', values: [{ name: 'Black', color: '#111827' }, { name: 'Blue', color: '#3B82F6' }] }],
                                                gallery: ['https://i.ibb.co/9w7p5rb/iphone.jpg']
                                            },
                                            {
                                                id: 'V-SAM-A54', name: 'Samsung A54', skuPrefix: 'SAM-A54', price: 45990, cover: 'https://i.ibb.co/4Nw8GkG/android.jpg',
                                                attrs: [{ name: 'RAM', type: 'text', values: [{ name: '6GB' }, { name: '8GB' }] },
                                                { name: 'Storage', type: 'text', values: [{ name: '128GB' }, { name: '256GB' }] }],
                                                gallery: ['https://i.ibb.co/4Nw8GkG/android.jpg']
                                            },
                                            {
                                                id: 'V-ULTRA14', name: 'Ultrabook 14', skuPrefix: 'ULTRA14', price: 95900, cover: 'https://i.ibb.co/0M1t7mL/windows-laptop.jpg',
                                                attrs: [{ name: 'RAM', type: 'text', values: [{ name: '8GB' }, { name: '16GB' }] },
                                                { name: 'Storage', type: 'text', values: [{ name: '512GB' }, { name: '1TB' }] }],
                                                gallery: ['https://i.ibb.co/0M1t7mL/windows-laptop.jpg']
                                            },
                                            {
                                                id: 'V-RICE', name: 'Organic Rice', skuPrefix: 'RICE', price: 1190, cover: 'https://i.ibb.co/5nKZb21/kitchen.jpg',
                                                attrs: [{ name: 'Weight', type: 'text', values: [{ name: '1kg' }, { name: '5kg' }] }],
                                                gallery: ['https://i.ibb.co/2Fkz7hL/home.jpg']
                                            },
                                            {
                                                id: 'V-AVIATOR', name: 'Aviator Sunglass', skuPrefix: 'SUN-AVI', price: 2990, cover: 'https://i.ibb.co/7X2BvHk/women.jpg',
                                                attrs: [{ name: 'Frame', type: 'text', values: [{ name: 'Gold' }, { name: 'Black' }] }],
                                                gallery: ['https://i.ibb.co/7X2BvHk/women.jpg']
                                            },
                                            {
                                                id: 'V-LIP-MAT', name: 'Matte Lipstick', skuPrefix: 'LIP-MAT', price: 1490, cover: 'https://i.ibb.co/VT9f7wK/beauty.jpg',
                                                attrs: [{ name: 'Shade', type: 'swatch', values: [{ name: 'Ruby', color: '#AA0033' }, { name: 'Nude', color: '#E3CBAF' }] }],
                                                gallery: ['https://i.ibb.co/VT9f7wK/beauty.jpg']
                                            },
                                            {
                                                id: 'V-BULB', name: 'Smart Bulb 9W', skuPrefix: 'SMARTB', price: 890, cover: 'https://i.ibb.co/7n4Z8nB/outdoor.jpg',
                                                attrs: [{ name: 'Pack', type: 'text', values: [{ name: 'Single' }, { name: '2 Pack' }] }],
                                                gallery: ['https://i.ibb.co/7n4Z8nB/outdoor.jpg']
                                            },
                                            {
                                                id: 'V-MUG', name: 'Personalized Mug', skuPrefix: 'MUG', price: 590, cover: 'https://i.ibb.co/rZr6Z5v/books.jpg',
                                                attrs: [{ name: 'Size', type: 'text', values: [{ name: '11oz' }, { name: '15oz' }] }],
                                                gallery: ['https://i.ibb.co/rZr6Z5v/books.jpg']
                                            }
                                        ];

                                        // category-path => [variant ids]
                                        const VAR_ASSIGN = {
                                            'Clothing > Men > T-Shirts': ['V-TEE-CL'],
                                            'Phone > iPhone > iPhone 13': ['V-IPH-13'],
                                            'Phone > Android > Samsung': ['V-SAM-A54'],
                                            'Laptop > Windows > Ultrabook': ['V-ULTRA14'],
                                            'Organic Food > Staples > Rice': ['V-RICE'],
                                            'Eyewear > Men > Sunglasses': ['V-AVIATOR'],
                                            'Cosmetic > Lips > Lipstick': ['V-LIP-MAT'],
                                            'Gadget > Smart Home > Smart Bulb': ['V-BULB'],
                                            'Gift Item > Personalized > Mugs': ['V-MUG']
                                        };

                                        /* =========================
                                           Helpers
                                        ========================= */
                                        function sortChildren(list, mode) {
                                            list.sort((a, b) => {
                                                if (mode === 'order') return (a.order || 0) - (b.order || 0);
                                                if (mode === 'az') return a.name.localeCompare(b.name);
                                                if (mode === 'za') return b.name.localeCompare(a.name);
                                                return 0;
                                            });
                                            list.forEach(n => n.children && sortChildren(n.children, mode));
                                        }
                                        function renderTree() {
                                            const root = $('#treeRoot'); root.innerHTML = '';
                                            const clone = structuredClone(TREE);
                                            sortChildren(clone, $('#sortSelect').value);

                                            function makeLi(n, depth, parentPath) {
                                                const path = parentPath ? parentPath + ' > ' + n.name : n.name;
                                                const li = document.createElement('li');
                                                if (n.children?.length) li.classList.add('collapsed');
                                                li.dataset.path = path;
                                                li.innerHTML = `
                                                        <div class="category-item">
                                                          <div class="cat-left">
                                                            ${n.children?.length ? `<button class="node-toggle" title="Toggle"><i class="bx bx-chevron-right"></i></button>` : `<span class="node-toggle" style="visibility:hidden"></span>`}
                                                            <img class="thumb" src="${n.thumb || 'https://via.placeholder.com/28x28?text=%20'}" alt="">
                                                            <i class="bx ${n.icon || 'bx-folder'} text-secondary"></i>
                                                            <div class="cat-title">${n.name}</div>
                                                            <div class="cat-meta">
                                                              ${n.menu ? `<span class="badge-soft rounded-pill px-2">Menu</span>` : ''}
                                                              <span class="badge badge-products rounded-pill px-2 badge-pill-click" title="View products">0</span>
                                                              <span class="badge badge-orders rounded-pill px-2 badge-pill-click" title="View orders">0</span>
                                                              <span class="badge badge-variants rounded-pill px-2 badge-pill-click" title="View variants">0</span>
                                                              <span class="badge badge-order rounded-pill px-2">order: ${n.order || 0}</span>
                                                            </div>
                                                          </div>
                                                          <div class="cat-actions">
                                                            <button class="btn btn-sm btn-outline-primary btn-xxs" data-assign title="Assign Variants"><i class="bx bx-link-alt"></i></button>
                                                            <button class="btn btn-sm btn-outline-secondary btn-xxs" data-edit title="Edit"><i class="bx bx-edit"></i></button>
                                                            <button class="btn btn-sm btn-outline-danger btn-xxs" data-del title="Delete"><i class="bx bx-trash"></i></button>
                                                          </div>
                                                        </div>`;
                                                if ($('#toggleMenuOnly').checked && !n.menu && depth === 0) li.classList.add('d-none');

                                                // children
                                                if (n.children?.length) {
                                                    const ul = document.createElement('ul');
                                                    n.children.forEach(c => ul.appendChild(makeLi(c, depth + 1, path)));
                                                    li.appendChild(ul);
                                                }

                                                // events
                                                li.querySelector('.node-toggle')?.addEventListener('click', () => {
                                                    if (!n.children?.length) return;
                                                    li.classList.toggle('collapsed');
                                                    li.querySelector('.node-toggle i').className = li.classList.contains('collapsed') ? 'bx bx-chevron-right' : 'bx bx-chevron-down';
                                                });
                                                li.querySelector('[data-edit]')?.addEventListener('click', () => openModal('edit', path, n.name));
                                                li.querySelector('[data-del]')?.addEventListener('click', () => {
                                                    if (!confirm('Delete this category?')) return;
                                                    removeByPath(path);
                                                    renderTree(); computeCounts();
                                                });
                                                li.querySelector('[data-assign]')?.addEventListener('click', () => openAssignModal(path));

                                                // badge clicks
                                                li.querySelector('.badge-products')?.addEventListener('click', () => openInventoryModal(path));
                                                li.querySelector('.badge-orders')?.addEventListener('click', () => openOrdersModal(path));
                                                li.querySelector('.badge-variants')?.addEventListener('click', () => openVariantsModal(path));

                                                return li;
                                            }

                                            clone.forEach(n => root.appendChild(makeLi(n, 0, '')));
                                            $('#chipCats').textContent = ' Categories: ' + $$('#treeRoot li').length;
                                            applySearchFilter();
                                            computeCounts();
                                        }

                                        function removeByPath(path) {
                                            function rec(list, parentPath) {
                                                for (let i = 0; i < list.length; i++) {
                                                    const p = parentPath ? parentPath + ' > ' + list[i].name : list[i].name;
                                                    if (p === path) { list.splice(i, 1); return true; }
                                                    if (list[i].children && rec(list[i].children, p)) return true;
                                                }
                                                return false;
                                            }
                                            rec(TREE, '');
                                        }

                                        function openModal(mode, path = '', name = '') {
                                            $('#modalTitle').textContent = mode === 'edit' ? 'Edit Category' : 'Add Category';
                                            refreshParentList();
                                            $('#categoryForm').dataset.mode = mode;
                                            if (mode === 'edit') {
                                                const info = findNodeByPath(path);
                                                $('#catName').value = info.node.name;
                                                $('#parentSelect').value = info.parentPath || '';
                                                $('#catOrder').value = info.node.order || 0;
                                                $('#catMenu').checked = !!info.node.menu;
                                                $('#catIcon').value = info.node.icon || '';
                                                $('#catThumb').value = info.node.thumb || '';
                                            } else {
                                                $('#categoryForm').reset();
                                                $('#parentSelect').value = path || '';
                                            }
                                            modalAdd.show();
                                            setTimeout(() => $('#catName').focus(), 100);
                                        }

                                        function findNodeByPath(path) {
                                            let res = null;
                                            function rec(list, parentPath) {
                                                for (const n of list) {
                                                    const p = parentPath ? parentPath + ' > ' + n.name : n.name;
                                                    if (p === path) { res = { node: n, parentList: list, parentPath }; return; }
                                                    if (n.children) rec(n.children, p);
                                                    if (res) return;
                                                }
                                            }
                                            rec(TREE, ''); return res;
                                        }

                                        function refreshParentList() {
                                            const sel = $('#parentSelect'); const all = [];
                                            (function walk(list, parentPath) {
                                                list.forEach(n => {
                                                    const p = parentPath ? parentPath + ' > ' + n.name : n.name;
                                                    all.push(p); n.children && walk(n.children, p);
                                                });
                                            })(TREE, '');
                                            sel.innerHTML = '<option value="">None (top)</option>' + all.map(p => `<option>${p}</option>`).join('');
                                        }

                                        function submitForm(saveAndNew = false) {
                                            const mode = $('#categoryForm').dataset.mode;
                                            const name = $('#catName').value.trim(); if (!name) return;
                                            const parent = $('#parentSelect').value.trim();
                                            const order = parseInt($('#catOrder').value || '0', 10);
                                            const menu = $('#catMenu').checked ? 1 : 0;
                                            const icon = $('#catIcon').value.trim();
                                            const thumb = $('#catThumb').value.trim();

                                            if (mode === 'edit') {
                                                // find by selected (we stored last opened path in parentSelect or name..)
                                                // easiest: look up by old name from modal title? We passed exact path in openModal, keep global:
                                                // Instead: find node by parent+name combo
                                                // For simplicity: try to find node with same name in tree (first match)
                                                const info = findNodeByPath($('#parentSelect').value ? $('#parentSelect').value + ' > ' + name : name) || null;
                                                // Safer: if not found, just update by searching old values from previously opened modal is heavy.
                                                // For demo: fall back to add new if edit mapping fails.
                                            }

                                            // In demo keep simple: always add new/update by removing old when edit called.
                                            if (mode === 'edit') {
                                                // we can't recover old path reliably, so take first selected node by current search context:
                                                // To be robust, store lastEditPath:
                                                if (window.__lastEditPath) {
                                                    const info = findNodeByPath(window.__lastEditPath);
                                                    if (info) {
                                                        info.node.name = name; info.node.order = order; info.node.menu = menu; info.node.icon = icon; info.node.thumb = thumb;
                                                        // move parent if changed
                                                        const newPath = parent ? parent + ' > ' + name : name;
                                                        if (info.parentPath !== parent) {
                                                            // remove from old list
                                                            const idx = info.parentList.indexOf(info.node);
                                                            if (idx > -1) info.parentList.splice(idx, 1);
                                                            // insert into new parent
                                                            if (!parent) {
                                                                TREE.push(info.node);
                                                            } else {
                                                                const dest = findNodeByPath(parent);
                                                                dest.node.children = dest.node.children || [];
                                                                dest.node.children.push(info.node);
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                const node = { name, order, menu, icon, thumb };
                                                if (!parent) { TREE.push(node); }
                                                else {
                                                    const dest = findNodeByPath(parent);
                                                    dest.node.children = dest.node.children || [];
                                                    dest.node.children.push(node);
                                                }
                                            }
                                            modalAdd.hide();
                                            renderTree();
                                        }

                                        // remember editing target path
                                        document.getElementById('categoryForm').addEventListener('submit', (e) => { e.preventDefault(); submitForm(false); });
                                        document.getElementById('btnSaveNew2').addEventListener('click', () => submitForm(true));

                                        /* =========================
                                           Counts + Badges actions
                                        ========================= */
                                        function belongsPath(itemPath, path, rollup) {
                                            return rollup ? itemPath.startsWith(path) : (itemPath === path);
                                        }
                                        function computeCounts() {
                                            const rollup = $('#toggleRollup').checked;
                                            $$('#treeRoot li').forEach(li => {
                                                const path = li.dataset.path;
                                                const prod = PRODINV.filter(r => belongsPath(r.path, path, rollup)).length;
                                                const ord = ORDERS.filter(r => belongsPath(r.path, path, rollup)).length;

                                                // variants (unique across subtree)
                                                const varIds = new Set();
                                                Object.keys(VAR_ASSIGN).forEach(k => {
                                                    if (belongsPath(k, path, rollup)) (VAR_ASSIGN[k] || []).forEach(id => varIds.add(id));
                                                });

                                                li.querySelector('.badge-products').textContent = prod;
                                                li.querySelector('.badge-orders').textContent = ord;
                                                li.querySelector('.badge-variants').textContent = varIds.size;
                                            });
                                        }

                                        function openInventoryModal(path) {
                                            $('#imCat').textContent = path;
                                            const rollup = $('#toggleRollup').checked;
                                            const rows = PRODINV.filter(p => belongsPath(p.path, path, rollup));
                                            const body = $('#imTable tbody'); body.innerHTML = '';
                                            rows.forEach(r => {
                                                const tr = document.createElement('tr');
                                                tr.innerHTML = `<td>${r.sku}</td><td>${r.name}</td><td>${r.variant}</td><td>${r.path}</td><td class="text-end">${r.stock}</td>`;
                                                body.appendChild(tr);
                                            });
                                            $('#imSearch').value = '';
                                            modalInv.show();
                                        }
                                        $('#imSearch').addEventListener('input', () => {
                                            const q = $('#imSearch').value.trim().toLowerCase();
                                            $$('#imTable tbody tr').forEach(tr => {
                                                tr.classList.toggle('d-none', q && !tr.innerText.toLowerCase().includes(q));
                                            });
                                        });
                                        $('#imExport').addEventListener('click', () => exportCSV('#imTable', 'products'));

                                        function openOrdersModal(path) {
                                            $('#omCat').textContent = path;
                                            const rollup = $('#toggleRollup').checked;
                                            const rows = ORDERS.filter(o => belongsPath(o.path, path, rollup));
                                            const body = $('#omTable tbody'); body.innerHTML = '';
                                            rows.forEach(r => {
                                                const tr = document.createElement('tr');
                                                tr.innerHTML = `<td>${r.no}</td><td>${r.date}</td><td>${r.customer}</td><td>${r.status}</td><td>${r.path}</td><td class="text-end">৳${r.total.toLocaleString()}</td>`;
                                                body.appendChild(tr);
                                            });
                                            $('#omSearch').value = '';
                                            modalOrd.show();
                                        }
                                        $('#omSearch').addEventListener('input', () => {
                                            const q = $('#omSearch').value.trim().toLowerCase();
                                            $$('#omTable tbody tr').forEach(tr => {
                                                tr.classList.toggle('d-none', q && !tr.innerText.toLowerCase().includes(q));
                                            });
                                        });
                                        $('#omExport').addEventListener('click', () => exportCSV('#omTable', 'orders'));

                                        /* =========================
                                           Variants: list, preview, assign
                                        ========================= */
                                        function variantById(id) { return VARIANTS.find(v => v.id === id); }

                                        function openVariantsModal(path) {
                                            $('#vmCat').textContent = path;
                                            const rollup = $('#toggleRollup').checked;
                                            // gather unique assigned ids in subtree
                                            const ids = new Set();
                                            Object.keys(VAR_ASSIGN).forEach(k => {
                                                if (belongsPath(k, path, rollup)) (VAR_ASSIGN[k] || []).forEach(id => ids.add(id));
                                            });
                                            const list = $('#vmList'); list.innerHTML = '';
                                            if (ids.size === 0) {
                                                list.innerHTML = `<li class="list-group-item text-muted">No variants assigned. Click "Assign Variants".</li>`;
                                            } else {
                                                [...ids].map(variantById).filter(Boolean).forEach(v => {
                                                    const li = document.createElement('li');
                                                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                                                    li.innerHTML = `
                                                          <div class="d-flex align-items-center gap-2">
                                                            <img src="${v.cover}" style="width:40px;height:40px;border-radius:8px;border:1px solid #e5e7eb;object-fit:cover">
                                                            <a href="#" class="link-primary" data-vprev="${v.id}">${v.name}</a>
                                                            <span class="v-pill"><span class="text-muted">SKU:</span> ${v.skuPrefix}</span>
                                                          </div>
                                                          <div class="text-muted small">৳${v.price.toLocaleString()}</div>`;
                                                    list.appendChild(li);
                                                });
                                            }
                                            list.querySelectorAll('[data-vprev]').forEach(a => a.addEventListener('click', (e) => { e.preventDefault(); openVariantPreview(a.dataset.vprev); }));
                                            $('#vmSearch').value = '';
                                            modalVars.show();
                                        }
                                        $('#vmSearch').addEventListener('input', () => {
                                            const q = $('#vmSearch').value.trim().toLowerCase();
                                            $$('#vmList .list-group-item').forEach(li => {
                                                li.classList.toggle('d-none', q && !li.innerText.toLowerCase().includes(q));
                                            });
                                        });
                                        $('#btnOpenAssign').addEventListener('click', () => {
                                            const cat = $('#vmCat').textContent;
                                            modalVars.hide(); openAssignModal(cat);
                                        });

                                        function pillsForAttrs(v) {
                                            return (v.attrs || []).map(g => {
                                                const values = g.values.map(x => x.name).join(', ');
                                                return `<li class="v-pill"><strong>${g.name}:</strong> ${values}</li>`;
                                            }).join('');
                                        }
                                        function openVariantPreview(vid) {
                                            const v = variantById(vid); if (!v) return;
                                            $('#vpName').textContent = v.name;
                                            $('#vpBody').innerHTML = `
                                                      <div class="d-flex gap-3 align-items-start">
                                                        <img src="${v.cover}" style="width:96px;height:96px;border-radius:12px;border:1px solid #e5e7eb;object-fit:cover">
                                                        <div>
                                                          <div class="mb-1"><span class="v-pill"><span class="text-muted">SKU Prefix:</span> ${v.skuPrefix}</span> <span class="v-pill"><span class="text-muted">Price:</span> ৳${v.price.toLocaleString()}</span></div>
                                                          <ul class="list-unstyled d-flex flex-wrap">${pillsForAttrs(v)}</ul>
                                                          <div class="small text-muted">Gallery:</div>
                                                          <div class="d-flex flex-wrap gap-2 mt-1">${(v.gallery || []).map(src => `<img src="${src}" style="width:64px;height:64px;border:1px solid #e5e7eb;border-radius:8px;object-fit:cover">`).join('')}</div>
                                                        </div>
                                                      </div>`;
                                            modalPrev.show();
                                        }

                                        let assignState = { path: '', selected: new Set() };
                                        function openAssignModal(path) {
                                            assignState.path = path;
                                            $('#amCat').textContent = path;
                                            const current = new Set(VAR_ASSIGN[path] || []);
                                            assignState.selected = current;

                                            const wrap = $('#amList'); wrap.innerHTML = '';
                                            VARIANTS.forEach(v => {
                                                const col = document.createElement('div'); col.className = 'col-md-6';
                                                col.innerHTML = `
                                                        <label class="border rounded p-2 d-flex align-items-center gap-2 w-100">
                                                          <input type="checkbox" class="form-check-input me-1" value="${v.id}" ${current.has(v.id) ? 'checked' : ''}>
                                                          <img src="${v.cover}" style="width:40px;height:40px;border-radius:8px;border:1px solid #e5e7eb;object-fit:cover">
                                                          <div>
                                                            <div class="fw-semibold">${v.name}</div>
                                                            <div class="text-muted small">${v.skuPrefix} • ৳${v.price.toLocaleString()}</div>
                                                          </div>
                                                        </label>`;
                                                wrap.appendChild(col);
                                            });
                                            $('#amSearch').value = '';
                                            modalAssign.show();
                                        }
                                        $('#amSearch').addEventListener('input', () => {
                                            const q = $('#amSearch').value.trim().toLowerCase();
                                            $$('#amList .col-md-6').forEach(col => {
                                                col.classList.toggle('d-none', q && !col.innerText.toLowerCase().includes(q));
                                            });
                                        });
                                        $('#amSelAll').addEventListener('click', () => {
                                            $$('#amList input[type=checkbox]').forEach(c => c.checked = true);
                                        });
                                        $('#amClear').addEventListener('click', () => {
                                            $$('#amList input[type=checkbox]').forEach(c => c.checked = false);
                                        });
                                        $('#amSave').addEventListener('click', () => {
                                            const ids = $$('#amList input[type=checkbox]:checked').map(c => c.value);
                                            VAR_ASSIGN[assignState.path] = ids;
                                            modalAssign.hide();
                                            computeCounts();
                                            // quick toast
                                            alert('Variants assigned (demo).');
                                        });

                                        /* =========================
                                           Search, Export, Misc
                                        ========================= */
                                        function applySearchFilter() {
                                            const q = $('#searchBox').value.trim().toLowerCase();
                                            const lis = $$('#treeRoot li');
                                            let visible = 0;
                                            lis.forEach(li => {
                                                const title = li.querySelector('.cat-title')?.textContent.trim().toLowerCase() || '';
                                                const match = !q || title.includes(q);
                                                li.classList.toggle('d-none', !match);
                                                if (match) {
                                                    visible++;
                                                    // expand parents
                                                    let p = li.parentElement;
                                                    while (p && p.id !== 'treeRoot') {
                                                        if (p.tagName === 'UL') p = p.parentElement;
                                                        if (p && p.tagName === 'LI') {
                                                            p.classList.remove('collapsed');
                                                            const i = p.querySelector('.node-toggle i'); if (i) i.className = 'bx bx-chevron-down';
                                                            p = p.parentElement;
                                                        }
                                                    }
                                                }
                                            });
                                            $('#searchEmpty').classList.toggle('d-none', visible > 0 || !q);
                                        }
                                        $('#searchBox').addEventListener('input', applySearchFilter);

                                        function exportCSV(sel, name) {
                                            const rows = [...document.querySelectorAll(sel + ' tbody tr')].map(tr => [...tr.children].map(td => `"${td.innerText.replace(/"/g, '""')}"`).join(','));
                                            const blob = new Blob([rows.join('\n')], { type: 'text/csv' }), url = URL.createObjectURL(blob);
                                            const a = document.createElement('a'); a.href = url; a.download = name + '.csv'; a.click(); URL.revokeObjectURL(url);
                                        }

                                        // Expand / Collapse buttons
                                        $('#btnExpandAll').addEventListener('click', () => {
                                            $$('#treeRoot li').forEach(li => {
                                                if (li.querySelector(':scope > ul')) { li.classList.remove('collapsed'); const i = li.querySelector('.node-toggle i'); if (i) i.className = 'bx bx-chevron-down'; }
                                            });
                                        });
                                        $('#btnCollapseAll').addEventListener('click', () => {
                                            $$('#treeRoot li').forEach(li => {
                                                if (li.querySelector(':scope > ul')) { li.classList.add('collapsed'); const i = li.querySelector('.node-toggle i'); if (i) i.className = 'bx bx-chevron-right'; }
                                            });
                                        });

                                        // Add new
                                        $('#btnOpenAdd2').addEventListener('click', () => openModal('add'));

                                        // Re-render on controls
                                        $('#sortSelect').addEventListener('change', () => { renderTree(); });
                                        $('#toggleMenuOnly').addEventListener('change', () => { renderTree(); });
                                        $('#toggleRollup').addEventListener('change', () => { computeCounts(); });

                                        // track last edited path for edit modal
                                        window.__lastEditPath = null;
                                        document.addEventListener('click', (e) => {
                                            const btn = e.target.closest('[data-edit]');
                                            if (btn) {
                                                const li = btn.closest('li');
                                                window.__lastEditPath = li?.dataset.path || null;
                                            }
                                        });

                                        // Init
                                        renderTree();

                                    })();
                                </script> 
                             -->

    @endpush

@endsection



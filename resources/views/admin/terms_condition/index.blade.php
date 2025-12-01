<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Terms & Conditions Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .badge { padding: 0.5em 0.8em; }
        .status-active { background-color: #28a745; }
        .status-inactive { background-color: #dc3545; }
        .action-btn { margin: 0 2px; }
        #termsModal .modal-dialog { max-width: 900px; }
        .tox-tinymce { border-radius: 0.25rem; }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-file-contract me-2"></i>Terms & Conditions Management</h4>
                        <button class="btn btn-light" onclick="openModal()">
                            <i class="fas fa-plus me-1"></i>Add New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="termsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="25%">Title</th>
                                        <th width="35%">Content</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Created At</th>
                                        <th width="10%">Updated At</th>
                                        <th width="5%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="termsTableBody">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Terms & Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="termsForm">
                    <div class="modal-body">
                        <input type="hidden" id="termId">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" required>
                            <div class="invalid-feedback" id="titleError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea id="content" class="form-control"></textarea>
                            <div class="invalid-feedback" id="contentError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback" id="statusError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/r2met6mrh50htc9yymzlqn3o0rbrfr511tjh46e0ucvylnq5/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: '#content',
    api_key: 'http://127.0.0.1:8000', // works for local/dev
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Oct 30, 2025:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    uploadcare_public_key: '80d4ccfdac22fe8bfc93',
  });
</script>

    
    <script>
        let modal;
        let editor;

        // Initialize TinyMCE
        // tinymce.init({
        //     selector: '#content',
        //     height: 400,
        //     menubar: true,
        //     plugins: [
        //         'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        //         'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        //         'insertdatetime', 'media', 'table', 'help', 'wordcount'
        //     ],
        //     toolbar: 'undo redo | blocks | bold italic backcolor | ' +
        //         'alignleft aligncenter alignright alignjustify | ' +
        //         'bullist numlist outdent indent | removeformat | help',
        //     content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        //     setup: function(ed) {
        //         editor = ed;
        //     }
        // });

        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize Modal
        $(document).ready(function() {
            modal = new bootstrap.Modal(document.getElementById('termsModal'));
            loadTerms();
        });

        // Load all terms
        function loadTerms() {
            $.ajax({
                url: '{{ route("terms.data") }}',
                method: 'GET',
                success: function(data) {
                    renderTable(data);
                },
                error: function(xhr) {
                    showAlert('Error loading data', 'danger');
                }
            });
        }

        // Render table
        function renderTable(data) {
            let html = '';
            
            if (data.length === 0) {
                html = '<tr><td colspan="7" class="text-center">No records found</td></tr>';
            } else {
                data.forEach(function(item) {
                    const statusClass = item.status === 'active' ? 'status-active' : 'status-inactive';
                    const contentPreview = (item.content);
                    const createdAt = new Date(item.created_at).toLocaleString();
                    const updatedAt = new Date(item.updated_at).toLocaleString();
                    
                    html += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.title}</td>
                            <td><div style="max-height:150px; overflow:auto;">${contentPreview}</div></td>
                            <td><span class="badge ${statusClass}">${item.status}</span></td>
                            <td><small>${createdAt}</small></td>
                            <td><small>${updatedAt}</small></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info action-btn" onclick="viewTerm(${item.id})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning action-btn" onclick="editTerm(${item.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger action-btn" onclick="deleteTerm(${item.id})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
            
            $('#termsTableBody').html(html);
        }

        // Open modal for new entry
        function openModal() {
            $('#modalTitle').text('Add Terms & Conditions');
            $('#termsForm')[0].reset();
            $('#termId').val('');
            tinymce.get('content').setContent('');
            clearErrors();
            modal.show();
        }

        // View term
        function viewTerm(id) {
            $.ajax({
                url: `/terms-conditions/${id}`,
                method: 'GET',
                success: function(data) {
                    alert('Title: ' + data.title + '\n\nContent:\n' + stripHtml(data.content));
                }
            });
        }

        // Edit term
        function editTerm(id) {
            $.ajax({
                url: `/terms-conditions/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#modalTitle').text('Edit Terms & Conditions');
                    $('#termId').val(data.id);
                    $('#title').val(data.title);
                    tinymce.get('content').setContent(data.content);
                    $('#status').val(data.status);
                    clearErrors();
                    modal.show();
                }
            });
        }

        // Delete term
        function deleteTerm(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    url: `/terms-conditions/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        showAlert(response.message, 'success');
                        loadTerms();
                    },
                    error: function(xhr) {
                        showAlert('Error deleting record', 'danger');
                    }
                });
            }
        }

        // Form submit
        $('#termsForm').on('submit', function(e) {
            e.preventDefault();
            clearErrors();
            
            const id = $('#termId').val();
            const url = id ? `/terms-conditions/${id}` : '{{ route("terms.store") }}';
            const method = id ? 'PUT' : 'POST';
            
            // Get TinyMCE content and strip HTML
            // const rawHtml = tinymce.get('content').getContent();
            // const plainText = stripHtml(html); // use your stripHtml function

            const formData = {
                title: $('#title').val(),
                content: tinymce.get('content').getContent(),
                // content: plainText,  // send only text to DB
                status: $('#status').val()
            };

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function(response) {
                    modal.hide();
                    showAlert(response.message, 'success');
                    loadTerms();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        displayErrors(errors);
                    } else {
                        showAlert('Error saving record', 'danger');
                    }
                }
            });
        });

        // Display validation errors
        function displayErrors(errors) {
            for (let field in errors) {
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}Error`).text(errors[field][0]);
            }
        }

        // Clear errors
        function clearErrors() {
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }

        // Show alert
        function showAlert(message, type) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert" style="z-index: 9999;">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $('body').append(alertHtml);
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);
        }

        // Strip HTML tags
        function stripHtml(html) {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }
    </script>
</body>
</html>
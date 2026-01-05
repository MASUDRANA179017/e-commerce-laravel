@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4 p-3">
        <div class="card-body">
            <h4 class="card-title mb-3 text-primary">Units</h4>
            <button id="addUnitBtn" class="btn btn-success mb-3">Add Unit</button>

            <table class="table table-bordered" id="unitsTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Unit Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Unit Modal -->
<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="unitForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitModalLabel">Add Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="unit_id" id="unit_id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Unit Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Unit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    var unitModal = new bootstrap.Modal(document.getElementById('unitModal'));

    var table = $('#unitsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.units.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']]
    });

    // Show Add Unit Modal
    $('#addUnitBtn').on('click', function () {
        $('#unitForm')[0].reset();
        $('#unit_id').val('');
        $('#unitModalLabel').text('Add Unit');
        unitModal.show();
    });

    // Submit Add/Edit form
    $('#unitForm').on('submit', function (e) {
        e.preventDefault();

        let id = $('#unit_id').val();
        let url = id
            ? "{{ url('admin/units/update') }}/" + id
            : "{{ route('admin.units.store') }}";
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function (res) {
                unitModal.hide();
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.success,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let msg = '';
                $.each(errors, function (key, value) {
                    msg += value + "\n";
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg,
                });
            }
        });
    });

    // Edit unit click
    $(document).on('click', '.edit-unit', function () {
        let id = $(this).data('id');
        $.get("{{ url('admin/units/edit') }}/" + id, function (data) {
            $('#unitForm')[0].reset();
            $('#unit_id').val(data.id);
            $('#name').val(data.name);
            $('#status').val(data.status);
            $('#unitModalLabel').text('Edit Unit');
            unitModal.show();
        });
    });

    // Delete unit
    $(document).on('click', '.delete-unit', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the unit!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/units/delete') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        table.ajax.reload(null, false);
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.success,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });

    // Toggle Status
    $(document).on('change', '.toggle-status', function () {
        let id = $(this).data('id');
        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ url('admin/units/toggle-status') }}/" + id,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                status: status
            },
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated',
                    text: res.success,
                    timer: 1500,
                    showConfirmButton: false
                });
                table.ajax.reload(null, false);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to update status.',
                });
                table.ajax.reload(null, false);
            }
        });
    });

});
</script>
@endpush
@push('styles')
<style>
    /* Light purple background for the entire page */
    body {
        background-color: #f5f0ff; /* very light purple */
        color: #4b3b90; /* a gentle dark purple for text */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Container padding tweak for some breathing room */
    .container.py-5 {
        max-width: 900px; /* widen container */
    }

    /* Card background and border color with subtle purple tint */
    .card {
        background-color: #faf6ff; /* very light purple white */
        border: 1px solid #d7c9ff; /* subtle purple border */
        box-shadow: 0 4px 10px rgb(150 130 255 / 0.1);
    }

    /* Table full width */
    #unitsTable {
        width: 100% !important;
    }

    /* Buttons with purple tint */
    .btn-success {
        background-color: #7a5cff;
        border-color: #7a5cff;
    }

    .btn-success:hover {
        background-color: #5a3ecc;
        border-color: #5a3ecc;
    }

    .btn-primary {
        background-color: #6b4dff;
        border-color: #6b4dff;
    }

    .btn-primary:hover {
        background-color: #532bcc;
        border-color: #532bcc;
    }

    /* Modal header background */
    .modal-header {
        background-color: #e6e0ff;
        color: #4b3b90;
    }

    /* Modal footer button */
    .modal-footer .btn-primary {
        background-color: #7a5cff;
        border-color: #7a5cff;
    }
    .modal-footer .btn-primary:hover {
        background-color: #5a3ecc;
        border-color: #5a3ecc;
    }
    .container, .row {
    max-width: 100% !important;
    padding-left: 15px;
    padding-right: 15px;
}

</style>
@endpush


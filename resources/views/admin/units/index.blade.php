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
                        <th>SL No</th>
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
<div class="modal fade" id="unitModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="unitForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Unit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="unit_id" id="unit_id">
            <div class="mb-3">
                <label>Unit Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" id="status" class="form-select">
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

@section('scripts')
<!-- Make sure jQuery and Bootstrap bundle are loaded first -->
<script>
$(document).ready(function () {

    // Initialize DataTable
    var table = $('#unitsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.units.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {
                data: 'status', 
                name: 'status', 
                orderable:false, 
                searchable:false,
                render: function(data){
                    return data == 1 ? 'Active' : 'Inactive';
                }
            },
            {data: 'action', name: 'action', orderable:false, searchable:false},
        ]
    });

    // Bootstrap 5 modal instance
    var unitModalEl = document.getElementById('unitModal');
    var unitModal = new bootstrap.Modal(unitModalEl);

    // Open modal on button click
    $('#addUnitBtn').click(function(){
        $('#unitForm').trigger("reset");
        $('#unit_id').val('');
        $('.modal-title').text('Add Unit'); // reset modal title
        unitModal.show();
    });

    // Submit Unit Form
    $('#unitForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.units.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response){
                unitModal.hide();
                table.ajax.reload();
                alert(response.success);
            },
            error: function(xhr){
                let errors = xhr.responseJSON.errors;
                let msg = '';
                $.each(errors, function(key, value){ msg += value + "\n"; });
                alert(msg);
            }
        });
    });

    // Edit Unit
    $(document).on('click', '.edit-unit', function(){
        var id = $(this).data('id');
        $.get("units/edit/"+id, function(data){
            $('#unitForm').trigger("reset");
            $('#unit_id').val(data.id);
            $('#name').val(data.name);
            $('#status').val(data.status);
            $('.modal-title').text('Edit Unit');
            unitModal.show();
        });
    });

    // Delete Unit
    $(document).on('click', '.delete-unit', function(){
        if(confirm("Are you sure?")){
            var id = $(this).data('id');
            $.ajax({
                url: "units/delete/"+id,
                type: "DELETE",
                data: {_token: "{{ csrf_token() }}"},
                success: function(response){
                    table.ajax.reload();
                    alert(response.success);
                }
            });
        }
    });

});
</script>
@endsection

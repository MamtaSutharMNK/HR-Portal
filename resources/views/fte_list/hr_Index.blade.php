@extends('layouts.mainlayout')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card o-hidden border-0 shadow-lg my-5 ">
        <div class="card-header py-3 button-blue-50 text-center">
            <h4 class="m-0 font-weight-bold">HR-FTE Requested List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered nowrap" id="fte-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">SL.No</th>
                            <th class="text-center">Request Id</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Department Function</th>
                            <th class="text-center">Date of request</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Mail Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>  

 <!-- update status -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="statusUpdateForm" method="POST">
    @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-bold" style="color:#545454;">Update Status</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="statusRequestId">
            <input type="hidden" name="status" id="statusValue" >
            <input type="hidden" name="action" value="status-change">
            <label for="comment">Comment:</label>
            <textarea name="reason" id="statusComment" class="form-control" required></textarea>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editRequestModal" tabindex="-1" role="dialog" aria-labelledby="editRequestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editRequestForm" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-bold" style="color:#545454;">Update Position Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="request_id" id="edit-request-id">

                <div class="form-group">
                    <label>No. of Positions Required</label>
                    <input type="number" class="form-control" name="no_of_positions" id="edit-no-of-positions" disabled>
                </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Already Positions Filled</label>
                    <input type="number" class="form-control" id="already-filled" disabled>
                </div>
                <div class="form-group col-md-6">
                    <label>Pending Positions</label>
                    <input type="number" class="form-control" id="pending-positions" disabled>
                </div>
            </div>
                <div class="form-group">
                    <label>Update Filled Position</label>
                    <input type="number" class="form-control" name="position_filled" id="edit-positions-filled">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection



@push('custome_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#fte-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            dom:'<"top"f>rt<"bottom"ip><"clear">',
            ajax:{
                url: "{{ route('fte_request.list.ajax') }}",
                data : { view: "{{ request('view') }}"},
                dataSrc: function(json){
                    // console.log(json);
                    return json.data;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,className: 'text-center'},
                { data: 'request_uuid', name: 'request_uuid' , orderable: true, searchable: true },
                { data: 'department_name', name: 'department.name', orderable: true, searchable: true  },
                { data: 'department_function', name: 'department_function', orderable: true, searchable: true  },
                { data: 'date_of_request', name: 'date_of_request' , orderable: true, searchable: true },
                { data: 'status_label', name: 'status', orderable: false, searchable: false },
                { data: 'mail_status_label', name: 'mail_status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']] 
        });
    });


// Edit
    $(document).ready(function() {

        // Open Modal on Edit Click
        $(document).on('click', '.edit-request-btn', function(e) {
            e.preventDefault();
            let requestId = $(this).data('id');
            $.ajax({
                url: '/fte_request/basic/' + requestId,
                method: 'GET',
                success: function(response) {
                    $('#edit-request-id').val(response.id);
                    $('#edit-no-of-positions').val(response.no_of_positions);
                    $('#already-filled').val(response.position_filled);
                    $('#edit-positions-filled').val('');
                
                    const initialPending = response.no_of_positions - response.position_filled;
                    $('#pending-positions').val(initialPending);

                    $('#edit-positions-filled').on('input', function () {
                        const total = parseInt($('#edit-no-of-positions').val()) || 0;
                        const alreadyFilled = parseInt($('#already-filled').val()) || 0;
                        const newFilled = parseInt($(this).val()) || 0;

                        const updatedFilled = alreadyFilled + newFilled;
                        const pending = Math.max(total - updatedFilled, 0);

                        $('#pending-positions').val(pending);
                    });

                    $('#editRequestModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch data');
                }
            });
        });

        // Submit Updated Data

    $('#editRequestForm').on('submit', function(e) {
            e.preventDefault();

            let requestId = $('#edit-request-id').val();
            let positionsFilled = $('#edit-positions-filled').val();

            $.ajax({
                url: '/fte_request/updatePosition/' + requestId,
                method: 'POST',
                data: {
                    position_filled: positionsFilled
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },

                success: function(response) {
                    $('#editRequestModal').modal('hide');
                    $('#fte-table').DataTable().ajax.reload(null, false);
                    Swal.fire('Updated!', 'Record updated successfully.', 'success');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        Swal.fire('Validation Error', xhr.responseJSON.message, 'warning');
                    } else {
                        Swal.fire('Error', 'Update failed.', 'error');
                    }
                }
            });
        });
    });


$(document).ready(function () {
    $(document).on('click', '.update-status-btn', function () {
        const status = $(this).data('status');
        const id = $(this).data('id');

        $('#statusValue').val(status);
        $('#statusRequestId').val(id);

        console.log('Modal populated → ID:', id, 'Status:', status);
    });
});


    $(document).on('submit', '#statusUpdateForm', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('action', 'status-change');

        $.ajax({
            method: "POST",
            url: '/fte_request/status-update',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            beforeSend: function () {
                $('#loadingIndicator').show();
            },
            success: function (response) {
                $('#statusUpdateModal').modal('hide');
                $('#statusUpdateForm')[0].reset();
                $('#loadingIndicator').hide();
                Swal.fire({
                    text: response.message,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); 
                });
            },
            error: function (xhr) {
                $('#loadingIndicator').hide();
                console.log(xhr.responseText);
                let msg = 'Something went wrong.';
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    msg = errors.join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Status update failed',
                    html: msg,
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    });




</script>

@endpush


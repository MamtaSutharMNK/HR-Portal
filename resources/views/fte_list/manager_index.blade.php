@extends('layouts.mainlayout')

@section('content')
<!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card o-hidden border-0 shadow-lg my-5 ">
        <div class="card-header py-3 button-blue-50 text-center">
            <h4 class="m-0 font-weight-bold">Manager-FTE Requested List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered nowrap" id="fte-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">SL.No</th>
                            <th class="text-center">Request Id</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Date of request</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Mail Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custome_js')
<script>
$(document).ready(function() {
    $('#fte-table').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        ajax:{
            url: "{{ route('fte_request.list.ajax') }}",
            data : { view: "{{ request('view') }}"},
            dataSrc: function(json){
                console.log(json);
                return json.data;
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,className: 'text-center'},
            { data: 'request_uuid', name: 'request_uuid' , orderable: true, searchable: true },
            { data: 'department_name', name: 'department.name', orderable: false, searchable: true  },
            { data: 'created_at',name: 'created_at',orderable: true,searchable: true,
                render: function(data, type, row) {
                    if (!data) return '-';

                    const date = new Date(data);

                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();

                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const seconds = String(date.getSeconds()).padStart(2, '0');

                    return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
                }
            },
            { data: 'status_label', name: 'status', orderable: false, searchable: true },
            { data: 'mail_status_label', name: 'mail_status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
         order: [[0, 'desc']] ,
    });
});
</script>

@endpush
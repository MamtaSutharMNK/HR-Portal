@extends('layouts.mainlayout')

@section('content')

     <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">FTE REQUEST</h1>
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">FTE LIST</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="fte-table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Request Id</th>
                                            <th>Department</th>
                                            <th>Department Function</th>
                                            <th>Manager</th>
                                            <th>Date of request</th>
                                            <th>Status</th>
                                            <th>Mail Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
  
@endsection

@push('custome_js')

<script>
$(document).ready(function() {
    $('#fte-table').DataTable({
        processing: true,
        serverSide: true,
        dom: 'ftp',
        ajax:{
            url: "{{ route('fte_request.list.ajax') }}",
            dataSrc: function(json){
                console.log(json);
                return json.data;
            }
        },
        columns: [
            { data: 'request_uuid', name: 'request_uuid' , orderable: true, searchable: true },
            { data: 'department_name', name: 'department.name', orderable: true, searchable: true  },
            { data: 'department_function', name: 'department_function', orderable: true, searchable: true  },
            { data: 'manager_name', name: 'manager_name', orderable: true, searchable: true  },
            { data: 'date_of_request', name: 'date_of_request' , orderable: false, searchable: false },
            { data: 'status_label', name: 'status', orderable: false, searchable: false },
            { data: 'mail_status_label', name: 'mail_status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>

@endpush
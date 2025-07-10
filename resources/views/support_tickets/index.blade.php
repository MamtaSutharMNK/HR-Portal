@extends('layouts.mainlayout')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
   <div class="d-flex justify-content-end">
        <a href="{{ route('support_tickets.create') }}"
           class="btn btn-primary btn-sm d-flex align-items-center">
            Create New Ticket
        </a>
    </div>
    <div class="card o-hidden border-0 shadow-lg my-5 ">
        <div class="card-header py-3 button-blue-50 text-center">
            <h4 class="m-0 font-weight-bold">Support Ticket List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="fte-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">SL.No</th>
                            <th class="text-center">Ticket No</th>
                            <th class="text-center">Ticket Title</th>
                            <th class="text-center">Department Function</th>
                            <th class="text-center">Date of request</th>
                            <th class="text-center">Requested By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>  

@endsection

@push('custome_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush


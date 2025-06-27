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
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                    <tbody>
                                        @php
                                        use App\Models\RequestForm;
                                        @endphp
                                        @forelse($data as $item)
                                            <tr>
                                                <td>{{ $item->request_uuid }}</td>
                                                <td>{{ $item->department->name ?? 'N/A' }}</td>
                                                <td>{{ $item->department_function ?? 'N/A' }}</td>
                                                <td>{{ $item->manager_name ?? 'N/A' }}</td>
                                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                <td><p class="badge badge-{{RequestForm::STATUS_COLORS[$item->status]}}">{{ RequestForm::STATUS_BY_ID[$item->status]}}</p></td>
                                                <td ><p class="badge badge-{{RequestForm::MAIL_STATUS_COLORS[$item->mail_status]}}">{{ RequestForm::STATUS_BY_MAIL_ID[$item->mail_status]}}</p></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle bg-primary" type="button" id="actionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                            <a class="dropdown-item" href="{{ route('fte_request.show', $item->id )}}">
                                                                <i class="fas fa-eye mr-2"></i>View
                                                            </a>
                                                            <a class="dropdown-item" href="{{ route('fte_request.edit', $item->id )}}">
                                                                <i class="fas fa-edit mr-2"></i>Edit
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                           <tr>
                                                <td colspan="8" style="text-align: center;">N/A</td>
                                           </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
  
@endsection
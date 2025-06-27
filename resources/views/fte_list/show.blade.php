@extends('layouts.mainlayout')

@section('content')
@include('fte_list.reject_reason')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <h1 class="h3 mb-4 text-center text-primary">FTE REQUEST DETAILS</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Request Id:</strong> {{ $data->request_uuid ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Date of Request:</strong> {{ $data->date_of_request ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Requested By:</strong> {{ $data->requested_by ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                    @php
                    use App\Models\RequestForm;
                    @endphp

                <div class="row">
                    
                     <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Business Unit:</strong> {{ $data->department->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Requesting Branch:</strong> {{ $data-> requestingBranch->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Department Function:</strong> {{ $data->department_function ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                      <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Approving Manager Name:</strong> {{ $data->manager_name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Manager Email:</strong> {{ $data->manager_email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>HR Email:</strong> {{ $data->hr_email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                     <div class="col-md-6 mb-3 {{ empty($data->level2_email) ? 'd-none' : '' }}">
                        <div class="p-2">
                            <p><strong>Local Head Email:</strong> {{ $data->level2_email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 {{ empty($data->level3_email) ? 'd-none' : '' }}">
                        <div class="p-2">
                            <p><strong>Global Head Email:</strong> {{ $data->level3_email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row ">    
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Employee Level:</strong> {{ $data->employeeLevel->title ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Job Title:</strong> {{ $data->jobDetail->job_title ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Number of Positions:</strong> {{ $data->no_of_positions ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                     <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Positions Filled:</strong> {{ $data->position_filled ?? '0' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Mail Status:</strong> {{  RequestForm::STATUS_BY_MAIL_ID[$data->mail_status] }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Form Status:</strong> {{ RequestForm::STATUS_BY_ID[$data->status] }}</p>
                        </div>
                    </div>
                </div>
             
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Type of Employment:</strong> {{ $data->type_of_employment ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Employment Category:</strong> {{ $data->employment_category?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Work Location:</strong> {{ $data->work_location ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Target End Date:</strong> {{ $data->target_by_when ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>currency:</strong> {{ $data->currency ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>CTC Type:</strong> {{ config('dropdown.ctc_types')[$data->ctc_type] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>CTC Start Range:</strong> {{ $data->ctc_start_range ?? '-' }}</p>
                            <p><strong>CTC End Range:</strong> {{ $data->ctc_end_range ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Education:</strong> {{ $data->jobDetail->education ?? '-' }}</p> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>experience:</strong> {{ $data->jobDetail->experience ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Key Skills:</strong> {{ $data->jobDetail->key_skills ?? '-' }}</p> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>language Required:</strong> {{ $data->jobDetail->language_required ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Certifications:</strong> {{ $data->jobDetail->certifications ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Job Description:</strong> {{ $data->jobDetail->job_description ?? '-' }}</p> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Justification Details:</strong> {{ $data->justification_details ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Consequences of not Hiring:</strong> {{ $data->consequences_of_not_hiring ?? '-' }}</p> 
                        </div>
                    </div>
                    
                    
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Requition Type:</strong> {{ $data->requisition_type ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 {{ empty($data->replacing_employee) ? 'd-none' : '' }}">
                        <div class="p-3">
                            <p><strong>Replacing Employee:</strong> {{ $data->replacing_employee ?? '-' }}</p>
                        </div>
                    </div>
                    

                </div>
             <!-- Buttons Row -->
                @php
                    $display = 'd-none';
                    $action = 'd-none';
                    $userEmail = Auth::user()->email;
                
                    if ($data->hr_email === $userEmail) {
                        $display = 'd-flex';
                        $action = '';
                    } else {

                        if ($data->mail_status === RequestForm::MAIL_PENDING && Auth::user()->email = $data->manager_email ) {
                                $display = 'd-flex';
                        }

                        if(!empty($data->approval_level)){

                            if ($data->approval_level >= 2 && $data->mail_status === RequestForm::MANAGER_MAIL_APPROVAL ){
                                $display = 'd-flex';
                            }elseif($data->approval_level >= 3 && $data->mail_status === RequestForm::LEVEL2_MAIL_APPROVAL ){
                                $display = 'd-flex';
                            }

                        }
                    }
                @endphp

                <div class="row">
                    <div class="col-md-11">
                        <div class="justify-content-end approval_btn {{$action}}">
                            <button class="btn btn-success" onclick="StatusFTE('{{$data->id}}','close')">Close</button>
                            <span style="font-size: 30px; margin-left: 20px;"></span>
                            <button class="btn btn-primary" onclick="StatusFTE('{{$data->id}}','done')">Done</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-11">
                        <div class="justify-content-end approval_btn {{$display}}">
                            <button class="btn btn-success" onclick="confirmAction('{{$data->id}}')">Accept</button>
                            <span style="font-size: 30px; margin-left: 20px;"></span>
                            <button class="btn btn-danger" onclick="rejectAction('{{$data->id}}')">Reject</button>
                        </div>
                    </div>
                </div>


                @if(isset($data->actionLog) && $data->actionLog->count() > 0)
                    <div class="panel mt-2">
                        <div
                            class="flex justify-between panel-subheading text-2xl font-bold uppercase">
                            Action Log
                        </div>
                        <div class="panel-body">
                            <table class="ui celled striped table table-striped">
                                <thead>
                                <tr>
                                    <th class="center aligned"> Status</th>
                                    <th class="center aligned" colspan="3"> Reason</th>
                                    <th class="center aligned"> Date</th>
                                    <th class="center aligned"> Action By</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($data->actionLog as $log)
                                    <tr>
                                        <td class="text-black uppercase center aligned">
                                            <span class="badge badge-{{RequestForm::STATUS_COLORS[$log->status]}} ">
                                                {{ RequestForm::STATUS_BY_ID[$log->status] }}
                                            </span>
                                        </td>
                                        <td class="text-black uppercase center aligned" colspan="3">
                                            {{ $log->description ?? 'N/A' }}
                                        </td>
                                        <td class="text-black uppercase center aligned">
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/y H:i:s') }}
                                        </td>
                                        <td class="text-black uppercase center aligned">
                                            {{ $log->user->name ?? '' }}
                                        </td>
                                    </tr>

                                    @php
                                        $previousStatus = $log->risk_status;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

        </div>
    </div>
</div>

@endsection

@push('custome_js')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script type="text/javascript" src="{{ asset('custome_js/fte_list.js') }}"></script>

@endpush

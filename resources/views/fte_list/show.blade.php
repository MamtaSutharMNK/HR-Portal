@extends('layouts.mainlayout')

@section('content')
@include('fte_list.reject_reason')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/fte-show.css') }}">
@endpush

<div class="container-fluid">
    <div class="card o-hidden border-0 shadow-lg my-5 ">
        <div class="card-header py-3 button-blue-50 text-white text-center">
            <h4 class="m-0 font-weight-bold">FTE Request Details</h4>
        </div>
        <div class="card-body">

            {{-- Basic Info --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Request ID</span>
                    <span class="ant-description-content">{{ $data->request_uuid ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Date of Request</span>
                    <span class="ant-description-content">{{ $data->date_of_request ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Requested By</span>
                    <span class="ant-description-content">{{ $data->requested_by ?? '-' }}</span>
                </div>
            </div>

            {{-- Department & Manager --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Department</span>
                    <span class="ant-description-content">{{ $data->department->name ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Function</span>
                    <span class="ant-description-content">{{ $data->department_function ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Branch</span>
                    <span class="ant-description-content">{{ $data->requestingBranch->name ?? '-' }}</span>
                </div>
                 <div class="ant-description-item">
                    <span class="ant-description-label">Approval Level</span>
                    <span class="ant-description-content">{{ config('dropdown.approval_level')[$data->approval_level] ?? '-'  }}</span>
                </div>

                <div class="ant-description-item">
                    <span class="ant-description-label">Manager Email (L1)</span>
                    <span class="ant-description-content">{{ $data->manager_email_l1 ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">HR Email (L1)</span>
                    <span class="ant-description-content">{{ $data->hr_email_l1 ?? '-' }}</span>
                </div>
                <div class="ant-description-item {{ $data->manager_email_l2 ?? 'd-none' }}">
                    <span class="ant-description-label">Manager Email (L2)</span>
                    <span class="ant-description-content">{{ $data->manager_email_l2 ?? '-' }}</span>
                </div>
                <div class="ant-description-item {{ $data->hr_email_l2 ?? 'd-none' }}">
                    <span class="ant-description-label">HR Email (L2)</span>
                    <span class="ant-description-content">{{ $data->hr_email_l2 ?? '-' }}</span>
                </div>
                <div class="ant-description-item {{ $data->manager_email_l3 ?? 'd-none' }}">
                    <span class="ant-description-label">Manager Email (L3)</span>
                    <span class="ant-description-content">{{ $data->manager_email_l3 ?? '-' }}</span>
                </div>
                <div class="ant-description-item {{ $data->hr_email_l3 ?? 'd-none' }}">
                    <span class="ant-description-label">HR Email (L3)</span>
                    <span class="ant-description-content">{{ $data->hr_email_l3 ?? '-' }}</span>
                </div>
            </div>

            {{-- Job Details --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Job Title</span>
                    <span class="ant-description-content">{{ $data->jobDetail->job_title ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Employee Level</span>
                    <span class="ant-description-content">{{ $data->employeeLevel->title ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">No. of Positions</span>
                    <span class="ant-description-content">{{ $data->no_of_positions ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Position Filled</span>
                    <span class="ant-description-content">{{ $data->position_filled ?? '0' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Requisition Type</span>
                    <span class="ant-description-content">{{ $data->requisition_type ?? '-' }}</span>
                </div>
                @if(!empty($data->replacing_employee))
                <div class="ant-description-item">
                    <span class="ant-description-label">Replacing Employee</span>
                    <span class="ant-description-content">{{ $data->replacing_employee }}</span>
                </div>
                @endif
            </div>

            {{-- Compensation --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Currency</span>
                    <span class="ant-description-content">{{ $data->currency ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">CTC Type</span>
                    <span class="ant-description-content">{{ config('dropdown.ctc_types')[$data->ctc_type] ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">CTC Range</span>
                    <span class="ant-description-content">₹{{ $data->ctc_start_range }} - ₹{{ $data->ctc_end_range }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Target End Date</span>
                    <span class="ant-description-content">{{ $data->target_by_when ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Work Location</span>
                    <span class="ant-description-content">{{ $data->work_location ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Employment Type</span>
                    <span class="ant-description-content">{{ $data->type_of_employment ?? '-' }}</span>
                </div>
            </div>

            {{-- Skills --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Key Skills</span>
                    <span class="ant-description-content">{{ $data->jobDetail->key_skills ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Certifications</span>
                    <span class="ant-description-content">{{ $data->jobDetail->certifications ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Languages Required</span>
                    <span class="ant-description-content">{{ $data->jobDetail->language_required ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Education</span>
                    <span class="ant-description-content">{{ $data->jobDetail->education ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Experience</span>
                    <span class="ant-description-content">{{ $data->jobDetail->experience ?? '-' }}</span>
                </div>
            </div>

            {{-- Justification --}}
            <div class="ant-description-row">
                <div class="ant-description-item" >
                    <span class="ant-description-label">Justification</span>
                    <span class="ant-description-content">{{ $data->justification_details ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Consequences of Not Hiring</span>
                    <span class="ant-description-content">{{ $data->consequences_of_not_hiring ?? '-' }}</span>
                </div>
                <div class="ant-description-item" >
                    <span class="ant-description-label">Job Description</span>
                    <span class="ant-description-content">{{ strip_tags($data->jobDetail->job_description ?? '-') }}</span>
                </div>
            </div>

            {{-- Status --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">FTE Status</span>
                    <span class="ant-description-content badge badge-success">
                        {{ \App\Models\RequestForm::STATUS_BY_ID[$data->status] ?? '-' }}
                    </span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Mail Status</span>
                    <span class="ant-description-content badge badge-warning">
                        {{ \App\Models\RequestForm::STATUS_BY_MAIL_ID[$data->mail_status] ?? '-' }}
                    </span>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-11 d-flex justify-content-between align-items-center">
                    @php
                    
                        $display_Reject = 'd-none';
                        $display_Accept = 'd-none';
                    
                        $level = $data->approval_level;
                        $status = $data->mail_status;
                    
                        $currentUserEmail = Auth::user()->email;
                    
                        // Get manager and HR emails for each level
                        $managerL1 = $data->manager_email_l1;
                        $managerL2 = $data->manager_email_l2;
                        $managerL3 = $data->manager_email_l3;
                    
                        $hrL1 = $data->hr_email_l1;
                        $hrL2 = $data->hr_email_l2;
                        $hrL3 = $data->hr_email_l3;

                        $hrEmails = [$hrL1, $hrL2, $hrL3];
            
                        if (!in_array($currentUserEmail, $hrEmails)) {
                            if (
                                ($currentUserEmail == $managerL1 && $status == \App\Models\RequestForm::MAIL_PENDING) ||
                                ($currentUserEmail == $managerL2 && $status == \App\Models\RequestForm::LEVEL1_MAIL_APPROVAL) ||
                                ($currentUserEmail == $managerL3 && $status == \App\Models\RequestForm::LEVEL2_MAIL_APPROVAL)
                            ) {
                                $display_Reject = '';
                                $display_Accept = '';
                            }
                        }
                    
                        // Optional: HR Approval button (no reject)
                        if (
                            ($currentUserEmail == $hrL1 && $status == \App\Models\RequestForm::LEVEL3_MAIL_APPROVAL) ||
                            ($currentUserEmail == $hrL2 && $status == \App\Models\RequestForm::LEVEL3_MAIL_APPROVAL) ||
                            ($currentUserEmail == $hrL3 && $status == \App\Models\RequestForm::LEVEL3_MAIL_APPROVAL)
                        ) {
                            $display_Accept = '';
                        }
                    @endphp

                    <div class="d-flex gap-2">
                        <button class="btn btn-success {{$display_Accept}}" onclick="confirmAction('{{ $data->id }}')">Accept</button>
                        <button class="btn btn-danger {{$display_Reject}}" onclick="rejectAction('{{ $data->id }}')" style="margin-left:30px">Reject</button>
                    </div>

                </div>
            </div>
            <br>

             <!-- Action Log -->

            @if(isset($data->actionLog) && $data->actionLog->count() > 0)
                <div class="panel mt-2">
                    <div class="flex justify-between panel-subheading text-2xl font-bold uppercase">
                       <b> ACTION LOG </b>
                    </div>
                    <div class="panel-body">
                        <table class="ui celled striped table table-striped">
                            <thead>
                            <tr>
                                <th class="center aligned"> Status</th>
                                <th class="center aligned" colspan="3">Reason</th>
                                <th class="center aligned"> Date</th>
                                <th class="center aligned"> Action By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data->actionLog as $log)
                                <tr>
                                    <td class="text-black uppercase center aligned">
                                        <span class="badge badge-{{ \App\Models\RequestForm::STATUS_COLORS[$log->status]}} ">
                                            {{ \App\Models\RequestForm::STATUS_BY_ID[$log->status] }} 
                                        </span>
                                    </td>
                                    <td class="text-black uppercase center aligned" colspan="3">
                                        {{ $log->reason ?? 'N/A' }}
                                    </td>
                                    <td class="text-black uppercase center aligned">
                                        {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/y H:i:s') }}
                                    </td>
                                    <td class="text-black uppercase center aligned">
                                        {{ $log->user->name ?? '' }}
                                    </td>
                                </tr>
                                @php
                                 $previousStatus = $log->status;
                                @endphp
                            @endforeach
                             </tbody>
                        </table>
                    </div>
                </div>
            @endif  
            <!-- <div class="container-fluid">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('fte_request.create')}}" class="btn btn-secondary btn-sm">
                        ← Go Back
                    </a>

                </div>
            </div> -->
   
        </div>
    </div>
    
</div>

@endsection

@push('custome_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript" src="{{ asset('custome_js/fte_list.js') }}"></script>

@endpush

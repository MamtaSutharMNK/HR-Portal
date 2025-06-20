@extends('layouts.mainlayout')

@section('content')

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
                            <p><strong>Manager:</strong> {{ $data->manager_name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- admin  -->
                    <!-- <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Name:</strong> {{ $data->requested_by ?? '-' }}</p>
                        </div>
                    </div> -->
                     <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Manager Email:</strong> {{ $data->manager_email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Business Unit:</strong> {{ $data->department->name ?? '-' }}</p>
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
                            <p><strong>Requesting Branch</strong> {{ $data->requestingBranch->name ?? '-' }}</p>
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
                            <p><strong>Requition Type:</strong> {{ $data->requisition_type ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Justification Details:</strong> {{ $data->justification_details ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3">
                            <p><strong>Consequences of not Hiring:</strong> {{ $data->consequences_of_not_hiring ?? '-' }}</p> 
                        </div>
                    </div>

                </div>
             
             <!-- Buttons Row -->
                @php
                    use App\Models\RequestForm;
                
                    $display = 'd-none';
                
                    $userEmail = Auth::user()->email;
                
                    if (env('HR_MAIL') === $userEmail) {
                        $display = 'd-flex';
                    } else {
                        if ($data->mail_status === RequestForm::MAIL_PENDING && env('CFO_MAIL') === $userEmail) {
                            $display = 'd-flex';
                        } elseif ($data->mail_status === RequestForm::CFO_Mail_APPROVAL && env('CTO_MAIL') === $userEmail) {
                            $display = 'd-flex';
                        }
                    }
                @endphp
            <div class="row">
                <div class="col-md-11">
                    <div class="justify-content-end approval_btn {{$display}}">
                        <button class="btn btn-success" onclick="confirmAction('{{$data->id}}')">Accept</button>
                        <span style="font-size: 30px; margin-left: 20px;"></span>
                        <button class="btn btn-danger" onclick="rejectAction('{{$data->id}}')">Reject</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('custome_js')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script type="text/javascript" src="{{ asset('custome_js/fte_list.js') }}"></script>
  <script>
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
  </script>

@endpush


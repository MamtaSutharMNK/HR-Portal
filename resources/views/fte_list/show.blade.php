@extends('layouts.mainlayout')

@section('content')
@include('fte_list.reject_reason')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">


<style>
    .ant-description-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 0.5rem;
    }

    .ant-description-item {
        flex: 0 0 33.3333%;
        padding: 0.5rem 1rem;
    }

    .ant-description-label {
        font-weight: 600;
        color: #6c757d;
        display: block;
        font-size: 0.9rem;
        margin-bottom: 0.2rem;
    }

    .ant-description-content {
        color: #212529;
        font-size: 1rem;
    }

    .card-header h4 {
        font-weight: 600;
    }

    .badge {
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white text-center">
            <h4 class="m-0">FTE Request Details</h4>
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
                    <span class="ant-description-label">Manager Name</span>
                    <span class="ant-description-content">{{ $data->manager_name ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Manager Email</span>
                    <span class="ant-description-content">{{ $data->manager_email ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">HR Email</span>
                    <span class="ant-description-content">{{ $data->hr_email ?? '-' }}</span>
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
                <div class="ant-description-item" style="flex: 0 0 100%">
                    <span class="ant-description-label">Justification</span>
                    <span class="ant-description-content">{{ $data->justification_details ?? '-' }}</span>
                </div>
                <div class="ant-description-item" style="flex: 0 0 100%">
                    <span class="ant-description-label">Consequences of Not Hiring</span>
                    <span class="ant-description-content">{{ $data->consequences_of_not_hiring ?? '-' }}</span>
                </div>
                <div class="ant-description-item" style="flex: 0 0 100%">
                    <span class="ant-description-label">Job Description</span>
                    <span class="ant-description-content">{{ $data->jobDetail->job_description ?? '-' }}</span>
                </div>
            </div>

            {{-- Status --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Form Status</span>
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

            <div class="row">
                <div class="col-md-11">
                    <div class="justify-content-end approval_btn">
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

@endpush

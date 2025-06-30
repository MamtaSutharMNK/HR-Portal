@extends('layouts.mainlayout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-center text-primary">Edit FTE Request</h1><form action="{{ route('fte_request.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>Date of Request</strong></label>
                    <input type="date" name="date_of_request" class="form-control" value="{{ $data->date_of_request }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Requested By</strong></label>
                    <input type="text" name="requested_by" class="form-control" value="{{ $data->requested_by }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Business Unit</strong></label>
                    <select name="department_id" class="form-control">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ $data->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>Requesting Branch</strong></label>
                    <input type="text" name="requesting_branch" class="form-control" value="{{ $data->requestingBranch->name ?? '' }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Department Function</strong></label>
                    <input type="text" name="department_function" class="form-control" value="{{ $data->department_function }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Approving Manager Name</strong></label>
                    <input type="text" name="manager_name" class="form-control" value="{{ $data->manager_name }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>Manager Email</strong></label>
                    <input type="email" name="manager_email" class="form-control" value="{{ $data->manager_email }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>HR Email</strong></label>
                    <input type="email" name="hr_email" class="form-control" value="{{ $data->hr_email }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Local Head Email</strong></label>
                    <input type="email" name="level2_email" class="form-control" value="{{ $data->level2_email }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>Global Head Email</strong></label>
                    <input type="email" name="level3_email" class="form-control" value="{{ $data->level3_email }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Employee Level</strong></label>
                    <input type="text" name="employee_level" class="form-control" value="{{ $data->employeeLevel->title }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Job Title</strong></label>
                    <input type="text" name="job_title" class="form-control" value="{{ $data->jobDetail->job_title }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>No. of Positions</strong></label>
                    <input type="number" name="no_of_positions" class="form-control" value="{{ $data->no_of_positions }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Type of Employment</strong></label>
                    <input type="text" name="type_of_employment" class="form-control" value="{{ $data->type_of_employment }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Employment Category</strong></label>
                    <input type="text" name="employment_category" class="form-control" value="{{ $data->employment_category }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>Work Location</strong></label>
                    <input type="text" name="work_location" class="form-control" value="{{ $data->work_location }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Target End Date</strong></label>
                    <input type="date" name="target_by_when" class="form-control" value="{{ $data->target_by_when }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Currency</strong></label>
                    <input type="text" name="currency" class="form-control" value="{{ $data->currency }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>CTC Type</strong></label>
                    <input type="text" name="ctc_type" class="form-control" value="{{ $data->ctc_type }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>CTC Start Range</strong></label>
                    <input type="text" name="ctc_start_range" class="form-control" value="{{ $data->ctc_start_range }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>CTC End Range</strong></label>
                    <input type="text" name="ctc_end_range" class="form-control" value="{{ $data->ctc_end_range }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>Education</strong></label>
                    <input type="text" name="education" class="form-control" value="{{ $data->jobDetail->education }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Experience</strong></label>
                    <input type="text" name="experience" class="form-control" value="{{ $data->jobDetail->experience }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Key Skills</strong></label>
                    <input type="text" name="key_skills" class="form-control" value="{{ $data->jobDetail->key_skills }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><strong>Languages Required</strong></label>
                    <input type="text" name="language_required" class="form-control" value="{{ $data->jobDetail->language_required ?? 'NA'}}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Certifications</strong></label>
                    <input type="text" name="certifications" class="form-control" value="{{ $data->jobDetail->certifications }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label><strong>Job Description</strong></label>
                    <textarea name="job_description" class="form-control">{{ $data->jobDetail->job_description }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><strong>Justification Details</strong></label>
                    <textarea name="justification_details" class="form-control">{{ $data->justification_details }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label><strong>Consequences of Not Hiring</strong></label>
                    <textarea name="consequences_of_not_hiring" class="form-control">{{ $data->consequences_of_not_hiring }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><strong>Requisition Type</strong></label>
                    <input type="text" name="requisition_type" class="form-control" value="{{ $data->requisition_type }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label><strong>Replacing Employee</strong></label>
                    <input type="text" name="replacing_employee" class="form-control" value="{{ $data->replacing_employee }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><strong>Position Filled</strong></label>
                    <input type="number" name="position_filled" class="form-control" value="{{ $data->position_filled }}">
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Update Request</button>
            </div>

        </div>
    </div>
</form>

</div>

@push('custome_js')
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const noOfPositions = document.querySelector('input[name="no_of_positions"]');
    const positionFilled = document.querySelector('input[name="position_filled"]');

    form.addEventListener('submit', function (e) {
        const total = parseInt(noOfPositions.value, 10);
        const filled = parseInt(positionFilled.value, 10);

        if (!isNaN(total) && !isNaN(filled) && filled > total) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Input',
                text: 'Positions filled cannot be greater than total number of positions.',
            });
        }
    });
});
</script>
@endpush

@endsection

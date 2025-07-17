@extends('layouts.mainlayout')

@section('content')   

<div class="container">
    <div class="row justify-content-center">
            <div class="card o-hidden border-0 shadow-lg my-5 ">
                <div class="card-header button-blue-50" >
                    <h4 class="text-center black-text font-weight-bold ">Full Time Employment Form</h4>
                </div>
                <div class="card-body" style=" padding: 10px 50px 50px 50px;">
                   
                    <form method="POST" id="fteRequestForm" action="{{ route('fte_request.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <!-- Section 1 -->
                        <div class="mb-4">
                            <h5 class="text-blue-50 fw-bold">Request Overview</h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Business Unit</label>
                                <div class="d-flex gap-2">
                                    <select name="department_id" id="department_id" class="form-control form-control-custom" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn-outline form-control form-control-custom ms-2" id="openAddDeptModal" style="width: 50px;">+</button>
                                </div>
                                <div class="invalid-feedback">Please select a department</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">HIRING REGION/Country</label>
                                <input list="countries" id="country" name="country" class="form-control form-control-custom" required>
                                <datalist id="countries"></datalist>
                                <div class="invalid-feedback">Please select country</div>
                            </div> 
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Requested By</label>
                                <input type="text" name="requested_by" class="form-control form-control-custom" required>
                                <div class="invalid-feedback">Enter the name.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Requesting Branch</label>
                                <div class="d-flex gap-2">
                                    <select name="branch_id" id="branch_id" class="form-control form-control-custom" required>
                                        <option value="">Select Requesting Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn-outline form-control form-control-custom ms-2" id="openAddBranchModal" style="width: 50px;">+</button>
                                </div>
                                <div class="invalid-feedback">Please select a branch</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Approval Level</label>
                                @foreach (config('dropdown.approval_level') as $key => $value)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input approval-checkbox" type="radio" name="approval_level"
                                        value="{{ $key }}" id="approval_level_{{ $key }}" style="margin-left: 7px">
                                    <label class="form-check-label">{{ $value }}</label>
                                </div>
                                @endforeach
                                <div class="invalid-feedback">Select approval level</div>
                            </div>
                        </div>

                         @foreach (config('dropdown.approval_level') as $key => $value)
                            <div class="row mb-3 d-none approval_level_l{{ $key }}">
                                <div class="col-md-6">
                                    <label class="form-label-custom">APPROVING MANAGER EMAIL (Level {{ $key }})</label>
                                    <input type="email" id="manager_email_l{{ $key }}" name="manager_email_l{{ $key }}"
                                        class="form-control form-control-custom email-level" data-level="1">
                                    <div class="invalid-feedback">Enter a valid official email.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">HR EMAIL (Level {{ $key }})</label>
                                    <input type="email" id="hr_email_l{{ $key }}" name="hr_email_l{{ $key }}"
                                        class="form-control form-control-custom email-level" data-level="1">
                                    <div class="invalid-feedback">Enter a valid official email.</div>
                                </div>
                            </div>
                         @endforeach

                      <hr>
                        <!-- Section 2: Position Details -->
                        <div class="mb-4">
                          <h5 class="text-blue-50 fw-bold">Position Details</h5>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Job Title</label>
                                <input type="text" id="jobDetailInput" name="job_title" class="form-control form-control-custom" required>
                                <div class="invalid-feedback" id="jobsDetailError">Numbers are not allowed</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Number of Positions</label>
                                <input type="number" name="no_of_positions" class="form-control form-control-custom" required>
                                <div class="invalid-feedback">Enter the number of positions</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Type of Employment</label>

                            @foreach (config('dropdown.type_of_employment') as $key => $value)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="type_of_employment[]" value="{{ $key }}" style="margin-left: 7px" >
                                    <label class="form-check-label">{{ $value }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Employment Category</label>
                            @foreach (config('dropdown.employment_categories') as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="employment_category[]" value="{{ $key }}" style="margin-left: 7px" >
                                <label class="form-check-label">{{ $value }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Work Location</label>
                                <input type="text" id="locationInput" name="work_location" class="form-control form-control-custom" required>
                                <div class="invalid-feedback" id="locationError">Numberic not allowed</div>

                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Target by when</label>
                                <input type="date" name="target_by_when" class="form-control form-control-custom" required min="<?= date('Y-m-d'); ?>">
                                <div class="invalid-feedback">Enter a target date</div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Department / Function</label>
                                <input type="text" name="department_function" class="form-control form-control-custom" required >
                                <div class="invalid-feedback">Please select department function</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Employee Level</label>
                                <div class="d-flex gap-2">
                                    <select name="employee_level" id="employee_level" class="form-control form-control-custom" required>
                                        <option value="">Select Level</option>
                                        @foreach($employeeLevels as $levels)
                                            <option value="{{ $levels->id }}">{{ $levels->title }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn-outline form-control form-control-custom ms-2" id="openAddLevelModal" style="width: 50px;" data-bs-toggle="modal" data-bs-target="#multiEmployeeLevelModal">+</button>
                                </div>
                                <div class="invalid-feedback">Please select Employee Level</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                            <label class="form-label-custom">Budgeted Currency</label>
                                <input list="currencies" id="currency" name="currency" class="form-control form-control-custom" required>
                                <datalist id="currencies"></datalist>
                                <div class="invalid-feedback">Please select currency</div>
                            </div>   

                            <div class="col-md-3" id="ctcTypeWrapper">
                                <label class="form-label-custom">CTC Type</label>
                                <select id="ctcType" name="ctc_type" class="form-control form-control-custom" required>
                                    <option value="">Select Type</option>
                                    @foreach (config('dropdown.ctc_types') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                 <div class="invalid-feedback">Please select CTC Type</div>
                            </div>

                            {{-- CTC Range Inputs (Hidden Initially) --}}
                            <div class="col-md-4" id="ctcRangeWrapper">
                                <label class="form-label-custom">CTC Range</label>
                                <div class="d-flex align-items-center" >
                                    <input type="number" step="0.1" name="ctc_start_range" placeholder="Min Range" class="form-control form-control-custom" style="width: 185px;" required>
                                    <span style="font-size: 20px; margin-left: 4px;">-</span>
                                    <input type="number" step="0.1" name="ctc_end_range" placeholder="Max Range" class="form-control form-control-custom" style="width: 185px;" required>
                                </div>
                            </div>
                        </div>
                        <hr>    
                        <!-- Section3: Role Requirements -->
                        <div class="mb-4">
                          <h5 class="text-blue-50 fw-bold">Role Requirements</h5>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Education</label>
                                <input type="text" id="educationInput" name="education" class="form-control form-control-custom" required>
                                 <div class="invalid-feedback" id="educationError">Numbers are not allowed in this field.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Experience</label>
                                <input type="text" id="experienceInput" name="experience" class="form-control form-control-custom" required>
                                <div class="invalid-feedback" id="experinceError">Enter a numberic value</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Key Skills</label>
                                <input type="text" id="skillsInput" name="key_skills" class="form-control form-control-custom" required>
                                <div class="invalid-feedback" id="skillsError">Numbers are not allowed</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Languages If Required</label>
                                <input type="text" id="languageInput" name="language_required" class="form-control form-control-custom" >
                                <div class="invalid-feedback" id="languageError">Enter the language</div>
                            </div>
                            
                            
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Certifications (IF Any)</label>
                                <input type="text" id="certificationsInput" name="certifications" class="form-control form-control-custom" placeholder="If any (certifications)">
                                <div class="invalid-feedback" id="certificationsError">Numberic not allowed</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Job Description (Brief Desc)</label>
                                <textarea name="job_description" rows="1" class="form-control form-control-custom" id="editor" required></textarea>
                                <div id="char-count" style="font-size: 12px; margin-top: 5px; color: #555;"></div>
                                <div class="invalid-feedback">Enter the job description</div>
                            </div>
                        </div>
                        <hr>    
                        <!-- Section4: Business Justification -->
                        <div class="mb-4">
                            <h5 class="text-blue-50 fw-bold">Business Justification</h5>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Requisition Type</label>
                            @foreach (config('dropdown.requisition_types') as $key => $value)
                                @php
                                    $explanations = [
                                        'New' => 'For brand new positions',
                                        'Replacement' => 'To replace an existing employee',
                                        'Expansion' => 'To grow the team or department',
                                        'TemporaryNeed' => 'For short-term or seasonal staffing needs',
                                        'ProjectBased' => 'For roles tied to a specific project duration',
                                    ];
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="requisition_type[]" value="{{ $key }}" title="{{ $explanations[$key] ?? $value }}" style="margin-left: 7px">
                                    <label class="form-check-label" title="{{ $explanations[$key] ?? $value }}">
                                        {{ $value }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mb-3" id="replacing-employee-group" style="display: none;">
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Replacing Employee</label>
                                <input type="text" name="replacing_employee" class="form-control form-control-custom" placeholder="Employee Name">
                                <div class="invalid-feedback">Please enter the name of the employee being replaced.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Justification Details</label>
                            <textarea name="justification_details" rows="2" class="form-control form-control-custom" placeholder="Explain the reason for the requisition" required></textarea>
                            <div class="invalid-feedback">Enter Justification Details </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Impact of Not Hiring</label>
                            <textarea name="consequences_of_not_hiring" rows="2" class="form-control form-control-custom" required></textarea>
                            <div class="invalid-feedback">Enter the consequences of not hiring  </div>
                            
                        </div>
                        <hr>  
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-50">Submit</button>
                        </div>
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="multiDepartmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="multiDepartmentForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Departments</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body" id="deptFieldsContainer">
          <div class="input-group mb-2">
            <input type="text" name="departments[]" class="form-control" placeholder="Department Name" required>
            <button type="button" class="btn btn-success add-field">+</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Employee Levels -->

<div class="modal fade" id="multiEmployeeLevelModal" tabindex="-1" aria-labelledby="multiEmployeeLevelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="multiEmployeeLevelForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Employee Levels</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body" id="levelFieldsContainer">
          <div class="input-group mb-2">
            <input type="text" name="levels[]" class="form-control" placeholder="Employee Level Title" required>
            <button type="button" class="btn btn-success add-level-field">+</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Add Branch -->
 <div class="modal fade" id="multiBranchModal" tabindex="-1" aria-labelledby="multiBranchModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="multiBranchForm">
      @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Branches</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="branchFieldsContainer">
                <div class="input-group mb-2">
                    <input type="text" name="branches[]" class="form-control" placeholder="Branch Name" required>
                    <button type="button" class="btn btn-success add-branch-field">+</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {

    //  Bootstrap Form Validation 
    const form = document.getElementById('fteRequestForm');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);

    //  Experience Field Validation (Numeric only) 
    $('#experienceInput').on('input', function () {
        const value = $(this).val();
        const isValid = /^\d*\.?\d*$/.test(value);
        const errorDiv = $('#experienceError');

        if (!isValid) {
            $(this).addClass('is-invalid');
            errorDiv.show();
        } else {
            $(this).removeClass('is-invalid');
            errorDiv.hide();
        }
    });

    //  No Numbers in Text Fields 
    const textFields = [
        { id: '#educationInput', error: '#educationError' },
        { id: '#jobDetailInput', error: '#jobDetailError' },
        { id: '#locationInput', error: '#locationError' },
        { id: '#skillsInput', error: '#skillsError' },
        { id: '#languageInput', error: '#languageError' },
        { id: '#certificationsInput', error: '#certificationsError' }
    ];

    textFields.forEach(field => {
        $(field.id).on('input', function () {
            if (/\d/.test($(this).val())) {
                $(this).addClass('is-invalid');
                $(field.error).show();
            } else {
                $(this).removeClass('is-invalid');
                $(field.error).hide();
            }
        });
    });

    // Email Validation for Approval Levels
    function isEmailValid(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function getHighestLevelSelected() {
        for (let i = 3; i >= 1; i--) {
            if ($(`#approval_level_${i}`).is(':checked')) return i;
        }
        return 0;
    }

    form.addEventListener('submit', function (event) {
        let isValid = true;
        const highest = getHighestLevelSelected();

        for (let i = 1; i <= highest; i++) {
            ['manager_email_l' + i, 'hr_email_l' + i].forEach(id => {
                const field = $(`#${id}`);
                if (!isEmailValid(field.val())) {
                    field.addClass('is-invalid');
                    isValid = false;
                } else {
                    field.removeClass('is-invalid');
                }
            });
        }

        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    $('input[type="email"]').on('input', function () {
        if (isEmailValid($(this).val())) {
            $(this).removeClass('is-invalid');
        }
    });

    //  Toggle Replacing Employee Field 
    function toggleReplacingField() {
        let show = false;
        $('input[name="requisition_type[]"]:checked').each(function () {
            if ($(this).val() === 'Replacement') show = true;
        });

        const group = $('#replacing-employee-group');
        const input = group.find('input[name="replacing_employee"]');

        if (show) {
            group.show();
            input.prop('required', true);
        } else {
            group.hide();
            input.prop('required', false).val('');
        }
    }

    toggleReplacingField();
    $('input[name="requisition_type[]"]').on('change', toggleReplacingField);

    //  Show/Hide Approval Level Fields 
    $(document).ready(function () {
        $('.approval-checkbox').on('change', function () {
            // Get the selected level (1, 2, or 3)
            const selected = parseInt($('input[name="approval_level"]:checked').val());

            // Hide all level blocks
            $('.approval_level_l1, .approval_level_l2, .approval_level_l3').addClass('d-none');

            // Show levels up to selected
            for (let i = 1; i <= selected; i++) {
                $(`.approval_level_l${i}`).removeClass('d-none');
            }

            // Clear email fields ABOVE selected level
            for (let i = selected + 1; i <= 3; i++) {
                $(`#manager_email_l${i}`).val('');
                $(`#hr_email_l${i}`).val('');
            }
        });
    });


    //  Fetch Countries 
    fetch('https://restcountries.com/v3.1/all?fields=name')
        .then(res => res.json())
        .then(data => {
            const list = $('#countries');
            data.forEach(country => {
                list.append(`<option value="${country.name.common}">`);
            });
        });

    //  Fetch Currencies 
    fetch('https://restcountries.com/v3.1/all?fields=currencies')
        .then(res => res.json())
        .then(data => {
            const set = new Set();
            data.forEach(country => {
                const currencies = country.currencies;
                if (currencies) {
                    Object.entries(currencies).forEach(([code, details]) => {
                        set.add(`${details.name} (${code})`);
                    });
                }
            });

            const list = $('#currencies');
            Array.from(set).sort().forEach(currency => {
                list.append(`<option value="${currency}">`);
            });
        });

    //  Department Modal 
    $('#openAddDeptModal').on('click', () => $('#multiDepartmentModal').modal('show'));

    $(document).on('click', '.add-field', function () {
        $('#deptFieldsContainer').append(`
            <div class="input-group mb-2">
                <input type="text" name="departments[]" class="form-control" placeholder="Department Name" required>
                <button type="button" class="btn btn-danger remove-field">−</button>
            </div>
        `);
    });

    $(document).on('click', '.remove-field', function () {
        $(this).closest('.input-group').remove();
    });

    $('#multiDepartmentForm').submit(function (e) {
        e.preventDefault();
        $.post('/departments/batch', $(this).serialize(), function (res) {
            res.forEach(dept => $('#department_id').append(new Option(dept.name, dept.id)));
            $('#multiDepartmentModal').modal('hide');
            $('#deptFieldsContainer').html(`
                <div class="input-group mb-2">
                    <input type="text" name="departments[]" class="form-control" placeholder="Department Name" required>
                    <button type="button" class="btn btn-success add-field">+</button>
                </div>
            `);
            Swal.fire('Success!', 'Departments added successfully.', 'success');
        }).fail(() => {
            Swal.fire('Oops...', 'Something went wrong while saving.', 'error');
        });
    });

    //  Employee Level Modal 
    $('#openAddLevelModal').on('click', () => $('#multiEmployeeLevelModal').modal('show'));

    $(document).on('click', '.add-level-field', function () {
        $('#levelFieldsContainer').append(`
            <div class="input-group mb-2">
                <input type="text" name="levels[]" class="form-control" placeholder="Employee Level Title" required>
                <button type="button" class="btn btn-danger remove-level-field">−</button>
            </div>
        `);
    });

    $(document).on('click', '.remove-level-field', function () {
        $(this).closest('.input-group').remove();
    });

    $('#multiEmployeeLevelForm').submit(function (e) {
        e.preventDefault();
        $.post('/employee-levels', $(this).serialize(), function (res) {
            res.forEach(level => $('#employee_level').append(new Option(level.title, level.id)));
            $('#multiEmployeeLevelModal').modal('hide');
            $('#levelFieldsContainer').html(`
                <div class="input-group mb-2">
                    <input type="text" name="levels[]" class="form-control" placeholder="Employee Level Title" required>
                    <button type="button" class="btn btn-success add-level-field">+</button>
                </div>
            `);
            Swal.fire('Success!', 'Employee Levels added successfully.', 'success');
        }).fail(() => {
            Swal.fire('Oops...', 'Something went wrong while saving.', 'error');
        });
    });

    //  Branch Modal 
    $('#openAddBranchModal').on('click', () => $('#multiBranchModal').modal('show'));

    $(document).on('click', '.add-branch-field', function () {
        $('#branchFieldsContainer').append(`
            <div class="input-group mb-2">
                <input type="text" name="branches[]" class="form-control" placeholder="Branch Name" required>
                <button type="button" class="btn btn-danger remove-branch-field">−</button>
            </div>
        `);
    });

    $(document).on('click', '.remove-branch-field', function () {
        $(this).closest('.input-group').remove();
    });

    $('#multiBranchForm').submit(function (e) {
        e.preventDefault();
        $.post('/requesting-branches', $(this).serialize(), function (res) {
            res.forEach(branch => $('#branch_id').append(new Option(branch.name, branch.id)));
            $('#multiBranchModal').modal('hide');
            $('#branchFieldsContainer').html(`
                <div class="input-group mb-2">
                    <input type="text" name="branches[]" class="form-control" placeholder="Branch Name" required>
                    <button type="button" class="btn btn-success add-branch-field">+</button>
                </div>
            `);
            Swal.fire('Success!', 'Branches added successfully.', 'success');
        }).fail(() => {
            Swal.fire('Oops...', 'Something went wrong while saving branches.', 'error');
        });
    });

});
</script>
@endpush
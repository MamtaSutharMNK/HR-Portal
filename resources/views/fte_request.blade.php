@extends('layouts.authlayout')

@section('content')   
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            const forms = document.getElementsByClassName('needs-validation');
            Array.prototype.forEach.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    document.addEventListener('DOMContentLoaded', function () {
        const experienceInput = document.getElementById('experienceInput');
        const errorDiv = document.getElementById('experienceError');

        experienceInput.addEventListener('input', function () {
            const value = experienceInput.value;
            const isValid = /^\d*\.?\d*$/.test(value);

            if (!isValid) {
                experienceInput.classList.add('is-invalid');
                errorDiv.style.display = 'block';
            } else {
                experienceInput.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const textFields = [
            { inputId: 'educationInput', errorId: 'educationError' },
            { inputId: 'jobDetailInput', errorId: 'jobDetailError' },
            { inputId: 'locationInput', errorId: 'locationError' },
            { inputId: 'skillsInput', errorId: 'skillsError' },
            { inputId: 'languageInput', errorId: 'languageError' },
            { inputId: 'certificationsInput', errorId: 'certificationsError' }
        ];

        textFields.forEach(field => {
            const input = document.getElementById(field.inputId);
            const error = document.getElementById(field.errorId);

            input.addEventListener('input', function () {
                const value = input.value;
                const hasNumber = /\d/.test(value);

                if (hasNumber) {
                    input.classList.add('is-invalid');
                    error.style.display = 'block';
                } else {
                    input.classList.remove('is-invalid');
                    error.style.display = 'none';
                }
            });
        });
    });


</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header" style="color: black;">
                    <h2 class="text-center black-text">Full Time Employment Form</h2>
                </div>
                <div class="card-body" style=" padding: 0px 50px 50px 50px;">
                    @if(!session()->pull('hide_skip_once'))
                    <div class="mt-4" style="text-align: right;">
                        <p>Go to Dashboard!</p>
                        <a href="{{ route('index') }}" class="btn btn-primary">Dashboard</a>  
                    </div>
                    @endif  
                    <form method="POST" action="{{ route('fte_request.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <!-- Section 1 -->
                        <div class="mb-4">
                            <h5 class="text-primary fw-bold">1.Request Overview</h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Business Unit</label>
                                <div class="d-flex gap-2">
                                    <select name="department_id" id="department_id" class="form-control form-control-custom" required>
                                        <option value="">-- Select Department --</option>
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
                                <select name="branch_id" class="form-control form-control-custom" required>
                                    <option value="">Select Requesting Branch</option>
                                       @foreach($branches as $branch)
                                           <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                       @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a department</div>
                            </div>
     
                        </div> 
                        <div class="row mb-3">     
                            
                            <div class="col-md-6">
                                <label class="form-label-custom">Approving Manager Name</label>
                                 <input type="text" name="manager_name" class="form-control form-control-custom" required>
                                <div class="invalid-feedback">Enter the manager name.</div>
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label-custom">Approval Level</label>
                                    <select name="approval_level" class="form-control form-control-custom" required>
                                        <option value="">Select Approval level</option>
                                        @foreach (config('dropdown.approval_level') as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Select approval level</div>
                            </div>
                            
                        </div>
                        <div class="row mb-3">   
                            
                            <div class="col-md-6">
                                <label class="form-label-custom">Approving Manager Email</label>
                                <input type="email" id="l1" name="manager_email" class="form-control form-control-custom" required>
                                <div class="invalid-feedback">Enter a valid email.</div>
                                <div style="margin-left:5px">Note:This email should be official</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">HR EMAIL</label>
                                <input type="email" id="hr_email" name="hr_email" class="form-control form-control-custom" required>
                                <div class="invalid-feedback" id="jobsDetailError">Enter a valid email.</div>
                                <div style="margin-left:5px">Note:This email should be official</div>

                            </div>
                        </div>   
                        <div class="row mb-3">
                            <div class="col-md-6 L2">
                                <label class="form-label-custom">Local Head</label>
                                <input type="email" id="l2" name="level2_email" class="form-control form-control-custom">
                                <div class="invalid-feedback" id="jobsDetailError">Enter a valid email.</div>
                                <div style="margin-left:5px">Note:This email should be official</div>
                            </div>

                               <div class="col-md-6 L3">
                                <label class="form-label-custom">Global Head</label>
                                <input type="email" id="l3" name="level3_email" class="form-control form-control-custom" >
                                <div class="invalid-feedback" id="jobsDetailError">Enter a valid email.</div>
                                <div style="margin-left:5px">Note:This email should be official</div>
                            </div>

                        </div>
                        <hr>
                        <!-- Section 2: Position Details -->
                        <div class="mb-4">
                          <h5 class="text-primary fw-bold">2. Position Details</h5>
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
                            <div class="col-md-6 d-flex align-items-end">
                                <div style="width:90%">
                                    <label for="employee_level" class="form-label-custom">Employee Level</label>
                                    <select id="employee_level" name="employee_level" class="form-control form-control-custom" required>
                                        <option value="">-- Select Level --</option>
                                        @foreach($employeeLevels as $levels)
                                            <option value="{{ $levels->id }}">{{ $levels->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn-outline form-control form-control-custom ms-2" style="width: 50px;" data-bs-toggle="modal" data-bs-target="#multiEmployeeLevelModal" id="openAddLevelModal">+</button>
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
                                    <input type="number" step="0.1" name="ctc_start_range" placeholder="Start Range" class="form-control form-control-custom" style="width: 185px;" required>
                                    <span style="font-size: 20px; margin-left: 4px;">-</span>
                                    <input type="number" step="0.1" name="ctc_end_range" placeholder="End Range" class="form-control form-control-custom" style="width: 185px;" required>
                                </div>
                            </div>
                        </div>
                        <hr>    
                        <!-- Section3: Role Requirements -->
                        <div class="mb-4">
                          <h5 class="text-primary fw-bold">3. Role Requirements</h5>
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
                                <div class="invalid-feedback">Enter the job description </div>
                            </div>
                        </div>
                        <hr>    
                        <!-- Section4: Business Justification -->
                        <div class="mb-4">
                            <h5 class="text-primary fw-bold">4. Business Justification</h5>
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
                            <label class="form-label-custom">Consequences of Not Hiring</label>
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
        </div>
        <div class="modal-body" id="deptFieldsContainer">
          <div class="input-group mb-2">
            <input type="text" name="departments[]" class="form-control" placeholder="Department Name" required>
            <button type="button" class="btn btn-success add-field">+</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save All</button>
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
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Close</button> -->
        </div>
        <div class="modal-body" id="levelFieldsContainer">
          <div class="input-group mb-2">
            <input type="text" name="levels[]" class="form-control" placeholder="Employee Level Title" required>
            <button type="button" class="btn btn-success add-level-field">+</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Levels</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
    
    fetch('https://restcountries.com/v3.1/all?fields=name')
        .then(response => response.json())
        .then(data => {

          const datalist = document.getElementById("countries");
          data.forEach(country => {
            const option = document.createElement("option");
            option.value = country.name.common;
            datalist.appendChild(option);
          });
        })
        .catch(error => console.error("Error fetching countries:", error));


        fetch('https://restcountries.com/v3.1/all?fields=currencies')
        .then(response => response.json())
        .then(data => {
            const currencySet = new Set();
            data.forEach(country => {
            const currencies = country.currencies;
            if (currencies) {
                Object.entries(currencies).forEach(([code, details]) => {
                currencySet.add(`${details.name} (${code})`);
                });
            }
            });

            const datalist = document.getElementById("currencies");
            Array.from(currencySet).sort().forEach(currency => {
            const option = document.createElement("option");
            option.value = currency;
            datalist.appendChild(option);
            });
        })
        .catch(error => console.error("Error fetching currencies:", error));


        // Add departments into database
        $('#openAddDeptModal').on('click', function() {
        $('#multiDepartmentModal').modal('show');
        });

        $(document).on('click', '.add-field', function() {
        $('#deptFieldsContainer').append(`
            <div class="input-group mb-2">
            <input type="text" name="departments[]" class="form-control" placeholder="Department Name" required>
            <button type="button" class="btn btn-danger remove-field">−</button>
            </div>
        `);
        });

        $(document).on('click', '.remove-field', function() {
        $(this).closest('.input-group').remove();
        });


        $('#multiDepartmentForm').submit(function(e) {
            e.preventDefault();
            
            let formData = $(this).serialize();

            $.post('/departments/batch', formData, function(response) {
                response.forEach(function(dept) {
                let newOption = new Option(dept.name, dept.id);
                $('#department_id').append(newOption);
                });
                
                $('#multiDepartmentModal').modal('hide');
                $('#deptFieldsContainer').html(`
                <div class="input-group mb-2">
                    <input type="text" name="departments[]" class="form-control" placeholder="Department Name" required>
                    <button type="button" class="btn btn-success add-field">+</button>
                </div>
                `);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Departments added successfully.'
                });


            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong while saving.'
                });
            });
        });

        // Add Employee levels
        $('#openAddLevelModal').on('click', function() {
            $('#multiEmployeeLevelModal').modal('show');
        });

        
        $(document).on('click', '.add-level-field', function() {
            $('#levelFieldsContainer').append(`
                <div class="input-group mb-2">
                    <input type="text" name="levels[]" class="form-control" placeholder="Employee Level Title" required>
                    <button type="button" class="btn btn-danger remove-level-field">−</button>
                </div>
            `);
        });

        
        $(document).on('click', '.remove-level-field', function() {
            $(this).closest('.input-group').remove();
        });

        // Submit form
        $('#multiEmployeeLevelForm').submit(function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.post('employee-levels', formData, function(response) {
                response.forEach(function(level) {
                    let newOption = new Option(level.title, level.id);
                    $('#employee_level').append(newOption);
                });
                $('#multiEmployeeLevelModal').modal('hide');
                $('#levelFieldsContainer').html(`
                    <div class="input-group mb-2">
                        <input type="text" name="levels[]" class="form-control" placeholder="Employee Level Title" required>
                        <button type="button" class="btn btn-success add-level-field">+</button>
                    </div>
                `);
                 Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Employee Level added successfully.'
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong while saving.'
                });
            });
        });

    $(document).ready(function () {
            // Toggle Replacing Employee field
            function toggleReplacingField() {
                let showField = false;

                $('input[name="requisition_type[]"]:checked').each(function () {
                    if ($(this).val() === 'Replacement') {
                        showField = true;
                    }
                });

                const replacingGroup = $('#replacing-employee-group');
                const replacingInput = replacingGroup.find('input[name="replacing_employee"]');

                if (showField) {
                    replacingGroup.show();
                    replacingInput.prop('required', true);
                } else {
                    replacingInput.prop('required', false);
                    replacingGroup.hide();
                    replacingInput.val('');
                }
            }

            toggleReplacingField(); // Initial check on page load
            $('input[name="requisition_type[]"]').on('change', toggleReplacingField);
        });



    document.addEventListener('DOMContentLoaded', function () {
        const approvalLevel = document.querySelector('select[name="approval_level"]');
        const localHead = document.querySelector('.L2');
        const globalHead = document.querySelector('.L3');
        const l2Input = document.querySelector('input[name="level2_email"]');
        const l3Input = document.querySelector('input[name="level3_email"]');

        function toggleFields(value) {
            if (value === '2' || value === '3') {
                localHead.style.display = 'block';
                if (l2Input) l2Input.setAttribute('required', true);
            } else {
                localHead.style.display = 'none';
                if (l2Input) {
                    l2Input.removeAttribute('required');
                    l2Input.value = '';
                }
            }

            if (value === '3') {
                globalHead.style.display = 'block';
                if (l3Input) l3Input.setAttribute('required', true);
            } else {
                globalHead.style.display = 'none';
                if (l3Input) {
                    l3Input.removeAttribute('required');
                    l3Input.value = '';
                }
            }
        }

        // Run on dropdown change
        approvalLevel.addEventListener('change', function () {
            toggleFields(this.value);
        });

        // Initial run on page load
        toggleFields(approvalLevel.value);
    });




 
</script>

  



@endsection

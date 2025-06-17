@extends('layouts.authlayout')

@section('content')   
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
            const isValid = /^\d*\.?\d*$/.test(value); // Allows numbers and optional decimal

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
            { inputId: 'locationInput', errorId: 'locationError' },
            { inputId: 'skillsInput', errorId: 'skillsError' },
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
                    <div class="mt-4" style="text-align: right;">
                        <p>Do you want to skip?</p>
                        <a href="{{ route('index') }}" class="btn btn-primary">Skip</a>
                    </div>
                    <form method="POST" action="{{ route('fte_request.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <!-- Section 1 -->
                        <div class="mb-4">
                            <h5 class="text-primary fw-bold">1.Request Overview</h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Business Unit</label>
                                <select name="department_id" class="form-control form-control-custom" required>
                                    <option value="">Select Department</option>
                                       @foreach($departments as $department)
                                           <option value="{{ $department->id }}">{{ $department->name }}</option>
                                       @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a department</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Hiring Region / Country</label>
                                <select id="countrySelect" name="country_id" class="form-control form-control-custom" required>
                                    <option value="">Select Country</option>
                                       @foreach($countries as $code)
                                           <option value="{{ $code->id }}">{{ $code->name }}</option>
                                       @endforeach
                                </select>
                                <div class="invalid-feedback">Please select country</div>

                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Location Type</label>
                            @foreach (config('dropdown.location_type') as $key => $value)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="location_type[]" value="{{ $key }}" style="margin-left: 7px" >
                                    <label class="form-check-label">{{ $value }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Requested By</label>
                                <input type="text" name="requested_by" class="form-control form-control-custom" required>
                                <div class="invalid-feedback">Please enter a valid name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Approving Manager</label>
                                <select name="manager_id" class="form-control form-control-custom" required>
                                    <option value="">Select Manager</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a manager</div>
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
                                <input type="text" name="job_title" class="form-control form-control-custom" required>
                                <div class="invalid-feedback">Enter job title</div>
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
                                <label class="form-label-custom">Target Start Date</label>
                                <input type="date" name="target_start_date" class="form-control form-control-custom" required>
                                <div class="invalid-feedback">Enter a target date</div>

                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label class="form-label-custom">Department / Function</label>
                                <select id="jobrole" name="function_id" class="form-control form-control-custom" required>
                                    <option value="">Select Department Function</option>
                                         @foreach($jobroles as $jobrole)
                                        <option value="{{ $jobrole->id }}" data-band="{{ $jobrole->band }}">{{ $jobrole->function_title }}</option>
                                          @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a function</div>

                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Band</label>
                                <input type="text" name="band" id="band" class="form-control form-control-custom" value="{{$jobrole->band}}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label-custom">Budgeted Currency</label>
                                <select id="currencySelect" name="currency_id" class="form-control form-control-custom" required>
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                    @endforeach
                                </select>
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
                                <div class="invalid-feedback" id="skillsError">Enter key skills</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Languages Required</label>
                                <input type="text" id="" name="language_required" class="form-control form-control-custom" >
                                <div class="invalid-feedback" id="experinceError"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Certifications</label>
                                <input type="text" id="certificationsInput" name="certifications" class="form-control form-control-custom" >
                                <div class="invalid-feedback" id="certificationsError">Numberic not allowed</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Job Description</label>
                                <textarea name="job_description" rows="1" class="form-control form-control-custom" required></textarea>
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
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="requisition_type[]" value="{{ $key}}" style="margin-left: 7px" >
                                <label class="form-check-label">{{ $value}}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Replacing Employee</label>
                                <input type="text" name="replacing_employee" class="form-control form-control-custom" placeholder="Name (if replacement)">
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
                        <!--Section 5: Recruitment Details -->
                        <div class="mb-4">
                            <h5 class="text-primary fw-bold">5. Recruitment Details</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Recruitment Source</label>

                            @foreach (config('dropdown.recruitment_sources') as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="recruitment_source[]" value="{{$key}}" style="margin-left: 7px">
                                <label class="form-check-label">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom exclude">Preferred Nationality (if any)</label>
                                <input type="text" name="name" class="form-control form-control-custom" placeholder="Optional">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom exclude">Visa / Work Permit Required?</label>
                            @foreach (config('dropdown.visa_required') as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="work_permit" value="{{$key}}" style="margin-left: 7px">
                                <label class="form-check-label">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom exclude">Relocation Support Needed?</label>
                            @foreach (config('dropdown.relocation_support') as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="relocation_support" value="{{$key}}" style="margin-left: 7px">
                                <label class="form-check-label">{{$value}}</label>
                            </div>
                            @endforeach

                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-50">Submit</button>
                        </div>
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

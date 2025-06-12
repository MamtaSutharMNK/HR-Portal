@extends('layouts.authlayout')

@section('content')   

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header">
                    <h2 class="text-center black-text">Manpower Requisition Form</h2>
                </div>
            <div class="card-body">
                <form method="POST" action="#">
    <!-- Section 1 -->
     <h5 class="text-primary fw-bold">1.Request Overview</h5>
        <input type="hidden" name="step" value="1">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label-custom">Business Unit</label>
                <input type="text" name="name" class="form-control form-control-custom">
            </div>
      <div class="col-md-6">
        <label class="form-label-custom">Hiring Region / Country</label>
        <input type="text" name="name" class="form-control form-control-custom">
      </div>
    </div>
    <div class="mb-3">
        <label class="form-label-custom">Location Type</label><br>

        @foreach (config('dropdown.location_type') as $key => $value)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="location_type" value="{{ $key }}" {{ old('location_type') == $key ? 'checked' : '' }}>
                <label class="form-check-label">{{ $value }}</label>
            </div>
        @endforeach
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label-custom">Requested By</label>
        <input type="text" name="requested_by" class="form-control form-control-custom">
      </div>
      <div class="col-md-6">
        <label class="form-label-custom">Approving Manager</label>
        <input type="text" name="approving_manager" class="form-control form-control-custom">
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
    <input type="text" name="job_title" class="form-control form-control-custom" >
  </div>
  <div class="col-md-6">
    <label class="form-label-custom">Number of Positions</label>
    <input type="number" name="no_of_positions" class="form-control form-control-custom" >
  </div>
</div>

<div class="mb-3">
    <label class="form-label-custom">Type of Employment</label><br>

    @foreach (config('dropdown.type_of_employment') as $key => $value)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="type_of_employment" value="{{ $key }}" {{ old('type_of_employment') == $key ? 'checked' : '' }}>
            <label class="form-check-label">{{ $value }}</label>
        </div>
    @endforeach
</div>

<div class="mb-3">
  <label class="form-label-custom">Employment Category</label><br>
   @foreach (config('dropdown.employment_categories') as $key => $value)
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="checkbox" name="employment_category" value="{{ $key }}" {{ old('employment_category') == $key ? 'checked' : '' }}>
    <label class="form-check-label">{{ $value }}</label>
  </div>
  @endforeach
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label-custom">Work Location</label>
    <input type="text" name="work_location" class="form-control form-control-custom" >
  </div>
  <div class="col-md-6">
    <label class="form-label-custom">Department / Function</label>
    <input type="text" name="function_id" class="form-control form-control-custom" >
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label-custom">Target Start Date</label>
    <input type="date" name="target_start_date" class="form-control form-control-custom">
  </div>
  <div class="col-md-3">
    <label class="form-label-custom">Band</label>
    <input type="text" name="band" class="form-control form-control-custom" >
  </div>
  <div class="col-md-3">
    <label class="form-label-custom">Budgeted CTC / Range</label>
    <input type="text" name="budget_ctc" class="form-control form-control-custom" >
  </div>
</div>
<hr>
<!-- Section 3: Role Requirements -->
<div class="mb-4">
  <h5 class="text-primary fw-bold">3. Role Requirements</h5>
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label-custom">Education</label>
    <input type="text" name="education" class="form-control form-control-custom" >
  </div>
  <div class="col-md-6">
    <label class="form-label-custom">Experience</label>
    <input type="text" name="experience" class="form-control form-control-custom" >
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label-custom">Key Skills</label>
    <input type="text" name="key_skills" class="form-control form-control-custom" >
  </div>
  <div class="col-md-6">
    <label class="form-label-custom">Languages Required</label>
    <input type="text" name="language_required" class="form-control form-control-custom" >
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label-custom">Certifications</label>
    <input type="text" name="certifications" class="form-control form-control-custom" >
  </div>
  <div class="col-md-6">
    <label class="form-label-custom">Job Description</label>
    <textarea name="job_description" rows="4" class="form-control form-control-custom" ></textarea>
  </div>
</div>
<hr>
<!-- Section 4: Business Justification -->
<div class="mb-4">
  <h5 class="text-primary fw-bold">4. Business Justification</h5>
</div>

<div class="mb-3">
  <label class="form-label-custom">Requisition Type</label><br>
     @foreach (config('dropdown.requisition_types') as $key => $value)
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="requisition_type" value="{{ $key}}"  {{ old('requisition_type') == $key ? 'checked' : '' }}>
        <label class="form-check-label">{{ $value}}</label>
    </div>
    @endforeach
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label-custom">Replacing Employee</label>
    <input type="text" name="replacing_employee" class="form-control form-control-custom" placeholder="Name (if replacement)">
  </div>
</div>

<div class="mb-3">
  <label class="form-label-custom">Justification Details</label>
  <textarea name="justification_details" rows="4" class="form-control form-control-custom" placeholder="Explain the reason for the requisition"></textarea>
</div>

<div class="mb-3">
  <label class="form-label-custom">Consequences of Not Hiring</label>
  <textarea name="consequences_of_not_hiring" rows="4" class="form-control form-control-custom" ></textarea>
</div>
<hr>
<!-- Section 5: Recruitment Details -->
<div class="mb-4">
  <h5 class="text-primary fw-bold">5. Recruitment Details</h5>
</div>

<div class="mb-3">
  <label class="form-label-custom">Recruitment Source</label><br>

  @foreach (config('dropdown.recruitment_sources') as $key => $value)
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="checkbox" name="recruitment_source" value="{{$key}}" {{ old('recruitment_source') == $key ? 'checked' : '' }}>
    <label class="form-check-label">{{$value}}</label>
  </div>
  @endforeach
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label-custom">Preferred Nationality (if any)</label>
    <input type="text" name="name" class="form-control form-control-custom" placeholder="Optional">
  </div>
</div>

<div class="mb-3">
  <label class="form-label-custom">Visa / Work Permit Required?</label><br>
  @foreach (config('dropdown.visa_required') as $key => $value)
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="work_permit" value="{{$key}}" {{ old('work_permit') == $key ? 'checked' : '' }}>
    <label class="form-check-label">{{$value}}</label>
  </div>
  @endforeach
</div>

<div class="mb-3">
    <label class="form-label-custom">Relocation Support Needed?</label><br>
    @foreach (config('dropdown.relocation_support') as $key => $value)
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="relocation_support" value="{{$key}}" {{ old('relocation_support') == $key ? 'checked' : '' }}>
        <label class="form-check-label">{{$value}}</label>
  </div>
  @endforeach

</div>
    <!-- Add similar rows for Position Details, Role Requirements, etc. -->

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    <hr>
     <div class="text-center mt-4">
        <p>Do you want to skip and go to dashboard?</p>
        <a href="{{ route('index') }}" class="btn btn-primary">Skip</a>
    </div>
  </form>
</div>
</div>
    </div>
    </div>
    </div>
</div> 
@endsection


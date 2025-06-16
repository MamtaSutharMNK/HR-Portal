<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForm;
use App\Models\JobDetail;
use Carbon\Carbon;
use Exception;
use Ramsey\Uuid\Uuid;



class RequestFormController extends Controller
{
    
    public function store(Request $request)
{
// dd($request->all());
    try {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'education' => 'required|string',
            'key_skills' => 'nullable|string',
            'certifications' => 'nullable|string',
            'job_description' => 'nullable|string',
            'language_required' => 'nullable|string',
            'experience' => 'nullable|integer',

            // Foreign key fields
            'manager_id' => 'required|exists:managers,id',
            'country_id' => 'required|exists:countries,id',
            'function_id' => 'required|exists:job_roles,id',
            'department_id' => 'required|exists:departments,id',
            'currency_id' => 'nullable|exists:currencies,id',

            // Other fields
            'requested_by' => 'required|string',
            'date_of_request' => 'nullable|date',
            'location_type' => 'nullable|array', 
            'location_type.*' => 'string',
            'no_of_positions' => 'required|integer',
            'type_of_employment' => 'nullable|array',
            'type_of_employment.*' => 'string',
            'employment_category' => 'nullable|array',
            'employment_category.*' => 'string',
            'requisition_type' => 'nullable|array',
            'requisition_type.*' => 'string',
            'recruitment_source' => 'nullable|array',
            'recruitment_source.*' => 'string',
            'work_permit' => 'nullable|string',
            'relocation_support' => 'nullable|string',
            'work_location' => 'nullable|string',
            'target_start_date' => 'nullable|date',
            'ctc_type' => 'required|string',
            'ctc_start_range' => 'required|numeric',
            'ctc_end_range' => 'required|numeric',
            'justification_details' => 'nullable|string',
            'replacing_employee' => 'nullable|string',
            'consequences_of_not_hiring' => 'nullable|string',
        ]);
     

        $dateOfRequest = $validated['date_of_request'] ?? now();
        $requestUuid =  substr(Uuid::uuid4()->toString(), 0, 7);
    
        $requestData = RequestForm::create([
            'request_uuid' => $requestUuid,
            'date_of_request' => $dateOfRequest,
            'requested_by' => $validated['requested_by'],
            'manager_id' => $validated['manager_id'],
            'country_id' => $validated['country_id'],
            'function_id' => $validated['function_id'],
            'department_id' => $validated['department_id'],
            'currency_id' => $validated['currency_id'] ?? null,
            'location_type' => isset($validated['location_type']) ? implode(',', $validated['location_type']) : null,
            'no_of_positions' => $validated['no_of_positions'],
            'type_of_employment' => isset($validated['type_of_employment']) ? implode(',', $validated['type_of_employment']) : null,
            'employment_category' => isset($validated['employment_category']) ? implode(',', $validated['employment_category']) : null,
            'requisition_type' => isset($validated['requisition_type']) ? implode(',', $validated['requisition_type']) : null,
            'recruitment_source' => isset($validated['recruitment_source']) ? implode(',', $validated['recruitment_source']) : null,
            'work_permit' => $validated['work_permit'] ?? null,
            'relocation_support' => $validated['relocation_support'] ?? null,
            'work_location' => $validated['work_location'] ?? null,
            'target_start_date' => $validated['target_start_date'] ?? null,
            'ctc_type' => $validated['ctc_type'],
            'ctc_start_range' => $validated['ctc_start_range'],
            'ctc_end_range' => $validated['ctc_end_range'],
            'justification_details' => $validated['justification_details'] ?? null,
            'replacing_employee' => $validated['replacing_employee'] ?? null,
            'consequences_of_not_hiring' => $validated['consequences_of_not_hiring'] ?? null,
          
        ]);
          
              
        $jobDetail = JobDetail::create([
            'fte_request_id' => $requestData->id,
            'job_title' => $validated['job_title'],
            'education' => $validated['education'] ?? null,
            'key_skills' => $validated['key_skills'] ?? null,
            'certifications' => $validated['certifications'] ?? null,
            'job_description' => $validated['job_description'] ?? null,
            'language_required' => $validated['language_required'] ?? null,
            'experience' => $validated['experience'] ?? null,
        ]);

        return redirect()->route('index')->with('success', 'Form submitted successfully.');
    } catch (Exception $e) {
        // return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        dd($e->getMessage());
    }
}
}


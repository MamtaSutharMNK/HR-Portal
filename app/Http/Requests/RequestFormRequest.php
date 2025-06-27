<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'department_id' => 'nullable|integer',
        'branch_id' => 'nullable|integer',
        'country' => 'required|string|max:100',
        'requested_by' => 'required|string|max:255',
        'approval_level' => 'required|integer',
        'manager_name' => 'required|string|max:255',
        'manager_email' => 'required|email',
        'hr_email' => 'required|email',
        'level2_email' => 'nullable|email',
        'level3_email' => 'nullable|email',
        'no_of_positions' => 'required|integer|min:1',
        'type_of_employment' => 'nullable|array',
        'type_of_employment.*' => 'string',
        'employment_category' => 'nullable|array',
        'employment_category.*' => 'string',
        'work_location' => 'nullable|string|max:255',
        'target_by_when' => 'nullable|date',
        'department_function' => 'required|string',
        'employee_level' => 'required|string',
        'currency' => 'required|string|max:50',
        'ctc_type' => 'required|string',
        'ctc_start_range' => 'required|numeric|min:0',
        'ctc_end_range' => 'required|numeric|gte:ctc_start_range',
        'experience' => 'nullable|numeric|min:0',
        'requisition_type' => 'nullable|array',
        'requisition_type.*' => 'string',
        'justification_details' => 'nullable|string',
        'replacing_employee' => 'nullable|string',
        'consequences_of_not_hiring' => 'nullable|string',
        'job_title' => 'required|string|max:255',
        'education' => 'nullable|string',
        'key_skills' => 'nullable|string',
        'certifications' => 'nullable|string',
        'job_description' => 'nullable|string',
        'language_required' => 'nullable|string',
        ];
    }
}

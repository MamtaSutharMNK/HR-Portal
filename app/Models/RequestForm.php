<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
  
    protected $fillable = [
        'request_uuid',
        'manager_id',
        'country_id',
        'department_id',
        'function_id',
        'currency_id',
        'requested_by',
        'date_of_request',
        'location_type',
        'no_of_positions',
        'type_of_employment',
        'employment_category',
        'requisition_type',
        'recruitment_source',
        'work_permit',
        'relocation_support',
        'work_location',
        'target_start_date',
        'ctc_type',
        'ctc_start_range',
        'ctc_end_range',
        'experience',
        'justification_details',
        'replacing_employee',
        'consequences_of_not_hiring'
        
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class,'manager_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function jobRole()
    {
        return $this->belongsTo(JobRole::class, 'function_id');
    }
    
    public function jobDetail()
    {
        return $this->belongsTo(JobDetail::class, 'job_detail_id');
    }

// Accessors to convert comma-separated values into arrays when retrieving

    public function getLocationTypeAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function getTypeOfEmploymentAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function getEmploymentCategoryAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function getRequisitionTypeAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function getRecruitmentSourceAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    // Mutators to convert arrays into comma-separated values before storing
    public function setLocationTypeAttribute($value)
    {
        $this->attributes['location_type'] = is_array($value) ? implode(',', $value) : null;
    }

    public function setTypeOfEmploymentAttribute($value)
    {
        $this->attributes['type_of_employment'] = is_array($value) ? implode(',', $value) : null;
    }

    public function setEmploymentCategoryAttribute($value)
    {
        $this->attributes['employment_category'] = is_array($value) ? implode(',', $value) : null;
    }

    public function setRequisitionTypeAttribute($value)
    {
        $this->attributes['requisition_type'] = is_array($value) ? implode(',', $value) : null;
    }

    public function setRecruitmentSourceAttribute($value)
    {
        $this->attributes['recruitment_source'] = is_array($value) ? implode(',', $value) : null;
    }

}
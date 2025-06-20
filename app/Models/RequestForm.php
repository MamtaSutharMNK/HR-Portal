<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RequestForm extends Model
{
  
    const Active = 1; 
    const InActive = 0; 

    const MAIL_PENDING = 0; 
    const CFO_Mail_APPROVAL = 1; 
    const CFO_Mail_REJECT = 2; 
    const CTO_Mail_APPROVAL = 3; 
    const CTO_Mail_REJECT = 4; 
    const HR_Mail_APPROVAL = 5;
    const HR_Mail_REJECT = 6;

    protected $fillable = [
        'user_id',
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
    public function job_roles()
    {
        return $this->belongsTo(JobRole::class, 'function_id'); 
    }

    
    public function jobDetail()
    {
        return $this->hasOne(JobDetail::class, 'fte_request_id');
    }

}
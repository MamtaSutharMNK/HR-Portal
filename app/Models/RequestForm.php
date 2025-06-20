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
        'date_of_request',
        'department_id',
        'branch_id',
        'country',
        'requested_by',
        'manager_name',
        'manager_email',
        'no_of_positions',
        'type_of_employment',
        'employment_category',
        'work_location',
        'target_by_when',
        'department_function',
        'employee_level',
        'currency',
        'ctc_type',
        'ctc_start_range',
        'ctc_end_range',
        'experience',
        'requisition_type',
        'justification_details',
        'replacing_employee',
        'consequences_of_not_hiring',
        'status',
        'mail_status',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function requestingBranch()
    {
        return $this->belongsTo(RequestingBranch::class);
    }

    public function jobDetail()
    {
        return $this->hasOne(JobDetail::class, 'fte_request_id');
    }

}
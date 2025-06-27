<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RequestForm extends Model
{

    const MAIL_PENDING = 0; 
    const MANAGER_MAIL_APPROVAL = 1; 
    const MANAGER_MAIL_REJECT = 2; 
    const LEVEL2_MAIL_APPROVAL = 3; 
    const LEVEL2_MAIL_REJECT = 4; 
    const LEVEL3_MAIL_APPROVAL = 5; 
    const LEVEL3_MAIL_REJECT = 6; 
    const HR_MAIL_APPROVAL = 7;
    const HR_MAIL_REJECT = 8;

    const TO_DO = 1; 
    const IN_PROGRESS = 2; 
    const DONE = 3;
    const CLOSED = 4;
    const EXPIRED = 5;

    public const EMAIL_STATUS_LABELS = [
    0 => 'Mail Pending',
    1 => 'Manager Approved',
    2 => 'Manager Rejected',
    3 => 'Level 2 Approved',
    4 => 'Level 2 Rejected',
    5 => 'Level 3 Approved',
    6 => 'Level 3 Rejected',
    7 => 'HR Approved',
    8 => 'HR Rejected',
];


    protected $fillable = [
        'user_id',
        'request_uuid',
        'date_of_request',
        'department_id',
        'branch_id',
        'country',
        'requested_by',
        'approval_level',
        'manager_name',
        'manager_email',
        'hr_email',
        'level2_email',
        'level3_email',
        'no_of_positions',
        'position_filled',
        'type_of_employment',
        'employment_category',
        'work_location',
        'target_by_when',
        'department_function',
        'employee_level_id',
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
        'reason',
        'mail_status',
        
    ];

    public const STATUS_BY_MAIL_ID = [
        '0' => 'MAIL PENDING',
        '1' => 'MANAGER APPROVED',
        '2' => 'MANAGER REJECTED',
        '3' => 'LEVEL2 APPROVED',
        '4' => 'LEVEL2 REJECTED',
        '5' => 'LEVEL3 APPROVED',
        '6' => 'LEVEL3 REJECTED',
        '7' => 'HR APPROVED',
        '8' => 'HR REJECTED'
    ];

    public const STATUS_BY_ID = [
        '1' => 'TO DO',
        '2' => 'IN PROGRESS',
        '3' => 'DONE ',
        '4' => 'CLOSED ',
        '5' => 'EXPIRED',
    ];

    public const STATUS_COLORS = [
        '1' => 'primary',
        '2' => 'primary',
        '3' => 'success ',
        '4' => 'warning ',
        '5' => 'danger',
    ];

     public const MAIL_STATUS_COLORS = [
        '0' => 'primary',
        '1' => 'success',
        '2' => 'danger',
        '3' => 'success',
        '4' => 'danger',
        '5' => 'success',
        '6' => 'danger',
        '7' => 'success',
        '8' => 'danger'
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
        return $this->belongsTo(RequestingBranch::class,'branch_id');
    }

    public function jobDetail()
    {
        return $this->hasOne(JobDetail::class, 'fte_request_id','request_uuid');
    }

    public function employeeLevel()
    {
        return $this->belongsTo(EmployeeLevel::class,'employee_level_id');
    }

    public function actionLog()
    {
        return $this->hasMany(ActionLog::class, 'fte_request_id');
    }
}
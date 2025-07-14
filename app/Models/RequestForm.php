<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RequestForm extends Model
{

    const MAIL_PENDING = 0; 
    const LEVEL1_MAIL_APPROVAL = 1; 
    const LEVEL1_MAIL_REJECT = 2; 
    const LEVEL2_MAIL_APPROVAL = 3; 
    const LEVEL2_MAIL_REJECT = 4; 
    const LEVEL3_MAIL_APPROVAL = 5; 
    const LEVEL3_MAIL_REJECT = 6; 
    const HR_MAIL_APPROVAL = 7;
    const HR_MAIL_REJECT = 8;

    const IN_PROGRESS = 1;
    const CLOSED = 2;
    const IN_SEARCH = 3;
    const DONE = 4;
    const SCREENING = 5;
    const INTERVIEWING = 6;
    const HIRING = 7;

    public const EMAIL_STATUS_LABELS = [
    0 => 'Mail Pending',
    1 => 'LEVEL 1 Approved',
    2 => 'LEVEL 1 Rejected',
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
        'manager_email_l1',
        'hr_email_l1',
        'manager_email_l2',
        'hr_email_l2',
        'manager_email_l3',
        'hr_email_l3',
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
        '0' => 'LEVEL 1 MAIL PENDING',
        '1' => 'LEVEL 1 APPROVED',
        '2' => 'LEVEL 1 REJECTED',
        '3' => 'LEVEL 2 APPROVED',
        '4' => 'LEVEL 2 REJECTED',
        '5' => 'LEVEL 3 APPROVED',
        '6' => 'LEVEL 3 REJECTED',
        '7' => 'HR APPROVED',
        '8' => 'HR REJECTED'
    ];

    public const STATUS_BY_ID = [
        '1' => 'IN PROGRESS',
        '2' => 'CLOSED',
        '3' => 'IN SEARCH',
        '4' => 'DONE',
        '5' => 'SCREENING',
        '6' => 'INTERVIEWING',
        '7' => 'HIRING',

    ];

    public const STATUS_COLORS = [
        '1' => 'primary',
        '2' => 'success ',
        '3' => 'primary',
        '4' => 'success',
        '5' => 'info',
        '6' => 'primary',
        '7' => 'primary'
    ];

     public const MAIL_STATUS_COLORS = [
        '0' => 'primary',
        '1' => 'success',
        '2' => 'danger',
        '3' => 'success',
        '4' => 'danger',
        '5' => 'success',
        '6' => 'success',
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
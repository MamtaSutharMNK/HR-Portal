<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    protected $fillable = [
        'manager_id',
        'country_id',
        'department_id',        
        'function_id',
        'currency_id',
        'job_detail_id',
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
        'experience',
        'justification_details',
        'replacing_employee',
        'consequences_of_not_hiring',
        
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

    public function functionModel()
    {
        return $this->belongsTo(FunctionModel::class, 'function_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function jobDetail()
    {
        return $this->belongsTo(JobDetail::class, 'job_detail_id');
    }
}
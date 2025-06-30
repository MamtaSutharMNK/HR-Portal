<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    protected $fillable = [
        'fte_request_id',
        'job_title',
        'education',
        'key_skills',
        'certifications',
        'job_description',
        'language_required',
        'experience',
        
    ];

    public function requestForms()
    {
        // return $this->hasMany(RequestForm::class, 'job_detail_id');
        return $this->belongsTo(RequestForm::class, 'fte_request_id','request_uuid');

    }
}

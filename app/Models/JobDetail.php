<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    protected $fillable = [
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
        return $this->hasMany(RequestForm::class, 'job_detail_id');
    }
}

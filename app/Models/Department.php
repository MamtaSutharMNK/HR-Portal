<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Department extends Model
{
    use HasFactory;

    public function functionModel(){
        return $this->belongsTo(JobRole::class, 'function_id');
    }

    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'department_id');
    }

}

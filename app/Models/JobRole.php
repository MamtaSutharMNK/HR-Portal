<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'function_id');
    }

}

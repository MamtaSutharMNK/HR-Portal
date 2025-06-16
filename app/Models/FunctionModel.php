<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionModel extends Model
{
    protected $table = 'functions';

    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'function_id');
    }
}

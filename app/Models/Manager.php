<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manager extends Model
{
    use HasFactory;
    
    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'manager_id');
    }

}

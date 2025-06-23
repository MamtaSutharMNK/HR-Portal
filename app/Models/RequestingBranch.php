<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RequestingBranch extends Model
{
    use hasFactory;
    
    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'branch_id');
    }
}

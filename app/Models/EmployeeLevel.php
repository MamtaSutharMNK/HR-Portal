<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class EmployeeLevel extends Model
{
    use HasFactory;
    protected $fillable = ['title'];

    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'employee_level_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Currency extends Model
{
    use HasFactory;
    protected $table = 'currencies';

    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'currency_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    public function requestForms()
    {
        return $this->hasMany(RequestForm::class, 'country_id');
    }
    
}

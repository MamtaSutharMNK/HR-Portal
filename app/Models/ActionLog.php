<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActionLog extends Model
{


    protected $fillable = ['fte_request_id','action_by','reason','description'];

    public function user()
    {
        return $this->belongsTo(User::class,'action_by');
    }

}

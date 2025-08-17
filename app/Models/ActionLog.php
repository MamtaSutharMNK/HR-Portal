<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\RequestForm;


class ActionLog extends Model
{


    protected $fillable = ['fte_request_id','action_by','reason','description','status'];

    public function user()
    {
        return $this->belongsTo(User::class,'action_by');
    }

    public function requestForm()
    {
        return $this->belongsTo(RequestForm::class,'fte_request_id');
    }

      public function getStatusLabelAttribute()
    {
        return RequestForm::STATUS_BY_ID[$this->status] ?? 'UNKNOWN';
    }


}

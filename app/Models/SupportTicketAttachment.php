<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicketAttachment extends Model
{
     use HasFactory;

    protected $fillable = [
        'support_ticket_id',
        'file_path',
        'original_name',
        'file_size',
        'mime_type'
    ];


    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }
}

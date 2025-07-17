<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\IssueCategory;
use App\Models\IssueType;
use App\Models\SupportTicketAttachment;
use App\Models\Department;
use App\Models\User;

class SupportTicket extends Model
{
    use hasFactory;
    protected $fillable = [
    'uuid',
    'ticket_no',
    'department_id',
    'description',
    'status',
    'user_id',
    'issue_category_id',  
    'issue_type_id',     
    'temp_issue_cat',
    'temp_issue_type',
    'reason'
    ];

    public function attachments() {
        return $this->hasMany(SupportTicketAttachment::class);
    }

    public function category() {
        return $this->belongsTo(IssueCategory::class, 'issue_cat_id');
    }

    public function type() {
        return $this->belongsTo(IssueType::class, 'issue_type_id');
    } 
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function issueCategory()
    {
        return $this->belongsTo(IssueCategory::class, 'issue_category_id');
    }

    public function issueType()
    {
        return $this->belongsTo(IssueType::class, 'issue_type_id');
    }

}

<?php 
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\PendingTicketReminderMail;
use App\Models\SupportTicket;

class SendPendingTicketReminders extends Command
{
    protected $signature = 'tickets:send-reminders';
    protected $description = 'Send reminder emails for pending tickets older than 48 hours';

    public function handle()
    {
        $cutoff = now()->subHours(48);
        
        $tickets = SupportTicket::where('status', '1')
        ->where(function ($query) {
            $query->whereNull('reminder_sent_at')
                ->orWhere('reminder_sent_at', '<=', now()->subHours(48)); 
        })
        ->where('created_at', '<=', $cutoff)
        ->with('department')
        ->get();

        $departmentEmails = [
            '1' => env('ADMIN_SUPPORT_EMAIL'),
            '2' => env('HR_SUPPORT_EMAIL'),
            '3' => env('IT_SUPPORT_EMAIL'),
        ];

        foreach ($tickets as $ticket) {
            $recipientEmail = $departmentEmails[$ticket->department_id] ?? env('DEFAULT_DEPARTMENT_EMAIL');
            Mail::to($recipientEmail)->send(new PendingTicketReminderMail($ticket));

            $ticket->update(['reminder_sent_at' => now()]);
        }

        $this->info("Reminder emails sent: {$tickets->count()}");
    }
}
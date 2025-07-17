<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingTicketReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->subject('Reminder: Pending Ticket')
                    ->markdown('emails.pending_ticket_reminder')
                    ->with(['ticket' => $this->ticket]);
    }
}
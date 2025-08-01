<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
                    ->with([
                        'ticket' => $this->ticket,
                        'url' => route('support_tickets.show', $this->ticket->id)]);
    }
}
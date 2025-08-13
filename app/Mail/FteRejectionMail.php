<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FteRejectionMail extends Mailable
{
    use Queueable, SerializesModels;
    public string $firstName;
    /**
     * Create a new message instance.
     */
    public function __construct(public $requestForm,  public $toEmail)
    {
        $localPart = explode('@', $toEmail)[0];
        preg_match('/^[a-zA-Z]+/', $localPart, $matches);
        $this->firstName = ucfirst($matches[0] ?? 'User');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'FTE Rejection Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
         return new Content(
            markdown: 'emails.mail_rejection',
             with: [
                'firstName' => $this->firstName,
                'data' => $this->requestForm
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

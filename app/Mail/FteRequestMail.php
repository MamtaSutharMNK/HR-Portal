<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FteRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public string $firstName;
    /**
     * Create a new message instance.
     */
    public function __construct(public $requestData, public $toEmail)
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
            subject: 'FTE Request Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.fte_requestMail',
             with: [
                'data' => $this->requestData,
                'firstName' => $this->firstName,
                'url' => route('fte_request.show', $this->requestData->id),
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

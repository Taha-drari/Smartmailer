<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template->subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.campaign',
            with: ['body' => $this->template->body]
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

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;
use App\Models\EmailListEntry;

class CampaignEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $entry;

    public function __construct(Campaign $campaign, EmailListEntry $entry)
    {
        $this->campaign = $campaign;
        $this->entry = $entry;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->campaign->subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.campaign',
            with: [
                'campaign' => $this->campaign,
                'body' => $this->campaign->template->body,
                'email' => $this->entry->email
            ]
        );
    }
} 
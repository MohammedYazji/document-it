<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class WeeklyPostsSummary extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Collection $posts)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weekly Posts Summary',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.weekly-posts-summary',
            with: ['posts' => $this->posts],
        );
    }
}

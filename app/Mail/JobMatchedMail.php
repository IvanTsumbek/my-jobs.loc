<?php

namespace App\Mail;

use App\Models\JobListing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobMatchedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobListing $job) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New job match: ' . $this->job->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job-matched',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
<?php

namespace App\Jobs;

use App\Mail\JobMatchedMail;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public User $user,
        public JobListing $jobListing
    ) {}
    
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new JobMatchedMail($this->jobListing));
    }
}
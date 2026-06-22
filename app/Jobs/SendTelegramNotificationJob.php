<?php

namespace App\Jobs;

use App\Models\JobListing;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendTelegramNotificationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public JobListing $jobListing
    ) {}

    public function handle(TelegramService $telegramService): void
    {
        $message = "🆕 <b>New job match!</b>\n\n"
            . "<b>Position:</b> {$this->jobListing->title}\n"
            . "<b>Company:</b> {$this->jobListing->company}\n"
            . "<b>Location:</b> {$this->jobListing->location}\n"
            . "<a href='{$this->jobListing->url}'>View Job</a>";

        $telegramService->sendMessage($this->user->telegram_chat_id, $message);
    }
}

<?php

namespace App\Jobs;

use App\Models\JobListing;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendTelegramNotificationJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public User $user,
        public JobListing $jobListing
    ) {}

    public function handle(TelegramService $telegramService): void
    {
        Log::info('SendTelegramNotificationJob started', [
            'user_id' => $this->user->id,
            'job_id'  => $this->jobListing->id,
        ]);

        $message = "🆕 <b>New job match!</b>\n\n"
            . "<b>Position:</b> {$this->jobListing->title}\n"
            . "<b>Company:</b> {$this->jobListing->company}\n"
            . "<b>Location:</b> {$this->jobListing->location}\n"
            . "<a href='{$this->jobListing->url}'>View Job</a>";

        $telegramService->sendMessage($this->user->telegram_chat_id, $message);
    
        Log::info('SendTelegramNotificationJob completed', [
            'user_id'     => $this->user->id,
            'telegram_id' => $this->user->telegram_chat_id,
        ]);
    }
}

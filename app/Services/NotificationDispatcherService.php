<?php

namespace App\Services;

use App\Jobs\SendEmailNotificationJob;
use App\Jobs\SendTelegramNotificationJob;
use App\Models\JobListing;
use App\Models\User;

class NotificationDispatcherService
{
    public function dispatch(User $user, JobListing $job): void
    {
        if ($user->email) {
            SendEmailNotificationJob::dispatch($user, $job);
        }

        if ($user->telegram_chat_id) {
            SendTelegramNotificationJob::dispatch($user, $job);
        }
    }
}
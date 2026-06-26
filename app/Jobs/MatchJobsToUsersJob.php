<?php

namespace App\Jobs;

use App\Models\JobListing;
use App\Models\JobMatch;
use App\Models\UserPreference;
use App\Services\JobMatchingService;
use App\Services\NotificationDispatcherService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MatchJobsToUsersJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(JobMatchingService $matchingService, NotificationDispatcherService $notificationDispatcher): void
    {
        $preferences = UserPreference::where('is_active', true)->get();

        JobListing::chunk(100, function ($jobs) use ($preferences, $matchingService, $notificationDispatcher) {
            foreach ($preferences as $preference) {
                foreach ($jobs as $job) {
                    if ($matchingService->matches($job, $preference)) {
                        $match = JobMatch::firstOrCreate([
                            'user_id'        => $preference->user_id,
                            'job_listing_id' => $job->id,
                        ]);

                        if ($match->wasRecentlyCreated) {
                            $notificationDispatcher->dispatch($preference->user, $job);
                        }
                    }
                }
            }
        });
    }
}

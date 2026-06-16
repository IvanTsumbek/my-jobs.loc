<?php

namespace App\Jobs;

use App\Models\JobListing;
use App\Models\JobMatch;
use App\Models\UserPreference;
use App\Services\JobMatchingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MatchJobsToUsersJob implements ShouldQueue
{
    use Queueable;

    public function handle(JobMatchingService $matchingService): void
    {
        $preferences = UserPreference::where('is_active', true)->get();
    
        JobListing::chunk(100, function ($jobs) use ($preferences, $matchingService) {
            foreach ($preferences as $preference) {
                foreach ($jobs as $job) {
                    if ($matchingService->matches($job, $preference)) {
                        JobMatch::firstOrCreate([
                            'user_id'        => $preference->user_id,
                            'job_listing_id' => $job->id,
                        ]);
                    }
                }
            }
        });
    }
}
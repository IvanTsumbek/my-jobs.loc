<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use App\Models\UserPreference;
use App\Services\JobMatchingService;
use Illuminate\Console\Command;

class MatchTestCommand extends Command
{
    protected $signature = 'jobs:match-test {userId}';
    protected $description = 'Test job matching for a user';

    public function __construct(private JobMatchingService $matchingService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $preference = UserPreference::where('user_id', $this->argument('userId'))->first();

        if (!$preference) {
            $this->error('No preferences found for this user');
            return;
        }

        $jobs = JobListing::all();
        $matched = $jobs->filter(fn($job) => $this->matchingService->matches($job, $preference));

        $this->info("Matched {$matched->count()} of {$jobs->count()} jobs");

        $this->table(
            ['ID', 'title', 'company', 'location'],
            $matched->map(fn($job) => [
                $job->id,
                $job->title,
                $job->company,
                $job->location,
            ])->toArray()
        );
    }
}

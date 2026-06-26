<?php

namespace App\Jobs;

use App\Models\JobSource;
use App\Services\JobSaveService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class StoreJobsJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(private array $jobs) {}

    public function handle(JobSaveService $saveService): void
    {
        Log::info('StoreJobsJob started', ['count' => count($this->jobs)]);
        
        $source = JobSource::where('slug', 'remotive')->firstOrFail();
        $saveService->saveMany($this->jobs, $source->id);

        Log::info('StoreJobsJob completed');

        MatchJobsToUsersJob::dispatch();
    }
}

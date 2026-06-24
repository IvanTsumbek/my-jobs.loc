<?php

namespace App\Jobs;

use App\Models\JobSource;
use App\Services\JobSaveService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StoreJobsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private array $jobs) {}

    public function handle(JobSaveService $saveService): void
    {
        $source = JobSource::where('slug', 'remotive')->firstOrFail();
        $saveService->saveMany($this->jobs, $source->id);

        MatchJobsToUsersJob::dispatch();
    }
}

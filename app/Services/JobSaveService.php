<?php

namespace App\Services;

use App\Repositories\JobRepository;
use Illuminate\Support\Facades\Log;

class JobSaveService
{
    public function __construct(
        private JobRepository $repository
    ) {}

    public function saveMany(array $jobs, int $jobSourceId): void
    {
        $saved = 0;
        $skipped = 0;

        foreach ($jobs as $job) {
            if ($this->repository->existsByHash($job['hash'])) {
                $skipped++;
                continue;
            }

            $this->repository->create([
                ...$job,
                'job_source_id' => $jobSourceId,
                'fetched_at'    => now(),
            ]);

            $saved++;
        }

        Log::info("Jobs sync done. Saved: {$saved}, Skipped: {$skipped}");
    }
}
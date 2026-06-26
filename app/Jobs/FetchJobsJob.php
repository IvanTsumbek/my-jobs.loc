<?php

namespace App\Jobs;

use App\Integrations\RemotiveClient;
use App\Jobs\NormalizeJobsJob;
use App\Models\JobFetchLog;
use App\Models\JobSource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchJobsJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(RemotiveClient $client): void
    {
        $source = JobSource::where('slug', 'remotive')->firstOrFail();
        $startedAt = now();
        $start = microtime(true);

        try {
            $jobs = $client->fetchJobs();

            JobFetchLog::create([
                'job_source_id'    => $source->id,
                'status'           => 'success',
                'items_fetched'    => count($jobs),
                'response_time_ms' => (int) ((microtime(true) - $start) * 1000),
                'started_at'       => $startedAt,
                'finished_at'      => now(),
            ]);

            NormalizeJobsJob::dispatch($jobs);
        } catch (\Throwable $e) {
            JobFetchLog::create([
                'job_source_id'    => $source->id,
                'status'           => 'error',
                'items_fetched'    => 0,
                'response_time_ms' => (int) ((microtime(true) - $start) * 1000),
                'error_message'    => $e->getMessage(),
                'started_at'       => $startedAt,
                'finished_at'      => now(),
            ]);

            throw $e;
        }
    }
}

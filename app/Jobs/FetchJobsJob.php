<?php

namespace App\Jobs;

use App\Integrations\RemotiveClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchJobsJob implements ShouldQueue
{
    use Queueable;

    public function handle(RemotiveClient $client): void
    {
        $jobs = $client->fetchJobs();

        NormalizeJobsJob::dispatch($jobs);
    }
}
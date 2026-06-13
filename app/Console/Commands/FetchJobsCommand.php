<?php

namespace App\Console\Commands;

use App\Integrations\RemotiveClient;
use App\Services\Normalizers\RemotiveNormalizer;
use Illuminate\Console\Command;

class FetchJobsCommand extends Command
{
    protected $signature = 'jobs:fetch';
    protected $description = 'Fetch jobs from Remotive API';

    public function handle(): void
    {
        $this->info('Fetching jobs from Remotive...');

        $jobs = (new RemotiveClient())->fetchJobs();
        $normalized = (new RemotiveNormalizer())->normalizeAll($jobs);

        $this->info('Fetched: ' . count($normalized) . ' jobs');
        $this->table(
            ['external_id', 'title', 'company', 'location'],
            collect($normalized)->map(fn($job) => [
                $job['external_id'],
                $job['title'],
                $job['company'],
                $job['location'],
            ])->toArray()
        );
    }
}

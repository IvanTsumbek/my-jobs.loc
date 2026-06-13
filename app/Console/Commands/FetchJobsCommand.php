<?php

namespace App\Console\Commands;

use App\Integrations\RemotiveClient;
use App\Models\JobSource;
use App\Services\JobSaveService;
use App\Services\Normalizers\RemotiveNormalizer;
use Illuminate\Console\Command;

class FetchJobsCommand extends Command
{
    protected $signature = 'jobs:fetch';
    protected $description = 'Fetch jobs from Remotive API';

    public function __construct(
        private JobSaveService $saveService,
        private RemotiveNormalizer $normalizer
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Fetching jobs from Remotive...');

        $jobs = (new RemotiveClient())->fetchJobs();
        $normalized = $this->normalizer->normalizeAll($jobs);

        $this->info('Fetched: ' . count($normalized) . ' jobs');

        $source = JobSource::where('slug', 'remotive')->firstOrFail();
        $this->saveService->saveMany($normalized, $source->id);
        $this->info('Done! Check logs for details.');
    }
}

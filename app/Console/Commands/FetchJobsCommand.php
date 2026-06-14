<?php

namespace App\Console\Commands;

use App\Jobs\FetchJobsJob;
use Illuminate\Console\Command;

class FetchJobsCommand extends Command
{
    protected $signature = 'jobs:fetch';
    protected $description = 'Fetch jobs from Remotive API';

    public function handle(): void
    {
        FetchJobsJob::dispatch();
        $this->info('Job dispatched!');
    }
}
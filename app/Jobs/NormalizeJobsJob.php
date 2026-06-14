<?php

namespace App\Jobs;

use App\Services\Normalizers\RemotiveNormalizer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NormalizeJobsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private array $jobs) {}

    public function handle(RemotiveNormalizer $normalizer): void
    {
        $normalized = $normalizer->normalizeAll($this->jobs);

        StoreJobsJob::dispatch($normalized);
    }
}

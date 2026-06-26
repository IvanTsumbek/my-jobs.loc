<?php

namespace App\Jobs;

use App\Services\Normalizers\RemotiveNormalizer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NormalizeJobsJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(private array $jobs) {}

    public function handle(RemotiveNormalizer $normalizer): void
    {
        Log::info('NormalizeJobsJob started', ['count' => count($this->jobs)]);

        $normalized = $normalizer->normalizeAll($this->jobs);

        Log::info('NormalizeJobsJob completed', ['normalized' => count($normalized)]);

        StoreJobsJob::dispatch($normalized);
    }
}

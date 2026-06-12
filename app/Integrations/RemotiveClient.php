<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;

class RemotiveClient
{
    private string $baseUrl = 'https://remotive.com/api/remote-jobs';

    public function fetchJobs(): array
    {
        $response = Http::get($this->baseUrl);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Remotive API error: ' . $response->status()
            );
        }

        return $response->json('jobs', []);
    }
}
<?php

namespace App\Repositories;

use App\Models\JobListing;

class JobRepository
{
    public function existsByHash(string $hash): bool
    {
        return JobListing::where('hash', $hash)->exists();
    }

    public function create(array $data): JobListing
    {
        return JobListing::create($data);
    }
}
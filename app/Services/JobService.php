<?php

namespace App\Services;

use App\Models\JobListing;
use Illuminate\Pagination\LengthAwarePaginator;

class JobService
{
    public function getPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return JobListing::latest()->paginate($perPage);
    }
}
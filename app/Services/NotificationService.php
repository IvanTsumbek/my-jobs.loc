<?php

namespace App\Services;

use App\Models\JobMatch;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    public function getForUser(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return JobMatch::where('user_id', $userId)
            ->with('jobListing')
            ->latest()
            ->paginate($perPage);
    }
}

<?php

namespace App\Services;

use App\Models\JobListing;
use App\Models\UserPreference;

class JobMatchingService
{
    public function matches(JobListing $job, UserPreference $preference): bool
    {
        if ($preference->remote_only && !$job->is_remote) {
            return false;
        }

        if ($preference->keywords && !$this->matchesKeywords($job, $preference->keywords)) {
            return false;
        }

        if ($preference->categories && !in_array($job->category, $preference->categories)) {
            return false;
        }

        if ($preference->locations && !$this->matchesLocation($job, $preference->locations)) {
            return false;
        }

        return true;
    }

    private function matchesKeywords(JobListing $job, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            $keyword = strtolower($keyword);

            if (str_contains(strtolower($job->title), $keyword)) {
                return true;
            }

            $tags = array_map('strtolower', $job->tags ?? []);
            if (in_array($keyword, $tags)) {
                return true;
            }
        }

        return false;
    }

    private function matchesLocation(JobListing $job, array $locations): bool
    {
        foreach ($locations as $location) {
            if (str_contains(strtolower($job->location ?? ''), strtolower($location))) {
                return true;
            }
        }

        return false;
    }
}
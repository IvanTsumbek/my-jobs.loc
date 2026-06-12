<?php

namespace App\Services\Normalizers;

class RemotiveNormalizer
{
    public function normalize(array $job): array
    {
        return [
            'external_id'     => (string) $job['id'],
            'external_url'    => $job['url'],
            'title'           => $job['title'],
            'company'         => $job['company_name'],
            'description'     => $job['description'] ?? null,
            'location'        => $job['candidate_required_location'] ?? null,
            'is_remote'       => true,
            'category'        => $job['category'] ?? null,
            'employment_type' => $job['job_type'] ?? null,
            'tags'            => $job['tags'] ?? [],
            'published_at'    => $job['publication_date'] ?? null,
            'hash'            => md5((string) $job['id'] . 'remotive'),
            'salary_min'      => null,
            'salary_max'      => null,
            'salary_currency' => null,
        ];
    }

    public function normalizeAll(array $jobs): array
    {
        return array_map(fn($job) => $this->normalize($job), $jobs);
    }
}
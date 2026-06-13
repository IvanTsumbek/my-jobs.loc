<?php

namespace App\Services\Normalizers;

use App\Services\SalaryParserService;

class RemotiveNormalizer
{
    public function __construct(
        private SalaryParserService $salaryParser
    ) {}

    public function normalize(array $job): array
    {
        $salary = $this->salaryParser->parse($job['salary'] ?? null);

        return [
            'external_id'     => (string) $job['id'],
            'external_url'    => $job['url'],
            'url'             => $job['url'],
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
            'salary_min'      => $salary['salary_min'],
            'salary_max'      => $salary['salary_max'],
            'salary_currency' => $salary['salary_currency'],
        ];
    }

    public function normalizeAll(array $jobs): array
    {
        return array_map(fn($job) => $this->normalize($job), $jobs);
    }
}

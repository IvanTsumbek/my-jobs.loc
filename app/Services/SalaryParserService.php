<?php

namespace App\Services;

class SalaryParserService
{
    public function parse(string|null $salary): array
    {
        if (empty($salary)) {
            return ['salary_min' => null, 'salary_max' => null, 'salary_currency' => null];
        }

        $isHourly = preg_match('/\/h(our|r)?/i', $salary);
        $cleaned = preg_replace('/OTE|depending on experience|\/hour|\/hr/i', '', $salary);
        preg_match_all('/[\d,]+\.?\d*/i', $cleaned, $matches);
        $numbers = array_map(fn($n) => (float) str_replace([',', ' '], ['.', ''], $n), $matches[0]);

        if (empty($numbers)) {
            return ['salary_min' => null, 'salary_max' => null, 'salary_currency' => null];
        }

        // k → *1000
        preg_match_all('/([\d,]+\.?\d*)\s*k/i', $cleaned, $kMatches);
        $kNumbers = array_map(fn($n) => (float) str_replace([',', ' '], ['.', ''], $n) * 1000, $kMatches[1]);
        $values = !empty($kNumbers) ? $kNumbers : $numbers;

        $min = $values[0] ?? null;
        $max = $values[1] ?? null;

        if ($isHourly) {
            $min = $min ? (int) ($min * 2080) : null;
            $max = $max ? (int) ($max * 2080) : null;
        } else {
            $min = $min ? (int) $min : null;
            $max = $max ? (int) $max : null;
        }

        return [
            'salary_min'      => $min,
            'salary_max'      => $max,
            'salary_currency' => 'USD',
        ];
    }
}
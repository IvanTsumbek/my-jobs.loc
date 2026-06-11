<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobListing extends Model
{
    protected $fillable = [
        'job_source_id',
        'title',
        'company',
        'description',
        'url',
        'location',
        'is_remote',
        'salary_min',
        'salary_max',
        'salary_currency',
        'employment_type',
        'category',
        'tags',
        'external_id',
        'external_url',
        'hash',
        'published_at',
        'fetched_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_remote' => 'boolean',
        'published_at' => 'datetime',
        'fetched_at' => 'datetime',
    ];

    public function jobSource(): BelongsTo
    {
        return $this->belongsTo(JobSource::class);
    }
}

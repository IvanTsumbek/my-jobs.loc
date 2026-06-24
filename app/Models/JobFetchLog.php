<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobFetchLog extends Model
{
    protected $fillable = [
        'job_source_id',
        'status',
        'items_fetched',
        'response_time_ms',
        'error_message',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'items_fetched' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function jobSource(): BelongsTo
    {
        return $this->belongsTo(JobSource::class);
    }
}



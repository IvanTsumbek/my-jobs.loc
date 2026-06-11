<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'keywords',
        'locations',
        'categories',
        'salary_min',
        'salary_max',
        'remote_only',
        'frequency',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'locations' => 'array',
        'categories' => 'array',
        'salary_min' => 'integer',
        'salary_max' => 'integer',
        'remote_only' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

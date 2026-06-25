<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'company'         => $this->company,
            'location'        => $this->location,
            'url'             => $this->url,
            'is_remote'       => $this->is_remote,
            'category'        => $this->category,
            'employment_type' => $this->employment_type,
            'tags'            => $this->tags,
            'salary_min'      => $this->salary_min,
            'salary_max'      => $this->salary_max,
            'salary_currency' => $this->salary_currency,
            'published_at'    => $this->published_at,
        ];
    }
}

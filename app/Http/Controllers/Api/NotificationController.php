<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\JobMatch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $matches = JobMatch::where('user_id', $request->user()->id)
            ->with('jobListing')
            ->latest()
            ->paginate(20);

        return JobResource::collection($matches->map(fn($match) => $match->jobListing));
    }
}
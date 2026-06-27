<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $matches = $this->notificationService->getForUser($request->user()->id, 15);

        return JobResource::collection($matches->through(fn($match) => $match->jobListing));
    }
}
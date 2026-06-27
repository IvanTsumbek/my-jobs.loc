<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Services\JobService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobController extends Controller
{
    public function __construct(private JobService $jobService) {}

    public function index(): AnonymousResourceCollection
    {

        return JobResource::collection($this->jobService->getPaginated(15));
    }
}
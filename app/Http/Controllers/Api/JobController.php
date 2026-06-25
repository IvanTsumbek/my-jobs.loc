<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\JobListing;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $jobs = JobListing::latest()->paginate(20);

        return JobResource::collection($jobs);
    }
}
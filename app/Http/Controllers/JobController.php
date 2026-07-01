<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobListing::latest()->paginate(20);

        return view('jobs.index', compact('jobs'));
    }

    public function show(int $id)
    {
        $job = JobListing::findOrFail($id);

        return view('jobs.show', compact('job'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobListing::query()
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('company', 'like', "%{$request->search}%"))
            ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
            ->when($request->remote, fn($q) => $q->where('is_remote', true))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    public function show(int $id)
    {
        $job = JobListing::findOrFail($id);

        return view('jobs.show', compact('job'));
    }
}

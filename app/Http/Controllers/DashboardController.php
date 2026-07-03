<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobMatch;
use App\Models\JobFetchLog;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'jobsCount'      => JobListing::count(),
            'matchesCount'   => JobMatch::where('user_id', auth()->id())->count(),
            'recentMatches'  => JobMatch::where('user_id', auth()->id())
                ->with('jobListing')
                ->latest()
                ->take(5)
                ->get(),
            'lastFetch'      => JobFetchLog::latest()->first(),
        ]);
    }
}
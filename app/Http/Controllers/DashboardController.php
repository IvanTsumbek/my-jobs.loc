<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobMatch;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'jobsCount'         => JobListing::count(),
            'matchesCount'      => JobMatch::where('user_id', auth()->id())->count(),
        ]);
    }
}

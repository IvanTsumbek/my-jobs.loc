<?php

namespace App\Http\Controllers;

use App\Models\JobMatch;

class NotificationController extends Controller
{
    public function index()
    {
        $matches = JobMatch::where('user_id', auth()->id())
            ->with('jobListing')
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('matches'));
    }
}
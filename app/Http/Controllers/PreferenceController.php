<?php

namespace App\Http\Controllers;

class PreferenceController extends Controller
{
    public function index()
    {
        return view('preferences.index');
    }
}
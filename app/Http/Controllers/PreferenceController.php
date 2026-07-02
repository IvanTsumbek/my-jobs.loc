<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePreferenceRequest;
use App\Services\UserPreferenceService;

class PreferenceController extends Controller
{
    public function __construct(private UserPreferenceService $service) {}

    public function index()
    {
        $preference = $this->service->getForUser();

        return view('preferences.index', compact('preference'));
    }

    public function save(SavePreferenceRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'keywords'   => $validated['keywords'] ? array_map('trim', explode(',', $validated['keywords'])) : null,
            'locations'  => $validated['locations'] ? array_map('trim', explode(',', $validated['locations'])) : null,
            'categories' => $validated['categories'] ? array_map('trim', explode(',', $validated['categories'])) : null,
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'remote_only'=> $request->boolean('remote_only'),
            'frequency'  => $validated['frequency'] ?? 'daily',
            'is_active'  => true,
        ];

        $this->service->updateOrCreate($data);

        return redirect()->route('preferences.index')->with('success', 'Preferences saved!');
    }
}
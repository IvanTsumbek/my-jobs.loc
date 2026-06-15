<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertUserPreferenceRequest;
use App\Services\UserPreferenceService;
use Illuminate\Http\JsonResponse;

class UserPreferenceController extends Controller
{
    public function __construct(
        private UserPreferenceService $service
    ) {}

    public function show(): JsonResponse
    {
        $preference = $this->service->getForUser();

        if (!$preference) {
            return response()->json(['message' => 'No preferences found'], 404);
        }

        return response()->json($preference);
    }

    public function upsert(UpsertUserPreferenceRequest $request): JsonResponse
    {
        $preference = $this->service->updateOrCreate($request->validated());

        return response()->json($preference);
    }

    public function destroy(): JsonResponse
    {
        $this->service->delete();

        return response()->json(['message' => 'Preferences deleted']);
    }
}
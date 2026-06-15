<?php

namespace App\Services;

use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

class UserPreferenceService
{
    public function getForUser(): ?UserPreference
    {
        return UserPreference::where('user_id', Auth::id())->first();
    }

    public function updateOrCreate(array $data): UserPreference
    {
        return UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );
    }

    public function delete(): void
    {
        UserPreference::where('user_id', Auth::id())->delete();
    }
}
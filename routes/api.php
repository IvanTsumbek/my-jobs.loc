<?php

use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {
    Route::get('jobs', [JobController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('preferences', [UserPreferenceController::class, 'show']);
        Route::post('preferences', [UserPreferenceController::class, 'upsert']);
        Route::delete('preferences', [UserPreferenceController::class, 'destroy']);
        Route::get('notifications', [NotificationController::class, 'index']);
    });
});
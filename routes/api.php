<?php

use App\Http\Controllers\ResourceUserController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Knuckles\Scribe\Attributes\Response;

/**
 * Healthcheck
 *
 * Check that the service is up. If everything is okay, you'll get a 200 OK response.
 *
 * Otherwise, the request will fail with a 400 error, and a response listing the failed services.
 *
 * @response 400 scenario="Service is unhealthy" {"status": "down", "services": {"database": "up", "redis": "down"}}
 * @responseField status The status of this API (`up` or `down`).
 * @responseField services Map of each downstream service and their status (`up` or `down`).
 */
Route::get('/healthcheck', function () {
    return [
        'status' => 'up',
        'services' => [
            'database' => 'up',
            'redis' => 'up',
        ],
    ];
});

Route::get('auth/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('users', UserController::class);
Route::apiResource('resource-users', ResourceUserController::class);

Route::apiResource('admin/admin-resource-users', ResourceUserController::class);

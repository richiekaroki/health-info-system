<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\V1\{
    AuthController,
    ClientController,
    ProgramController,
    EnrollmentController
};

// API Status Check
Route::get('/test', function () {
    return response()->json([
        'status' => 'operational',
        'version' => '1.0',
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Rate Limit Test
Route::get('/test-rate-limit', function() {
    return response()->json([
        'message' => 'Rate limit test successful',
        'remaining' => \Illuminate\Support\Facades\RateLimiter::remaining(
            request()->ip(),
            5
        )
    ]);
})->middleware('throttle:5,1');

// Version 1 API Routes
Route::prefix('v1')->group(function () {
    // Public Auth Endpoints
    Route::post('/register', [AuthController::class, 'register'])
        ->name('api.v1.register');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.v1.login');

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('api.v1.logout');

        Route::get('/test-auth', function() {
            return response()->json([
                'message' => 'Authentication successful',
                'user' => Auth::user() // Properly accessed via Auth facade
            ]);
        })->name('api.v1.test-auth');

        // Clients
        Route::apiResource('clients', ClientController::class)
            ->only(['index', 'store', 'show'])
            ->names([
                'index' => 'api.v1.clients.index',
                'store' => 'api.v1.clients.store',
                'show' => 'api.v1.clients.show'
            ]);

        // Programs
        Route::post('programs', [ProgramController::class, 'store'])
            ->name('api.v1.programs.store');

        Route::get('programs/{program}/clients', [ProgramController::class, 'clients'])
            ->name('api.v1.programs.clients');

        // Enrollment
        Route::post('clients/{client}/enroll', [EnrollmentController::class, 'enroll'])
            ->name('api.v1.enrollments.enroll');

        Route::delete('clients/{client}/unenroll', [EnrollmentController::class, 'unenroll'])
            ->name('api.v1.enrollments.unenroll');
    });
});

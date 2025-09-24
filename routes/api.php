<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{
    AuthController,
    ClientController,
    ProgramController,
    EnrollmentController
};

// API Status Check (public)
Route::get('/test', function () {
    return response()->json([
        'status' => 'operational',
        'version' => '1.0',
        'timestamp' => now()->toDateTimeString(),
    ]);
});

// Version 1 API Routes
Route::prefix('v1')->group(function () {

    // Public Auth Endpoints
    Route::post('/register', [AuthController::class, 'register'])
        ->name('api.v1.register');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.v1.login');

    // Protected Routes - ALL properly protected now
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('api.v1.logout');
        Route::get('/test-auth', [AuthController::class, 'testAuth'])
            ->name('api.v1.test-auth');

        // Clients - Full CRUD with proper authorization
        Route::apiResource('clients', ClientController::class)
            ->names([
                'index' => 'api.v1.clients.index',
                'store' => 'api.v1.clients.store',
                'show' => 'api.v1.clients.show',
                'update' => 'api.v1.clients.update',
                'destroy' => 'api.v1.clients.destroy',
            ]);

        // Programs - Full CRUD
        Route::apiResource('programs', ProgramController::class)
            ->except(['destroy'])
            ->names([
                'index' => 'api.v1.programs.index',
                'store' => 'api.v1.programs.store',
                'show' => 'api.v1.programs.show',
                'update' => 'api.v1.programs.update',
            ]);

        // Program clients
        Route::get('programs/{program}/clients', [ProgramController::class, 'clients'])
            ->name('api.v1.programs.clients');

        // Enrollments - Full CRUD with proper protection
        Route::apiResource('enrollments', EnrollmentController::class)
            ->names([
                'index' => 'api.v1.enrollments.index',
                'store' => 'api.v1.enrollments.store',
                'show' => 'api.v1.enrollments.show',
                'update' => 'api.v1.enrollments.update',
                'destroy' => 'api.v1.enrollments.destroy',
            ]);
    });
});
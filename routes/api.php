<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{
ClientController,
ProgramController,
EnrollmentController
};

Route::get('/test', function() {
return response()->json(['message' => 'API is working']);
});

Route::prefix('v1')->group(function () {  // Removed middleware

// Client Routes
Route::apiResource('clients', ClientController::class)->only([
'index', 'store', 'show'
]);

// Program Routes
Route::post('programs', [ProgramController::class, 'store']);
Route::get('programs/{program}/clients', [ProgramController::class, 'clients']);

// Enrollment Routes
Route::post('clients/{client}/enroll', [EnrollmentController::class, 'enroll']);
Route::delete('clients/{client}/unenroll', [EnrollmentController::class, 'unenroll']);
});
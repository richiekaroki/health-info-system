<?php

// app/Http/Controllers/API/V1/EnrollmentController.php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\{Client, Program};
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Enroll a client in programs.
     */
    public function enroll(Request $request, Client $client)
    {
        $validated = $request->validate([
            'program_ids' => 'required|array',
            'program_ids.*' => 'exists:programs,id',
            'status' => 'sometimes|string|in:active,pending'
        ]);

        $client->programs()->attach($validated['program_ids'], [
            'status' => $validated['status'] ?? 'active',
            'enrollment_date' => now()
        ]);

        return response()->json([
            'message' => 'Enrollment successful',
            'data' => $client->load('programs')
        ]);
    }

    /**
     * Unenroll a client from a program.
     */
    public function unenroll(Request $request, Client $client)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id'
        ]);

        $client->programs()->detach($validated['program_id']);

        return response()->json([
            'message' => 'Unenrollment successful'
        ]);
    }
    
    public function show(Client $client)
    {
        return response()->json([
            'data' => $client->load('programs'), // Automatically includes pivot fields
        ]);
    }
}
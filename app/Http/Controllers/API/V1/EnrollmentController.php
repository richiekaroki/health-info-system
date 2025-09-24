<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Http\Resources\EnrollmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $enrollments = Enrollment::with(['client', 'program', 'coach'])
            ->paginate(15);

        return response()->json([
            'data' => EnrollmentResource::collection($enrollments),
            'meta' => [
                'current_page' => $enrollments->currentPage(),
                'total' => $enrollments->total(),
                'per_page' => $enrollments->perPage(),
            ]
        ]);
    }

    public function show(Enrollment $enrollment): JsonResponse
    {
        $this->authorize('view', $enrollment);

        $enrollment->load(['client', 'program', 'coach']);

        return response()->json([
            'data' => new EnrollmentResource($enrollment)
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'program_id' => 'required|exists:programs,id',
            'status' => ['required', 'string', Rule::in(['active', 'completed', 'dropped', 'on-hold'])],
            'enrollment_date' => 'required|date|before_or_equal:today',
            'completion_date' => 'nullable|date|after:enrollment_date',
            'actual_cost' => 'nullable|numeric|min:0',
            'attendance_weeks' => 'nullable|integer|min:0',
            'total_sessions' => 'nullable|integer|min:0',
            'completed_sessions' => 'nullable|integer|min:0|lte:total_sessions',
            'medical_clearance' => 'boolean',
            'clearance_expiry' => 'nullable|date|after:enrollment_date',
            'assigned_coach_id' => 'nullable|exists:users,id',
            'progress_notes' => 'nullable|string|max:1000',
        ], [
            'client_id.required' => 'Client selection is required.',
            'program_id.required' => 'Program selection is required.',
            'enrollment_date.before_or_equal' => 'Enrollment date cannot be in the future.',
            'completed_sessions.lte' => 'Completed sessions cannot exceed total sessions.',
        ]);

        // Check for existing active enrollment
        $existingEnrollment = Enrollment::where('client_id', $validated['client_id'])
            ->where('program_id', $validated['program_id'])
            ->where('status', 'active')
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'message' => 'Client is already actively enrolled in this program',
                'existing_enrollment_id' => $existingEnrollment->id
            ], 422);
        }

        $enrollment = Enrollment::create($validated);

        return response()->json([
            'message' => 'Enrollment created successfully',
            'data' => new EnrollmentResource($enrollment->load(['client', 'program']))
        ], 201);
    }

    public function update(Request $request, Enrollment $enrollment): JsonResponse
    {
        $this->authorize('update', $enrollment);

        $validated = $request->validate([
            'status' => ['sometimes', 'required', 'string', Rule::in(['active', 'completed', 'dropped', 'on-hold'])],
            'completion_date' => 'nullable|date|after:enrollment_date',
            'actual_cost' => 'nullable|numeric|min:0',
            'attendance_weeks' => 'nullable|integer|min:0',
            'total_sessions' => 'nullable|integer|min:0',
            'completed_sessions' => 'nullable|integer|min:0|lte:total_sessions',
            'medical_clearance' => 'boolean',
            'clearance_expiry' => 'nullable|date|after:enrollment_date',
            'assigned_coach_id' => 'nullable|exists:users,id',
            'progress_notes' => 'nullable|string|max:1000',
        ]);

        $enrollment->update($validated);

        return response()->json([
            'message' => 'Enrollment updated successfully',
            'data' => new EnrollmentResource($enrollment->load(['client', 'program']))
        ]);
    }

    public function destroy(Enrollment $enrollment): JsonResponse
    {
        $this->authorize('delete', $enrollment);

        $enrollment->delete();

        return response()->json([
            'message' => 'Enrollment deleted successfully'
        ], 200);
    }
}

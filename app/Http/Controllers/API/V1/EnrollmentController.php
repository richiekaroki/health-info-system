<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Http\Resources\EnrollmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    public function index(): JsonResponse
    {
        $enrollments = Enrollment::with(['client', 'program'])->paginate(15);
        return response()->json(EnrollmentResource::collection($enrollments));
    }

    public function show(Enrollment $enrollment): JsonResponse
    {
        $enrollment->load(['client', 'program']);
        return response()->json(new EnrollmentResource($enrollment));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'client_id'         => 'required|exists:clients,id',
            'program_id'        => 'required|exists:programs,id',
            'status'            => 'required|string',
            'enrollment_date'   => 'required|date',
            'completion_date'   => 'nullable|date',
            'actual_cost'       => 'nullable|numeric',
            'attendance_weeks'  => 'nullable|integer',
            'total_sessions'    => 'nullable|integer',
            'completed_sessions'=> 'nullable|integer',
            'medical_clearance' => 'boolean',
            'clearance_expiry'  => 'nullable|date',
            'progress_notes'    => 'nullable|string',
        ]);

        $enrollment = Enrollment::create($data);

        return response()->json(
            new EnrollmentResource($enrollment->load(['client', 'program'])),
            201
        );
    }

    public function update(Request $request, Enrollment $enrollment): JsonResponse
    {
        $data = $request->validate([
            'status'            => 'required|string',
            'completion_date'   => 'nullable|date',
            'actual_cost'       => 'nullable|numeric',
            'attendance_weeks'  => 'nullable|integer',
            'total_sessions'    => 'nullable|integer',
            'completed_sessions'=> 'nullable|integer',
            'medical_clearance' => 'boolean',
            'clearance_expiry'  => 'nullable|date',
            'progress_notes'    => 'nullable|string',
        ]);

        $enrollment->update($data);

        return response()->json(
            new EnrollmentResource($enrollment->load(['client', 'program']))
        );
    }

    public function destroy(Enrollment $enrollment): JsonResponse
    {
        $enrollment->delete();
        return response()->json(null, 204);
    }
}

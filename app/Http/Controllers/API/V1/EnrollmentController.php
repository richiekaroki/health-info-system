<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Program;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    public function enroll(EnrollmentRequest $request, Client $client): JsonResponse
    {
        $this->authorize('enroll', $client);

        $validated = $request->validated();

        $client->programs()->syncWithoutDetaching(
            $this->prepareProgramAttachments($validated)
        );

        return response()->json([
            'message' => 'Enrollment successful',
            'data'    => new ClientResource(
                $client->load(['programs' => function($query) {
                    $query->withPivot([
                        'status',
                        'enrollment_date',
                        'completion_date',
                        'medical_clearance',
                        'assigned_coach_id',
                        'progress_notes'
                    ]);
                }])
            )
        ], 201);
    }

    public function unenroll(Client $client, Program $program): JsonResponse
    {
        $this->authorize('unenroll', [$client, $program]);

        $client->programs()->detach($program->id);

        return response()->json([
            'message' => 'Unenrollment successful',
            'data'    => new ClientResource(
                $client->fresh()->load('programs')
            )
        ]);
    }

    protected function prepareProgramAttachments(array $validated): array
    {
        return collect($validated['program_ids'])
            ->mapWithKeys(fn ($id) => [
                $id => [
                    'status'             => $validated['status'] ?? 'pending',
                    'enrollment_date'    => $validated['enrollment_date'] ?? now(),
                    'completion_date'    => $validated['completion_date'] ?? null,
                    'medical_clearance'  => $validated['medical_clearance'] ?? false,
                    'assigned_coach_id'  => $validated['coach_id'] ?? null,
                    'progress_notes'     => $validated['progress_notes'] ?? null,
                ]
            ])
            ->toArray();
    }
}
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
    /**
     * Enroll client in programs
     */
    public function enroll(EnrollmentRequest $request, Client $client): JsonResponse
    {
        $this->authorize('enroll', $client);

        $validated = $request->validated();

        $client->programs()->syncWithoutDetaching(
            $this->prepareProgramAttachments($validated)
        );

        return response()->json([
            'message' => 'Enrollment successful',
            'data' => new ClientResource($client->load(['programs' => function($query) {
                $query->withPivot(['status', 'enrollment_date']);
            }]))
        ], 201);
    }

    /**
     * Unenroll client from program
     */
    public function unenroll(Client $client, Program $program): JsonResponse
    {
        $this->authorize('unenroll', [$client, $program]);

        $client->programs()->detach($program->id);

        return response()->json([
            'message' => 'Unenrollment successful',
            'data' => new ClientResource($client->fresh()->load('programs'))
        ]);
    }

    /**
     * Prepare program attachments with pivot data
     */
    protected function prepareProgramAttachments(array $validated): array
    {
        return collect($validated['program_ids'])
            ->mapWithKeys(fn ($id) => [
                $id => [
                    'status' => $validated['status'] ?? 'pending',
                    'enrollment_date' => $validated['enrollment_date'] ?? now(),
                    'assigned_coach_id' => $validated['coach_id'] ?? null
                ]
            ])
            ->toArray();
    }
}

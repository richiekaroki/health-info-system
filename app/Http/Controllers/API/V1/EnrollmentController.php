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
            collect($validated['program_ids'])
                ->mapWithKeys(fn ($id) => [
                    $id => [
                        'status' => $validated['status'] ?? 'active',
                        'enrollment_date' => $validated['enrollment_date'] ?? now()
                    ]
                ])
        );

        return response()->json([
            'message' => 'Enrollment successful',
            'data' => new ClientResource($client->load('programs'))
        ], 201);
    }

    public function unenroll(Client $client, Program $program): JsonResponse
    {
        $this->authorize('unenroll', $client);

        $client->programs()->detach($program->id);

        return response()->json([
            'message' => 'Unenrollment successful',
            'data' => new ClientResource($client->load('programs'))
        ]);
    }

    public function show(Client $client): JsonResponse
    {
        $this->authorize('view', $client);

        return response()->json([
            'data' => new ClientResource($client->load('programs'))
        ]);
    }
}

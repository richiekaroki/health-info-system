<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index(): JsonResponse
    {
        $programs = Program::query()
            ->with(['category', 'creator'])
            ->withCount('clients')
            ->paginate(15);

        return response()->json([
            'data' => ProgramResource::collection($programs),
            'meta' => [
                'current_page' => $programs->currentPage(),
                'total'        => $programs->total()
            ]
        ]);
    }

    public function store(StoreProgramRequest $request): JsonResponse
    {
        $program = Program::create($request->validated() + [
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Program created successfully',
            'data'    => new ProgramResource($program)
        ], 201);
    }

    public function show(Program $program): JsonResponse
    {
        return response()->json([
            'data' => new ProgramResource(
                $program->load(['category', 'creator'])->loadCount('clients')
            )
        ]);
    }

    public function clients(Program $program): JsonResponse
    {
        $this->authorize('viewClients', $program);

        $clients = $program->clients()
            ->withPivot([
                'status',
                'enrollment_date',
                'completion_date',
                'medical_clearance',
                'assigned_coach_id',
                'progress_notes'
            ])
            ->paginate(15);

        $clientData = $clients->map(function ($client) {
            return [
                'id'              => $client->id,
                'name'            => $client->full_name,
                'email'           => $client->email,
                'status'          => $client->pivot->status,
                'enrolled_at'     => $client->pivot->enrollment_date,
                'completion_date' => $client->pivot->completion_date,
                'coach_id'        => $client->pivot->assigned_coach_id,
            ];
        });

        return response()->json([
            'data' => $clientData,
            'meta' => [
                'program'      => new ProgramResource($program),
                'current_page' => $clients->currentPage(),
                'per_page'     => $clients->perPage(),
                'total'        => $clients->total()
            ]
        ]);
    }
}

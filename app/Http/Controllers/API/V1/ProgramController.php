<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\JsonResponse;

class ProgramController extends Controller
{
    public function index(): JsonResponse
    {
        $programs = Program::query()
            ->withCount('clients')
            ->paginate(15);

        return response()->json([
            'data' => ProgramResource::collection($programs),
            'meta' => [
                'current_page' => $programs->currentPage(),
                'total' => $programs->total()
            ]
        ]);
    }

    public function store(StoreProgramRequest $request): JsonResponse
    {
        $program = Program::create($request->validated() + [
            'created_by' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Program created successfully',
            'data' => new ProgramResource($program)
        ], 201);
    }

    public function show(Program $program): JsonResponse
    {
        return response()->json([
            'data' => new ProgramResource($program->loadCount('clients'))
        ]);
    }

    public function clients(Program $program): JsonResponse
    {
        $this->authorize('viewClients', $program);

        $clients = $program->clients()
            ->withPivot(['status', 'enrollment_date'])
            ->paginate(15);

        return response()->json([
            'data' => $clients->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->full_name,
                    'email' => $client->email,
                    'status' => $client->pivot->status,
                    'enrolled_at' => $client->pivot->enrollment_date
                ];
            }),
            'meta' => [
                'program' => new ProgramResource($program),
                'current_page' => $clients->currentPage(),
                'total' => $clients->total()
            ]
        ]);
    }
}

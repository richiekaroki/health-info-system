<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Http\Resources\ProgramResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        // FIXED: Added withCount('clients') so clients_count works in ProgramResource
        $programs = Program::query()
            ->with(['category', 'creator'])
            ->withCount('clients') // This ensures clients_count is available
            ->paginate(15);

        return response()->json([
            'data' => ProgramResource::collection($programs),
            'meta' => [
                'current_page' => $programs->currentPage(),
                'total' => $programs->total(),
                'per_page' => $programs->perPage(),
                'last_page' => $programs->lastPage(),
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Program::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'code' => 'nullable|string|max:50|unique:programs,code',
            'duration_weeks' => 'nullable|integer|min:1|max:104',
            'category_id' => 'nullable|exists:program_categories,id',
            'cost' => 'nullable|numeric|min:0',
            'type' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Program name is required.',
            'code.unique' => 'Program code must be unique.',
            'duration_weeks.max' => 'Duration cannot exceed 104 weeks (2 years).',
        ]);

        // Ensure created_by is always set
        $validated['created_by'] = Auth::id();

        $program = Program::create($validated);

        // Load relationships and count for response
        $program->load(['category', 'creator'])->loadCount('clients');

        return response()->json([
            'message' => 'Program created successfully',
            'data' => new ProgramResource($program)
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

    public function update(Request $request, Program $program): JsonResponse
    {
        $this->authorize('update', $program);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'code' => 'nullable|string|max:50|unique:programs,code,' . $program->id,
            'duration_weeks' => 'nullable|integer|min:1|max:104',
            'category_id' => 'nullable|exists:program_categories,id',
            'cost' => 'nullable|numeric|min:0',
            'type' => 'nullable|string|max:100',
        ]);

        $program->update($validated);

        return response()->json([
            'message' => 'Program updated successfully',
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
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'full_name' => $client->full_name, // Now works with accessor
                'email' => $client->email,
                'status' => $client->pivot->status,
                'enrolled_at' => $client->pivot->enrollment_date,
                'completion_date' => $client->pivot->completion_date,
                'coach_id' => $client->pivot->assigned_coach_id,
            ];
        });

        return response()->json([
            'data' => $clientData,
            'meta' => [
                'program' => new ProgramResource($program->loadCount('clients')),
                'current_page' => $clients->currentPage(),
                'per_page' => $clients->perPage(),
                'total' => $clients->total()
            ]
        ]);
    }
}
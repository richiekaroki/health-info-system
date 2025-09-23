<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Clients")
 */
class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::with(['programs' => function($query) {
            $query->withPivot([
                'status',
                'enrollment_date',
                'completion_date',
                'medical_clearance',
                'assigned_coach_id',
                'progress_notes'
            ]);
        }])->paginate(15);

        return response()->json([
            'data' => ClientResource::collection($clients),
            'meta' => [
                'current_page' => $clients->currentPage(),
                'total'        => $clients->total()
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:clients',
            'phone'       => 'nullable|string|max:20',
            'birth_date'  => 'nullable|date|before:today',
            'gender'      => 'nullable|in:male,female,non-binary,other,prefer_not_to_say',
        ]);

        $validated['created_by'] = $request->user()->id;

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client created successfully',
            'data'    => new ClientResource($client)
        ], 201);
    }

    public function show(Client $client): JsonResponse
    {
        return response()->json([
            'data' => new ClientResource(
                $client->load('programs')
            )
        ]);
    }
}

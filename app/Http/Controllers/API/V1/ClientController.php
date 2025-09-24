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
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Client::class, 'client');
    }

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
                'total' => $clients->total(),
                'per_page' => $clients->perPage(),
                'last_page' => $clients->lastPage(),
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:clients',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,non-binary,other,prefer_not_to_say',
            'preferred_name' => 'nullable|string|max:100',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|size:2',
        ], [
            'first_name.required' => 'First name is required.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email address is already registered.',
            'birth_date.before' => 'Birth date must be in the past.',
        ]);

        $validated['created_by'] = $request->user()->id;

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client created successfully',
            'data' => new ClientResource($client)
        ], 201);
    }

    public function show(Client $client): JsonResponse
    {
        return response()->json([
            'data' => new ClientResource(
                $client->load(['programs'])
            )
        ]);
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|nullable|string|max:100',
            'email' => 'sometimes|required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,non-binary,other,prefer_not_to_say',
            'preferred_name' => 'nullable|string|max:100',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|size:2',
        ]);

        $client->update($validated);

        return response()->json([
            'message' => 'Client updated successfully',
            'data' => new ClientResource($client)
        ]);
    }

    // ADDED: Missing destroy method
    public function destroy(Client $client): JsonResponse
    {
        // Check if client has active enrollments
        $activeEnrollments = $client->programs()
            ->wherePivot('status', 'active')
            ->count();

        if ($activeEnrollments > 0) {
            return response()->json([
                'message' => 'Cannot delete client with active program enrollments',
                'active_enrollments' => $activeEnrollments
            ], 422);
        }

        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully'
        ], 200);
    }
}

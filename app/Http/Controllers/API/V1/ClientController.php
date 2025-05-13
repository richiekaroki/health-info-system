<?php
// app/Http/Controllers/API/V1/ClientController.php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Clients")
 */
class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::with(['programs' => function($query) {
            $query->withPivot(['status', 'enrollment_date']);
        }])->paginate(15);

        return response()->json([
            'data' => ClientResource::collection($clients),
            'meta' => [
                'current_page' => $clients->currentPage(),
                'total' => $clients->total()
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today'
        ]);

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client created successfully',
            'data' => new ClientResource($client)
        ], 201);
    }

    public function show(Client $client): JsonResponse
    {
        return response()->json([
            'data' => new ClientResource($client->load('programs'))
        ]);
    }
}
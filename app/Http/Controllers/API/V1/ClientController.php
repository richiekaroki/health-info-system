<?php
// app/Http/Controllers/API/V1/ClientController.php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
/**
 * @OA\Tag(
 *     name="Clients",
 *     description="API Endpoints for Managing Clients"
 * )
 */
class ClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/clients",
     *     tags={"Clients"},
     *     summary="List all clients with their programs",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Client"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'data' => Client::with('programs')->get()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/clients",
     *     tags={"Clients"},
     *     summary="Create a new client",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ClientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client created",
     *         @OA\JsonContent(ref="#/components/schemas/Client")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date'
        ]);

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client created successfully',
            'data' => $client
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/clients/{client}",
     *     tags={"Clients"},
     *     summary="Get a specific client with enrolled programs",
     *     @OA\Parameter(
     *         name="client",
     *         in="path",
     *         required=true,
     *         description="Client ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ClientWithPrograms")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found"
     *     )
     * )
     */
    public function show(Client $client)
    {
        return response()->json([
            'data' => $client->load(['programs' => function($query) {
                $query->withPivot(['status', 'enrollment_date']);
            }])
        ]);
    }
}

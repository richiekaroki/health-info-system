<?php

// app/Http/Controllers/API/V1/ProgramController.php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Programs",
 *     description="API Endpoints for Managing Health Programs"
 * )
 */
class ProgramController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/programs",
     *     tags={"Programs"},
     *     summary="Create a new health program",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProgramRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Program created",
     *         @OA\JsonContent(ref="#/components/schemas/Program")
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
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'is_active' => 'sometimes|boolean'
        ]);

        $program = Program::create($validated);

        return response()->json([
            'message' => 'Program created successfully',
            'data' => $program
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/programs/{program}/clients",
     *     tags={"Programs"},
     *     summary="List clients enrolled in a program",
     *     @OA\Parameter(
     *         name="program",
     *         in="path",
     *         required=true,
     *         description="Program ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ClientWithEnrollment")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program not found"
     *     )
     * )
     */
    public function clients(Program $program)
    {
        return response()->json([
            'data' => $program->clients()->withPivot('status', 'enrollment_date')->get()
        ]);
    }
}

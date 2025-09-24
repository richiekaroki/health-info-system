<?php

namespace App\OpenApi\Paths;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/v1/clients/{client}/enrollments",
 *     summary="List all enrollments for a client",
 *     tags={"Enrollments"},
 *     security={{"sanctum": {}}},
 *     @OA\Parameter(
 *         name="client",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Enrollments retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Enrollment")
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/v1/clients/{client}/enroll",
 *     summary="Enroll a client into programs",
 *     tags={"Enrollments"},
 *     security={{"sanctum": {}}},
 *     @OA\Parameter(
 *         name="client",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/EnrollmentRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Enrollment successful",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Enrollment")
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/v1/clients/{client}/unenroll/{program}",
 *     summary="Unenroll a client from a program",
 *     tags={"Enrollments"},
 *     security={{"sanctum": {}}},
 *     @OA\Parameter(
 *         name="client",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="program",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Unenrollment successful",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Enrollment")
 *             )
 *         )
 *     )
 * )
 */
class Enrollments {}

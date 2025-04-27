<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Client",
 *     type="object",
 *     required={"full_name", "email"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="full_name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="phone_number", type="string", nullable=true),
 *     @OA\Property(property="birth_date", type="string", format="date", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="ClientRequest",
 *     type="object",
 *     required={"full_name", "email"},
 *     @OA\Property(property="full_name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone_number", type="string", example="+1234567890", nullable=true),
 *     @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="ClientWithPrograms",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Client"),
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(
 *                 property="programs",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/ProgramWithPivot")
 *             )
 *         )
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="Program",
 *     type="object",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="summary", type="string", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", default=true)
 * )
 *
 * @OA\Schema(
 *     schema="ProgramRequest",
 *     type="object",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="Weight Loss Program"),
 *     @OA\Property(property="summary", type="string", example="A 12-week weight loss program", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="ProgramWithPivot",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Program"),
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="pivot", ref="#/components/schemas/EnrollmentPivot")
 *         )
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="EnrollmentPivot",
 *     type="object",
 *     @OA\Property(property="status", type="string", example="active"),
 *     @OA\Property(property="enrollment_date", type="string", format="date", example="2023-01-15")
 * )
 */
class Schemas {}

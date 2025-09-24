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
 *     @OA\Property(property="phone", type="string", nullable=true),
 *     @OA\Property(property="birth_date", type="string", format="date", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="ClientRequest",
 *     type="object",
 *     required={"full_name", "email"},
 *     @OA\Property(property="full_name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890", nullable=true),
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
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", default=true)
 * )
 *
 * @OA\Schema(
 *     schema="ProgramRequest",
 *     type="object",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="Weight Loss Program"),
 *     @OA\Property(property="description", type="string", example="A 12-week weight loss program", nullable=true),
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
 *     @OA\Property(property="enrollment_date", type="string", format="date", example="2025-05-13")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Enrollment",
 *     type="object",
 *     @OA\Property(property="program_id", type="integer", example=1),
 *     @OA\Property(property="program_name", type="string", example="Wellness Bootcamp"),
 *     @OA\Property(property="status", type="string", example="active"),
 *     @OA\Property(property="enrollment_date", type="string", format="date", example="2025-01-10"),
 *     @OA\Property(property="completion_date", type="string", format="date", nullable=true),
 *     @OA\Property(property="actual_cost", type="number", format="float", example=200.50, nullable=true),
 *     @OA\Property(property="attendance_weeks", type="integer", example=12, nullable=true),
 *     @OA\Property(property="total_sessions", type="integer", example=24, nullable=true),
 *     @OA\Property(property="completed_sessions", type="integer", example=18, nullable=true),
 *     @OA\Property(property="medical_clearance", type="boolean", example=true),
 *     @OA\Property(property="clearance_expiry", type="string", format="date", example="2025-12-31", nullable=true),
 *     @OA\Property(property="assigned_coach_id", type="integer", example=5, nullable=true),
 *     @OA\Property(property="progress_notes", type="string", example="Client improving well", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="EnrollmentRequest",
 *     type="object",
 *     required={"program_ids"},
 *     @OA\Property(
 *         property="program_ids",
 *         type="array",
 *         @OA\Items(type="integer"),
 *         example={1,2}
 *     ),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="enrollment_date", type="string", format="date", example="2025-01-10"),
 *     @OA\Property(property="completion_date", type="string", format="date", nullable=true),
 *     @OA\Property(property="actual_cost", type="number", format="float", example=150.00, nullable=true),
 *     @OA\Property(property="attendance_weeks", type="integer", example=8, nullable=true),
 *     @OA\Property(property="total_sessions", type="integer", example=16, nullable=true),
 *     @OA\Property(property="completed_sessions", type="integer", example=12, nullable=true),
 *     @OA\Property(property="medical_clearance", type="boolean", example=true),
 *     @OA\Property(property="clearance_expiry", type="string", format="date", nullable=true),
 *     @OA\Property(property="coach_id", type="integer", example=5, nullable=true),
 *     @OA\Property(property="progress_notes", type="string", example="Initial notes", nullable=true)
 * )
 */

class Schemas {}

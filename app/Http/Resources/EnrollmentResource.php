<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the Enrollment model into a clean resource.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // Related models
            'program' => new ProgramResource($this->whenLoaded('program')),
            'client' => new ClientResource($this->whenLoaded('client')),
            'coach' => $this->when($this->assigned_coach_id, function () {
                return [
                    'id' => $this->assigned_coach_id,
                    'name' => $this->coach->name ?? null,
                ];
            }),

            // Direct Enrollment fields
            'status' => $this->status,
            'enrollment_date' => $this->enrollment_date?->toDateString(),
            'completion_date' => $this->completion_date?->toDateString(),
            'actual_cost' => $this->actual_cost,
            'attendance_weeks' => $this->attendance_weeks,
            'total_sessions' => $this->total_sessions,
            'completed_sessions' => $this->completed_sessions,
            'medical_clearance' => (bool) $this->medical_clearance,
            'clearance_expiry' => $this->clearance_expiry?->toDateString(),
            'progress_notes' => $this->progress_notes,

            // Timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
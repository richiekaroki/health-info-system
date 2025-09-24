<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform enrollment pivot into a clean resource.
     */
    public function toArray(Request $request): array
    {
        return [
            'program' => new ProgramResource($this),
            'client'  => new ClientResource($this),

            // Enrollment pivot fields
            'status'             => $this->pivot->status ?? null,
            'enrollment_date'    => $this->pivot->enrollment_date ?? null,
            'completion_date'    => $this->pivot->completion_date ?? null,
            'actual_cost'        => $this->pivot->actual_cost ?? null,
            'attendance_weeks'   => $this->pivot->attendance_weeks ?? null,
            'total_sessions'     => $this->pivot->total_sessions ?? null,
            'completed_sessions' => $this->pivot->completed_sessions ?? null,
            'medical_clearance'  => $this->pivot->medical_clearance ?? null,
            'clearance_expiry'   => $this->pivot->clearance_expiry ?? null,
            'assigned_coach_id'  => $this->pivot->assigned_coach_id ?? null,
            'progress_notes'     => $this->pivot->progress_notes ?? null,
        ];
    }
}

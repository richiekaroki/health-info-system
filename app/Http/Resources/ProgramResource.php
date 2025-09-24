<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'name'        => $this->name ?? $this->title ?? null,
            'description' => $this->description,
            'duration_weeks' => $this->duration_weeks,
            'is_active'   => (bool)$this->is_active,
            'type'        => $this->type,
            'cost'        => $this->cost,
            'clients_count' => $this->when(isset($this->clients_count), $this->clients_count),
            'created_by'  => $this->created_by,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'enrollments' => $this->whenLoaded('enrollments', function () {
                // if you have direct enrollments relation (Enrollment model)
                return $this->enrollments->map(function ($enroll) {
                    return [
                        'id' => $enroll->id,
                        'client_id' => $enroll->client_id,
                        'status' => $enroll->status,
                        'enrollment_date' => $enroll->enrollment_date,
                    ];
                });
            }),
        ];
    }
}

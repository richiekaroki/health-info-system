<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'duration_weeks' => $this->duration_weeks,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relationship data (only loaded when requested)
            'clients' => $this->whenLoaded('clients', function () {
                return $this->clients->map(function ($client) {
                    return [
                        'id' => $client->id,
                        'full_name' => $client->full_name,
                        'status' => $client->pivot->status,
                        'enrollment_date' => $client->pivot->enrollment_date,
                    ];
                });
            }),

            // Active clients (only loaded when requested)
            'active_clients' => $this->whenLoaded('clients', function () {
                return $this->active_clients_count;
            }),

            // Statistics (computed properties)
            'active_clients_count' => $this->when(
                $this->clients_count !== null,
                $this->clients_count
            ),
        ];
    }
}
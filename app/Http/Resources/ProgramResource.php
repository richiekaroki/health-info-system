<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration_weeks . ' weeks',
            'status' => $this->is_active ? 'Active' : 'Inactive',
            'type' => ucfirst($this->type),
            'cost' => $this->cost ? '$' . number_format($this->cost, 2) : 'Free',

            'category' => $this->whenLoaded('category', fn() => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ]),

            'clients' => $this->whenLoaded('clients', function() {
                return $this->clients->map(function($client) {
                    return [
                        'id' => $client->id,
                        'name' => $client->full_name,
                        'status' => $client->pivot->status,
                        'enrolled_on' => optional($client->pivot->enrollment_date)->format('Y-m-d'),
                        'coach_id' => $client->pivot->assigned_coach_id
                    ];
                });
            }),

            'clients_count' => $this->whenNotNull($this->clients_count),
            'active_clients_count' => $this->whenNotNull($this->active_clients_count),

            'created_at' => $this->created_at->format('Y-m-d'),
            'created_by' => $this->creator->name ?? null
        ];
    }
}

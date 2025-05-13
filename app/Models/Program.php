<?php

// app/Models/Program.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    protected $fillable = [
        'title', 'description', 'duration_weeks', 'is_active',
        'code', 'cost', 'start_date', 'end_date', 'max_participants', 'type'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProgramCategory::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class)
            ->using(ClientProgram::class)
            ->withPivot([
                'status',
                'enrollment_date',
                'completion_date',
                'actual_cost',
                'attendance_weeks',
                'medical_clearance'
            ])
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

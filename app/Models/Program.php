<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'duration_weeks', 'is_active',
        'category_id', 'created_by', 'cost', 'type'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProgramCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_program')
            ->using(ClientProgram::class)
            ->withPivot([
                'status',
                'enrollment_date',
                'completion_date',
                'actual_cost',
                'attendance_weeks',
                'medical_clearance',
                'assigned_coach_id'
            ])
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

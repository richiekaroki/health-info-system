<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        'full_name', 'preferred_name', 'email', 'phone', 'phone_alt',
        'birth_date', 'gender', 'address_line1', 'address_line2',
        'city', 'state', 'postal_code', 'country_code',
        'blood_type', 'known_allergies', 'medical_conditions',
        'created_by', 'primary_provider_id', 'status', 'notes', 'custom_fields'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'custom_fields' => 'array',
    ];

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'client_program')
            ->using(ClientProgram::class)
            ->withPivot([
                'status',
                'enrollment_date',
                'completion_date',
                'actual_cost',
                'attendance_weeks',
                'total_sessions',
                'completed_sessions',
                'medical_clearance',
                'clearance_expiry',
                'assigned_coach_id',
                'progress_notes'
            ])
            ->withTimestamps();
    }

    public function activePrograms()
    {
        return $this->programs()->wherePivot('status', 'active');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function primaryProvider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'primary_provider_id');
    }
}
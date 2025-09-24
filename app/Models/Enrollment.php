<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'client_id',
        'program_id',
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
        'progress_notes',
    ];

    protected $casts = [
        'enrollment_date'   => 'date',
        'completion_date'   => 'date',
        'clearance_expiry'  => 'date',
        'medical_clearance' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_coach_id');
    }
}

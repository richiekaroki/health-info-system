<?php

// app/Models/Client.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone_number', 'birth_date',
        'address_line1', 'city', 'state', 'postal_code'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_contact_at' => 'datetime'
    ];

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class)
            ->using(ClientProgram::class)
            ->withPivot([
                'status',
                'enrollment_date',
                'assigned_coach_id'
            ])
            ->withTimestamps();
    }

    public function activePrograms()
    {
        return $this->programs()->wherePivot('status', 'active');
    }
}

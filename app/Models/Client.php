<?php

// app/Models/Client.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'birth_date'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'birth_date' => 'date:Y-m-d',
        'metadata' => 'array',
        'last_contact_at' => 'datetime',
        'status_changed_at' => 'datetime'
    ];

    /**
     * Relationship: Programs the client is enrolled in
     */
    public function programs()
{
    return $this->belongsToMany(Program::class)
        ->withPivot(['status', 'enrollment_date', /* other fields */])
        ->withTimestamps();
}


    /**
     * Scope: Only active clients (enrolled in active programs)
     */
    public function scopeActive($query)
    {
        return $query->whereHas('programs', function($q) {
            $q->where('is_active', true);
        });
    }
}
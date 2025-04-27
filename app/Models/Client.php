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
    ];

    /**
     * Relationship: Programs the client is enrolled in
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'client_program')
            ->withPivot(['status', 'enrollment_date'])
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
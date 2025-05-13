<?php

// app/Models/Program.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'summary',
        'is_active'
    ];

    /**
     * Relationship: Clients enrolled in this program
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_program')    
            ->withPivot(['status', 'enrollment_date'])
            ->withTimestamps();
    }

    /**
     * Scope: Only active programs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
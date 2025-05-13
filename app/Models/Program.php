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
    return $this->belongsToMany(Client::class)
        ->withPivot(['status', 'enrollment_date', /* other fields */])
        ->withTimestamps();
}

    /**
     * Scope: Only active programs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor: Get the count of active clients
     */
    public function getActiveClientsCountAttribute()
    {
        return $this->clients()->wherePivot('status', 'active')->count();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'client_id',
        'program_id',
        'user_id',     // who created/managed the enrollment
        'status',      // e.g., active, completed, dropped
        'start_date',
        'end_date',
    ];

    /**
     * Relationships
     */

    // An enrollment belongs to a client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // An enrollment belongs to a program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // An enrollment may be created/managed by a user (provider/admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
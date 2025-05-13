<?php

// app/Models/ClientProgram.php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientProgram extends Pivot
{
    protected $casts = [
        'enrollment_date' => 'datetime',
        'completion_date' => 'datetime',
        'clearance_expiry' => 'datetime'
    ];


}
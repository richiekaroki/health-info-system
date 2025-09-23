<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientProgram extends Pivot
{
    protected $table = 'client_program';

    protected $casts = [
        'enrollment_date' => 'datetime',
        'completion_date' => 'datetime',
        'clearance_expiry' => 'datetime',
    ];
}

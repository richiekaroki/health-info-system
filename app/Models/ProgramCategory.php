<?php

// app/Models/ProgramCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'description',
        'icon', 'sort_order', 'is_active'
    ];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}

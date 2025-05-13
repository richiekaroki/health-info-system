<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true; // Publicly visible
    }

    public function view(User $user, Program $program): bool
    {
        return true; // Publicly visible
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create programs');
    }

    public function update(User $user, Program $program): bool
    {
        return $user->hasPermissionTo('edit programs') ||
               $program->created_by === $user->id;
    }

    public function delete(User $user, Program $program): bool
    {
        return $user->hasPermissionTo('delete programs');
    }

    public function viewClients(User $user, Program $program): bool
    {
        return $user->hasPermissionTo('view program clients') ||
               $program->created_by === $user->id;
    }
}

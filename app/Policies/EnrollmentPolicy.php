<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Enrollment;

class EnrollmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageClients();
    }

    public function view(User $user, Enrollment $enrollment): bool
    {
        return $user->canManageClients() ||
               $user->id === $enrollment->client->created_by ||
               $user->id === $enrollment->assigned_coach_id;
    }

    public function create(User $user): bool
    {
        return $user->canManageClients();
    }

    public function update(User $user, Enrollment $enrollment): bool
    {
        return $user->canManageClients() ||
               $user->id === $enrollment->assigned_coach_id;
    }

    public function delete(User $user, Enrollment $enrollment): bool
    {
        return $user->isAdmin() ||
               $user->id === $enrollment->client->created_by;
    }
}
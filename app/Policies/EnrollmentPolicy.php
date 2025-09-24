<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;
use App\Models\Program;

class EnrollmentPolicy
{
    /**
     * Determine if the user can enroll a client.
     */
    public function enroll(User $user, Client $client): bool
    {
        // Example: allow if user is admin OR the client's primary provider
        return $user->hasRole('admin') || $user->id === $client->primary_provider_id;
    }

    /**
     * Determine if the user can unenroll a client from a program.
     */
    public function unenroll(User $user, Client $client, Program $program): bool
    {
        return $user->hasRole('admin') || $user->id === $client->primary_provider_id;
    }

    /**
     * View enrollments for a client.
     */
    public function viewAny(User $user, Client $client): bool
    {
        return $user->hasRole('admin') || $user->id === $client->primary_provider_id;
    }
}

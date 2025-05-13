<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view clients');
    }

    public function view(User $user, Client $client): bool
    {
        return $user->can('view clients') ||
               $client->primary_provider_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('create clients');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->can('edit clients') ||
               $client->primary_provider_id === $user->id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->can('delete clients');
    }

    public function enroll(User $user, Client $client): bool
    {
        return $this->update($user, $client);
    }

    public function unenroll(User $user, Client $client, Program $program): bool
    {
        return $this->update($user, $client) &&
               $program->created_by === $user->id;
    }
}

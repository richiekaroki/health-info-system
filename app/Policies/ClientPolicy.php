<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->canManageClients();
    }

    public function view(User $user, Client $client): bool
    {
        return $user->canManageClients() ||
               $client->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->canManageClients();
    }

    public function update(User $user, Client $client): bool
    {
        return $user->canManageClients() ||
               $client->created_by === $user->id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->isAdmin() ||
               $client->created_by === $user->id;
    }
}

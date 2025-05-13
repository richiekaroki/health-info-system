<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view clients');
    }

    public function view(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('view clients') ||
               $client->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create clients');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('edit clients') ||
               $client->user_id === $user->id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('delete clients');
    }

    public function enroll(User $user, Client $client): bool
    {
        return $this->update($user, $client);
    }

    public function unenroll(User $user, Client $client): bool
    {
        return $this->update($user, $client);
    }
}

<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Program;
use App\Policies\ClientPolicy;
use App\Policies\ProgramPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        Program::class => ProgramPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Implicitly grant "admin" role all permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}

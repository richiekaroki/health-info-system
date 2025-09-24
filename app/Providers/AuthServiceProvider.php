<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Client;
use App\Models\Program;
use App\Policies\ClientPolicy;
use App\Policies\EnrollmentPolicy;
use App\Policies\ProgramPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Client::class  => EnrollmentPolicy::class,
        Program::class => EnrollmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // You can register additional gates here if needed
        // Gate::define('some-action', fn ($user) => $user->isAdmin());
    }
}
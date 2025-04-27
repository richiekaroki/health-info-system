<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Add Gate definitions here (recommended location)
        Gate::before(function ($user, $ability) {
            // Grant super admin full access
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // Or define specific abilities
        Gate::define('update-post', function ($user, $post) {
            return $user->id === $post->user_id;
        });
    }
}
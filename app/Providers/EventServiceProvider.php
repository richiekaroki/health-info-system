<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'order.placed' => [
            'App\Listeners\ProcessOrderPayment',
            'App\Listeners\SendOrderConfirmation',
        ],
    ];

    public function boot()
    {
        parent::boot();

        // Dynamic event registration
        Event::listen('user.login', function ($user) {
            $user->update(['last_login_at' => now()]);
        });
    }
}
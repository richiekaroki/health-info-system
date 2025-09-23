<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Models\Client;
use App\Models\User;
use App\Models\Program;
use App\Models\Enrollment;

use App\Observers\ClientObserver;
use App\Observers\UserObserver;
use App\Observers\ProgramObserver;
use App\Observers\EnrollmentObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        Client::observe(ClientObserver::class);
        User::observe(UserObserver::class);
        Program::observe(ProgramObserver::class);
        Enrollment::observe(EnrollmentObserver::class);
    }
}
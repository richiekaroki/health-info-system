<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity as ActivityLogger;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties([
                'attributes' => $user->getAttributes(),
            ])
            ->log('User created');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Get only the changed fields
        $changes = $user->getChanges();

        // Filter out noise (timestamps, remember_token, etc.)
        unset($changes['updated_at'], $changes['remember_token']);

        if (!empty($changes)) {
            ActivityLogger::causedBy(Auth::user())
                ->performedOn($user)
                ->withProperties([
                    'old' => $user->getOriginal($changes), // before
                    'new' => $changes,                     // after
                ])
                ->log('User updated');
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->log('User deleted');
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->log('User restored');
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->log('User permanently deleted');
    }
}
<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity as ActivityLogger;

class UserObserver
{
    public function created(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties([
                'attributes' => $user->getAttributes(),
            ])
            ->log('User created');
    }

    public function updated(User $user): void
    {
        $changes = $user->getChanges();
        unset($changes['updated_at'], $changes['remember_token']);

        if (!empty($changes)) {
            $oldValues = [];
            foreach ($changes as $field => $newValue) {
                $oldValues[$field] = $user->getOriginal($field);
            }

            ActivityLogger::causedBy(Auth::user())
                ->performedOn($user)
                ->withProperties([
                    'old' => $oldValues,
                    'new' => $changes,
                ])
                ->log('User updated');
        }
    }

    public function deleted(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->log('User deleted');
    }

    public function restored(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->log('User restored');
    }

    public function forceDeleted(User $user): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($user)
            ->log('User permanently deleted');
    }
}
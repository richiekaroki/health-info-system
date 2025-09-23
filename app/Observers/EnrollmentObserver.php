<?php

namespace App\Observers;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity as ActivityLogger;

class EnrollmentObserver
{
    public function created(Enrollment $enrollment): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($enrollment)
            ->withProperties([
                'attributes' => $enrollment->getAttributes(),
            ])
            ->log('Enrollment created');
    }

    public function updated(Enrollment $enrollment): void
    {
        $changes = $enrollment->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            $oldValues = [];
            foreach ($changes as $field => $newValue) {
                $oldValues[$field] = $enrollment->getOriginal($field);
            }

            ActivityLogger::causedBy(Auth::user())
                ->performedOn($enrollment)
                ->withProperties([
                    'old' => $oldValues,
                    'new' => $changes,
                ])
                ->log('Enrollment updated');
        }
    }

    public function deleted(Enrollment $enrollment): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($enrollment)
            ->log('Enrollment deleted');
    }

    public function restored(Enrollment $enrollment): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($enrollment)
            ->log('Enrollment restored');
    }

    public function forceDeleted(Enrollment $enrollment): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($enrollment)
            ->log('Enrollment permanently deleted');
    }
}
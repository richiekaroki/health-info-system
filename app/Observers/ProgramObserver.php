<?php

namespace App\Observers;

use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity as ActivityLogger;

class ProgramObserver
{
    public function created(Program $program): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($program)
            ->withProperties([
                'attributes' => $program->getAttributes(),
            ])
            ->log('Program created');
    }

    public function updated(Program $program): void
    {
        $changes = $program->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            $oldValues = [];
            foreach ($changes as $field => $newValue) {
                $oldValues[$field] = $program->getOriginal($field);
            }

            ActivityLogger::causedBy(Auth::user())
                ->performedOn($program)
                ->withProperties([
                    'old' => $oldValues,
                    'new' => $changes,
                ])
                ->log('Program updated');
        }
    }

    public function deleted(Program $program): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($program)
            ->log('Program deleted');
    }

    public function restored(Program $program): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($program)
            ->log('Program restored');
    }

    public function forceDeleted(Program $program): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($program)
            ->log('Program permanently deleted');
    }
}

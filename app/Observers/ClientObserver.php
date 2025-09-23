<?php

namespace App\Observers;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity as ActivityLogger;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($client)
            ->withProperties([
                'attributes' => $client->getAttributes(),
            ])
            ->log('Client created');
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        $changes = $client->getChanges();
        unset($changes['updated_at']); // remove noise

        if (!empty($changes)) {
            ActivityLogger::causedBy(Auth::user())
                ->performedOn($client)
                ->withProperties([
                    'old' => $client->getOriginal(), // values before update
                    'new' => $changes,               // values after update
                ])
                ->log('Client updated');
        }
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($client)
            ->log('Client deleted');
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($client)
            ->log('Client restored');
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        ActivityLogger::causedBy(Auth::user())
            ->performedOn($client)
            ->log('Client permanently deleted');
    }
}

<?php

namespace App\Observers;

use App\Models\Client;
use App\Notifications\ClientCreatedNotification;

class ClientObserver
{
    public function created(Client $client): void
    {
        // Notify assigned provider
        if ($client->primary_provider_id) {
            $client->primaryProvider->notify(
                new ClientCreatedNotification($client)
            );
        }

        // Log creation
        activity()
            ->performedOn($client)
            ->log('Client created');
    }

    public function updated(Client $client): void
    {
        activity()
            ->performedOn($client)
            ->withProperties($client->getChanges())
            ->log('Client updated');
    }

    public function deleted(Client $client): void
    {
        activity()
            ->performedOn($client)
            ->log('Client deleted');

        // Clean up relationships
        $client->programs()->detach();
    }
}

<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Client Registered')
            ->greeting('Hello!')
            ->line('A new client has been created in the system.')
            ->line('Name: ' . $this->client->full_name)
            ->line('Email: ' . $this->client->email)
            ->action('View Client', url("/clients/{$this->client->id}"))
            ->line('Thank you for using our system!');
    }

    public function toArray($notifiable): array
    {
        return [
            'id' => $this->client->id,
            'full_name' => $this->client->full_name,
            'email' => $this->client->email,
        ];
    }
}

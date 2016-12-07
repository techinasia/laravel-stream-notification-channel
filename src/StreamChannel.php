<?php

namespace NotificationChannels\GetStream;

use GetStream\Stream\Client;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;

class StreamChannel
{
    /** @var \GetStream\Stream\Client */
    protected $client;

    /**
     * Constructs an instance of the channel.
     *
     * @param \GetStream\Stream\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $args = $notifiable->routeNotificationFor('Stream');

        $data = $notification->toStream($notifiable)
            ->toArray();

        $feed = $this->client->feed(Arr::get($args, 'type'), Arr::get($args, 'id'));
        $feed->addActivity($data);
    }
}

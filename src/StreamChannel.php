<?php

namespace NotificationChannels\GetStream;

use Illuminate\Support\Arr;
use Techinasia\GetStream\StreamManager;
use Illuminate\Notifications\Notification;

class StreamChannel
{
    /** @var \Techinasia\GetStream\StreamManager */
    protected $manager;

    /**
     * Constructs an instance of the channel.
     *
     * @param \Techinasia\GetStream\StreamManager $manager
     */
    public function __construct(StreamManager $manager)
    {
        $this->manager = $manager;
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

        $payload = $notification->toStream($notifiable)->toArray();

        $client = $this->manager->application(Arr::get($payload, 'application'));

        $feed = $client->feed(Arr::get($args, 'type'), Arr::get($args, 'id'));
        $feed->addActivity(Arr::get($payload, 'data'));
    }
}

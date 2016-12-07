<?php

namespace NotificationChannels\GetStream\Tests;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    /**
     * Route notifications for the Stream channel.
     *
     * @return array
     */
    public function routeNotificationForStream()
    {
        return [
            'type' => 'user',
            'id' => '123'
        ];
    }
}

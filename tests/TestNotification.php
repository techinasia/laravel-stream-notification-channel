<?php

namespace NotificationChannels\GetStream\Tests;

use Illuminate\Notifications\Notification;
use NotificationChannels\GetStream\StreamMessage;

class TestNotification extends Notification
{
    public function toStream($notifiable)
    {
        return new StreamMessage();
    }
}

# Stream Notification Channel for Laravel

[![Dependency Status](https://gemnasium.com/techinasia/laravel-stream-notification-channel.svg)](https://gemnasium.com/techinasia/laravel-stream-notification-channel)
[![Build Status](https://travis-ci.org/techinasia/laravel-stream-notification-channel.svg)](https://travis-ci.org/techinasia/laravel-stream-notification-channel)
[![Coverage Status](https://coveralls.io/repos/github/techinasia/laravel-stream-notification-channel/badge.svg)](https://coveralls.io/github/techinasia/laravel-stream-notification-channel)
[![StyleCI Status](https://styleci.io/repos/75819599/shield)](https://styleci.io/repos/75819599)

> Use Laravel 5.3 notifications to send activities to Stream.

## Contents
- [Installation](#installation)
    - [Setting up Stream](#setting-up-getstream)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation
Install this package with Composer:
``` bash
composer require techinasia/laravel-stream-notification-channel-notification-channel
```

Register the service provider in your `config/app.php`:
``` php
NotificationChannels\GetStream\StreamServiceProvider::class
```

### Setting up Stream
This notification channel uses [techinasia/laravel-stream](https://github.com/techinasia/laravel-stream) to send notifications to Stream.

Publish all the vendor assets:
``` bash
php artisan vendor:publish
```

This will create a file called `stream.php` in the `config` folder. Create an application via [Stream's](https://getstream.io) admin interface and copy the API key and secret to the configuration file.

You can add more applications by adding more key/secret pairs to the configuration file:

``` php
'applications' => [
    'main' => [
        'key' => 'key1',
        'secret' => 'secret1',
    ],
    'foo' => [
        'key' => 'foo',
        'secret' => 'bar',
    ],
],
```

## Usage
Send notifications via Stream in your notification:

``` php
use NotificationChannels\GetStream\StreamChannel;
use NotificationChannels\GetStream\StreamMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    public function via($notifiable)
    {
        return [StreamChannel::class];
    }

    public function toStream($notifiable)
    {
        return (new StreamMessage())
            ->actor(1)
            ->verb('like')
            ->object(3)
            ->foreignId('post:42');
    }
}
```

You need to specify the ID and type of the notifiable by defining a `routeNotificationForStream` method on the entity:

``` php
/**
 * Notification routing information for Stream.
 *
 * @return array
 */
public function routeNotificationForStream()
{
    return [
        'type' => 'user',
        'id' => $this->id,
    ];
}
```

### Available Message methods
- `application(string $application)`: Sets the application to be used to send the notification.

You can set any attributes of the payload by calling the name of the attribute in camel case with the value as the parameter:

``` php
return (new StreamMessage())
    ->actor(1)
    ->verb('like')
    ->object(3);
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information for what has changed recently.

## Testing
``` bash
composer test
```

## Security
If you discover any security related issues, please email dev@techinasia.com instead of using the issues tracker.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

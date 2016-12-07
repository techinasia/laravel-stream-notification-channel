<?php

namespace NotificationChannels\GetStream;

use Illuminate\Support\ServiceProvider;
use GetStream\Stream\Client;

class StreamServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(StreamChannel::class)
            ->needs(Client::class)
            ->give(function () {
                $key = config('services.getstream.key');
                $secret = config('services.getstream.secret');

                return new Client($key, $secret);
            });

        $source = realpath(__DIR__.'/../config/services.php');

        $this->mergeConfigFrom($source, 'services');
    }
}

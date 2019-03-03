<?php

namespace NotificationChannels\GetStream\Tests;

use GetStream\Stream\Client;
use GetStream\Stream\Feed;
use Mockery;
use NotificationChannels\GetStream\StreamChannel;
use Orchestra\Testbench\TestCase;
use Techinasia\GetStream\StreamManager;

class StreamChannelTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->manager = Mockery::mock(StreamManager::class);
        $this->channel = new StreamChannel($this->manager);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSend()
    {
        $feedMock = Mockery::mock(Feed::class);
        $feedMock->shouldReceive('addActivity');

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('feed')->andReturn($feedMock);

        $this->manager->shouldReceive('application')->andReturn($client);

        $this->channel->send(new TestNotifiable(), new TestNotification());
    }
}

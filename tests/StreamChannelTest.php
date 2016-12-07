<?php

namespace NotificationChannels\GetStream\Tests;

use GetStream\Stream\Client;
use GetStream\Stream\Feed;
use Mockery;
use NotificationChannels\GetStream\StreamChannel;
use Orchestra\Testbench\TestCase;

class StreamChannelTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->channel = new StreamChannel($this->client);
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

        $this->client->shouldReceive('feed')->andReturn($feedMock);
        $this->channel->send(new TestNotifiable(), new TestNotification());
    }
}

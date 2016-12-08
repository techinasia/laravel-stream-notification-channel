<?php

namespace NotificationChannels\GetStream\Tests;

use NotificationChannels\GetStream\StreamMessage;

class StreamMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function testConstructor()
    {
        $message = new StreamMessage('test');
        $this->assertEquals('test', $message->toArray()['application']);
    }

    /** @test */
    public function testApplication()
    {
        $message = (new StreamMessage())->application('test');
        $this->assertEquals('test', $message->toArray()['application']);
    }

    /** @test */
    public function testMethodOverloading()
    {
        $message = (new StreamMessage())->verb('applied');
        $this->assertEquals('applied', $message->toArray()['data']['verb']);
    }

    /** @test */
    public function testTimeWithDateTime()
    {
        $message = (new StreamMessage())->time(new \DateTime('2020-01-01'));
        $this->assertEquals('2020-01-01T00:00:00+0000', $message->toArray()['data']['time']);
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function testTimeWithInvalidString()
    {
        $message = (new StreamMessage())->time('daosdjhaspdi');
    }

    /** @test */
    public function testTimeWithValidString()
    {
        $message = (new StreamMessage())->time('2020-01-01');
        $this->assertEquals('2020-01-01T00:00:00+0000', $message->toArray()['data']['time']);
    }
}

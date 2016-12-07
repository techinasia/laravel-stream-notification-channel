<?php

namespace NotificationChannels\GetStream;

use DateTime;
use DateTimeZone;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class StreamMessage implements Arrayable
{
    /** @var array */
    protected $data = [];

    /**
     * Overload methods to have setters for data payload.
     *
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->{$name}(...$arguments);
        }

        $value = ! empty($arguments) ? $arguments[0] : '';

        Arr::set($this->data, snake_case($name), $value);

        return $this;
    }

    /**
     * Support DateTime objects for `time` attribute.
     *
     * @param  string|DateTime $datetime
     */
    public function time($time = 'now')
    {
        if (! $time instanceof DateTime) {
            $time = new DateTime($time);
        }

        $timestamp = $time
            ->setTimezone(new DateTimeZone('UTC'))
            ->format(DateTime::ISO8601);

        Arr::set($this->data, 'time', $timestamp);

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}

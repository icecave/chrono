<?php
namespace Icecave\Chrono;

class Time
{
    public function __construct(
        $hours = 0,
        $minutes = 0,
        $seconds = 0,
        TimeZone $timeZone = null,
    ) {
        if ($timeZone === null) {
            $timeZone = new TimeZone;
        }

        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
        $this->timeZone = $timeZone;
    }

    public function hours()
    {
        return $this->hours;
    }

    public function minutes()
    {
        return $this->minutes;
    }

    public function seconds()
    {
        return $this->minutes;
    }

    public function timeZone()
    {
        return $this->timeZone;
    }

    public function compare(Time $time)
    {
        return $this->hours() - $time->hours()
            || $this->minutes() - $time->minutes()
            || $this->seconds() - $time->seconds()
            || $this->timeZone()->compare($time->timeZone());
    }

    public function __toString()
    {
        return sprintf(
            '%02d:%02d:%02d%s',
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            $this->timeZone()
        );
    }

    private $hours;
    private $minutes;
    private $seconds;
}

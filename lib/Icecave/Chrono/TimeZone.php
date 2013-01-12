<?php
namespace Icecave\Chrono;

class TimeZone
{
    public function __construct($hours = 0, $minutes = 0)
    {
        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    public function hours()
    {
        return $this->hours;
    }

    public function minutes()
    {
        return $this->minutes;
    }

    public function isUTC()
    {
        return $this->hours === 0
            && $this->minutes === 0;
    }

    public function compare(TimeZone $timeZone)
    {
        return $this->hours() - $timeZone->hours()
            || $this->minutes() - $timeZone->minutes();
    }

    public function __toString()
    {
        return sprintf(
            '%s%02d%02d',
            $this->hours < 0 ? '-' : '+',
            $this->hours,
            $this->minutes
        );
    }

    private $hours;
    private $minutes;
}

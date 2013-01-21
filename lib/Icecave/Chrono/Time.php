<?php
namespace Icecave\Chrono;

class Time
{
    /**
     * @param integer $hours
     * @param integer $minutes
     * @param integer $seconds
     * @param TimeZone|null $timeZone
     */
    public function __construct(
        $hours = 0,
        $minutes = 0,
        $seconds = 0,
        TimeZone $timeZone = null
    ) {
        if ($timeZone === null) {
            $timeZone = new TimeZone;
        }

        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
        $this->timeZone = $timeZone;
    }

    private $hours;
    private $minutes;
    private $seconds;
    private $timeZone;
}

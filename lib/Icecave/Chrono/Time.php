<?php
namespace Icecave\Chrono;

class Time implements IsoRepresentationInterface
{
    /**
     * @param integer       $hours
     * @param integer       $minutes
     * @param integer       $seconds
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

    /**
     * @link http://en.wikipedia.org/wiki/ISO_8601
     *
     * @return string A string representing this object in an ISO compatible format (HH:MM:SS[+-]HH:MM).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        return sprintf(
            '%$02d:%02d:%02d',
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            $this->timeZone()
        );
    }

    /**
     * @link http://en.wikipedia.org/wiki/ISO_8601
     *
     * @return string A string representing this object in an ISO compatible format (HH:MM:SS[+-]HH:MM).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $hours;
    private $minutes;
    private $seconds;
    private $timeZone;
}

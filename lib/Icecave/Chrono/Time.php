<?php
namespace Icecave\Chrono;

use Icecave\Chrono\TypeCheck\TypeCheck;

class Time implements TimeInterface
{
    /**
     * @param integer       $hours    The hours component of the time.
     * @param integer       $minutes  The minutes component of the time.
     * @param integer       $seconds  The seconds component of the time.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     */
    public function __construct(
        $hours = 0,
        $minutes = 0,
        $seconds = 0,
        TimeZone $timeZone = null
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if ($timeZone === null) {
            $timeZone = new TimeZone;
        }

        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
        $this->timeZone = $timeZone;
    }

    /**
     * @return integer The hours component of the time.
     */
    public function hours()
    {
        $this->typeCheck->hours(func_get_args());

        return $this->hours;
    }

    /**
     * @return integer The minutes component of the time.
     */
    public function minutes()
    {
        $this->typeCheck->minutes(func_get_args());

        return $this->minutes;
    }

    /**
     * @return integer The seconds component of the time.
     */
    public function seconds()
    {
        $this->typeCheck->seconds(func_get_args());

        return $this->seconds;
    }

    /**
     * Convert this time to a different timezone.
     *
     * @param TimeZone $timeZone The target timezone
     *
     * @return Time
     */
    public function toTimeZone(TimeZone $timeZone)
    {
        $this->typeCheck->toTimeZone(func_get_args());

        if ($this->timeZone()->compare($timeZone) === 0) {
            return $this;
        }

        $offset = $timeZone->offset()
                - $this->timeZone()->offset();

        return new Time(
            $this->hours(),
            $this->minutes(),
            $this->seconds() + $offset
        );
    }

    /**
     * Convert this time to the UTC timezone.
     *
     * @return Time
     */
    public function toUtc()
    {
        $this->typeCheck->toUtc(func_get_args());

        return $this->toTimeZone(new TimeZone);
    }

    /**
     * @return TimeZone The time zone of the time.
     */
    public function timeZone()
    {
        $this->typeCheck->timeZone(func_get_args());

        return $this->timeZone;
    }

    /**
     * Perform a {@see strcmp} style comparison with another time.
     *
     * @param Time $time The time to compare.
     *
     * @return integer 0 if $this and $time are equal, <0 if $this < $time, or >0 if $this > $time.
     */
    public function compare(Time $time)
    {
        $this->typeCheck->compare(func_get_args());

        throw new \Exception('Not implemented.');
    }

    /**
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
     * @return string A string representing this object in an ISO compatible format (HH:MM:SS[+-]HH:MM).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $typeCheck;
    private $hours;
    private $minutes;
    private $seconds;
    private $timeZone;
}

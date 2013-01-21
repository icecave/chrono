<?php
namespace Icecave\Chrono;

use Icecave\Chrono\TypeCheck\TypeCheck;

class Time implements IsoRepresentationInterface
{
    /**
     * @param integer       $hours    The hours component of the time.
     * @param integer       $minutes  The minutes component of the time.
     * @param integer       $seconds  The seconds component of the time.
     * @param TimeZone|null $timeZone The time zone of the time.
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
     * @return TimeZone The time zone of the time.
     */
    public function timeZone()
    {
        $this->typeCheck->timeZone(func_get_args());

        return $this->timeZone;
    }

    /**
     * Perform a {@see strcmp} style comparison with another time point.
     *
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return integer 0 if $this and $timePoint are equal, <0 if $this < $timePoint, or >0 if $this > $timePoint.
     */
    public function compare(Time $timePoint)
    {
        $this->typeCheck->compare(func_get_args());

        return strcmp($this->isoString(), $timePoint->isoString());
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

    private $typeCheck;
    private $hours;
    private $minutes;
    private $seconds;
    private $timeZone;
}

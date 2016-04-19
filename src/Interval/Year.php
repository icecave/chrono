<?php

namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use Icecave\Chrono\Detail\Calendar;
use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\Iso8601Interface;
use Icecave\Chrono\TimePointInterface;

class Year extends AbstractInterval implements Iso8601Interface
{
    /**
     * @param integer $ordinal The year number.
     */
    public function __construct($ordinal)
    {
        $this->ordinal = $ordinal;
    }

    /**
     * @param TimePointInterface $timePoint The time point to create from.
     *
     * @return Year The Year constructed from the given time point.
     */
    public static function fromTimePoint(TimePointInterface $timePoint)
    {
        return new self($timePoint->year());
    }

    /**
     * Standard year format:
     *   YYYY
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Calendar_dates
     *
     * Note: Negative years (BC) are not supported.
     *
     * @param string $isoString A string containing a year in any ISO-8601 compatible year format.
     *
     * @return Year The Year constructed from the ISO compatible string.
     */
    public static function fromIsoString($isoString)
    {
        $year = Iso8601::parseYear($isoString);

        return new self($year);
    }

    /**
     * @return integer The year number.
     */
    public function ordinal()
    {
        return $this->ordinal;
    }

    /**
     * @return Date The start of the interval.
     */
    public function start()
    {
        return new Date($this->ordinal(), 1, 1);
    }

    /**
     * @return Date The end of the interval.
     */
    public function end()
    {
        return new Date($this->ordinal() + 1, 1, 1);
    }

    /**
     * @return integer The number of days included in this interval.
     */
    public function numberOfDays()
    {
        return Calendar::daysInyear($this->ordinal());
    }

    /**
     * @return boolean True if this year interval represents a leap year; otherwise, false.
     */
    public function isLeapYear()
    {
        return Calendar::isLeapYear($this->ordinal());
    }

    /**
     * @return string A string representing this object in an ISO compatible year format (YYYY).
     */
    public function isoString()
    {
        return Iso8601::formatYear($this->ordinal());
    }

    /**
     * @return string A string representing this object in an ISO compatible year format (YYYY).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $ordinal;
}

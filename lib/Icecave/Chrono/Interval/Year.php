<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use Icecave\Chrono\Support\Calendar;

class Year extends AbstractInterval
{
    /**
     * @param integer $ordinal The year number.
     */
    public function __construct($ordinal)
    {
        $this->ordinal = $ordinal;
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
        return new Date($this->ordinal(), 12, 31);
    }

    /**
     * @return integer The number of days included in this interval.
     */
    public function numberOfDays()
    {
        if ($this->isLeapYear()) {
            return 366;
        }
        return 365;
    }

    /**
     * @return boolean True if this year interval represents a leap year; otherwise, false.
     */
    public function isLeapYear()
    {
        return Calendar::isLeapYear($this->ordinal());
    }

    public function __toString()
    {
        return sprintf('%04d', $this->ordinal());
    }

    private $ordinal;
}

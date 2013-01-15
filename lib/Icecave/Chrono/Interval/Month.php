<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use Icecave\Chrono\Support\Calendar;

class Month extends AbstractInterval
{
    /**
     * @param Year    $year     The year.
     * @param integer $ordinal  The month number.
     */
    public function __construct(Year $year, $ordinal)
    {
        $this->year    = $year;
        $this->ordinal = $ordinal;
    }

    /**
     * @return Year
     */
    public function year()
    {
        return $this->year;
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
        return new Date($this->year()->ordinal(), $this->ordinal(), 1);
    }

    /**
     * @return Date The end of the interval.
     */
    public function end()
    {
        return new Date($this->year()->ordinal(), $this->ordinal(), $this->numberOfDays());
    }

    /**
     * @return integer The number of days included in this interval.
     */
    public function numberOfDays()
    {
        Calendar::daysInMonth($this->year()->ordinal(), $this->ordinal());
    }

    public function __toString()
    {
        return sprintf('%s-%02d', $this->year(), $this->ordinal());
    }

    private $ordinal;
}

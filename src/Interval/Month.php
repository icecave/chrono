<?php

namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use Icecave\Chrono\Detail\Calendar;
use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\Iso8601Interface;
use Icecave\Chrono\TimePointInterface;

class Month extends AbstractInterval implements Iso8601Interface
{
    /**
     * @param Year    $year    The year.
     * @param integer $ordinal The month number.
     */
    public function __construct(Year $year, $ordinal)
    {
        $this->year    = $year;
        $this->ordinal = $ordinal;
    }

    /**
     * @param TimePointInterface $timePoint The time point to create from.
     *
     * @return Month The Month constructed from the given time point.
     */
    public static function fromTimePoint(TimePointInterface $timePoint)
    {
        return new self(
            new Year($timePoint->year()),
            $timePoint->month()
        );
    }

    /**
     * Standard year month format:
     *   YYYY-MM
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Calendar_dates
     *
     * @param string $isoString A string containing a year month in any ISO-8601 compatible year month format.
     *
     * @return Month The Month constructed from the ISO compatible string.
     */
    public static function fromIsoString($isoString)
    {
        $result = Iso8601::parseYearMonth($isoString);

        return new self(
            new Year($result['year']),
            $result['month']
        );
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
        return new Date($this->year()->ordinal(), $this->ordinal() + 1, 1);
    }

    /**
     * @return integer The number of days included in this interval.
     */
    public function numberOfDays()
    {
        return Calendar::daysInMonth($this->year()->ordinal(), $this->ordinal());
    }

    /**
     * @return string A string representing this object in an ISO compatible year month format (YYYY-MM).
     */
    public function isoString()
    {
        return Iso8601::formatYearMonth(
            $this->year()->ordinal(),
            $this->ordinal()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible year month format (YYYY-MM).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $ordinal;
}

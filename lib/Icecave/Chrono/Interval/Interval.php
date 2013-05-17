<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Iso8601Interface;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

/**
 * An interval represents a stretch of time between two known time points.
 */
class Interval extends AbstractInterval implements Iso8601Interface
{
    /**
     * @param TimePointInterface $start The start of the interval.
     * @param TimePointInterface $end   The start of the interval.
     */
    public function __construct(TimePointInterface $start, TimePointInterface $end)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if ($start->isGreaterThan($end)) {
            throw new InvalidArgumentException('Start point must not be greater than end point.');
        }

        $this->start = $start;
        $this->end = $end;

        parent::__construct();
    }

    /**
     * @param string $isoString A string containing an interval in any ISO-8601 compatible interval format.
     *
     * @return Interval The Interval constructed from the ISO compatible string and optional time zone.
     */
    public static function fromIsoString($isoString)
    {
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        // TO DO
        throw new Exception;

    }

    /**
     * @return TimePointInterface The start of the interval.
     */
    public function start()
    {
        $this->typeCheck->start(func_get_args());

        return $this->start;
    }

    /**
     * @return TimePointInterface The end of the interval.
     */
    public function end()
    {
        $this->typeCheck->end(func_get_args());

        return $this->end;
    }

    /**
     * @return string A string representing this object in an ISO compatible format (YYYY-MM-DDThh:mm:ss[+-]hh:mm/YYYY-MM-DDThh:mm:ss[+-]hh:mm).
     */
    public function isoStringDateTimes()
    {
        $this->typeCheck->isoStringDateTimes(func_get_args());

        $start = $this->start();
        $end = $this->end();

        return Iso8601::formatIntervalDateTimesParts(
            $start->year(),
            $start->month(),
            $start->day(),
            $start->hours(),
            $start->minutes(),
            $start->seconds(),
            $start->timeZone()->isoString(),
            $end->year(),
            $end->month(),
            $end->day(),
            $end->hours(),
            $end->minutes(),
            $end->seconds(),
            $end->timeZone()->isoString()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible format (YYYY-MM-DDThh:mm:ss[+-]hh:mm/PnYnMnDTnHnMnS).
     */
    public function isoStringDateTimeAndDuration()
    {
        $this->typeCheck->isoStringDateTimeAndDuration(func_get_args());

        return Iso8601::formatIntervalDateTimePartsAndDuration(
            $start->year(),
            $start->month(),
            $start->day(),
            $start->hours(),
            $start->minutes(),
            $start->seconds(),
            $start->timeZone()->isoString(),
            $this->duration()->isoString()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible format (YYYY-MM-DDThh:mm:ss[+-]hh:mm/YYYY-MM-DDThh:mm:ss[+-]hh:mm).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        return $this->isoStringDateTimes();
    }

    /**
     * @return string A string representing this object in an ISO compatible format (YYYY-MM-DDThh:mm:ss[+-]hh:mm/YYYY-MM-DDThh:mm:ss[+-]hh:mm).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $typeCheck;
    private $start;
    private $end;
}

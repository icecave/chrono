<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimeSpan\Period;

class SecondIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        parent::__construct(
            $interval,
            new Period(0, 0, 0, 0, 0, 1)
        );
    }

    /**
     * @return DateTime The current iteration date time.
     */
    public function current()
    {
        $timePoint = parent::current();

        return new DateTime(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day(),
            $timePoint->hour(),
            $timePoint->minute(),
            $timePoint->second(),
            $timePoint->timeZone()
        );
    }
}

<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimeSpan\Period;

class DayIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        parent::__construct(
            $interval,
            new Period(0, 0, 1)
        );
    }

    /**
     * @return Date The current iteration date.
     */
    public function current()
    {
        $timePoint = parent::current();

        return new Date(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day(),
            $timePoint->timeZone()
        );
    }
}

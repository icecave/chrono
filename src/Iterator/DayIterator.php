<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\Period;

class DayIterator extends TimeSpanIterator
{
    /**
     * @param TimePointInterface $startTime  The time to start iterating at.
     * @param integer|null       $iterations The number of iterations or null to iterate forever.
     */
    public function __construct(TimePointInterface $startTime, $iterations)
    {
        parent::__construct(
            $startTime,
            new Period(0, 0, 1),
            $iterations
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

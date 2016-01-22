<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\Period;

class MonthIterator extends TimeSpanIterator
{
    /**
     * @param TimePointInterface $startTime  The time to start iterating at.
     * @param integer|null       $iterations The number of iterations or null to iterate forever.
     */
    public function __construct(TimePointInterface $startTime, $iterations)
    {
        parent::__construct(
            $startTime,
            new Period(0, 1),
            $iterations
        );
    }

    /**
     * @return Month The current iteration month.
     */
    public function current()
    {
        return Month::fromTimePoint(parent::current());
    }
}

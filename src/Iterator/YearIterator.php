<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\Period;

class YearIterator extends TimeSpanIterator
{
    /**
     * @param TimePointInterface $startTime  The time to start iterating at.
     * @param integer|null       $iterations The number of iterations or null to iterate forever.
     */
    public function __construct(TimePointInterface $startTime, $iterations)
    {
        parent::__construct(
            $startTime,
            new Period(1),
            $iterations
        );
    }

    /**
     * @return Year The current iteration year.
     */
    public function current()
    {
        return Year::fromTimePoint(parent::current());
    }
}

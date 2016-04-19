<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\TimeSpan\Period;

class YearIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        parent::__construct(
            $interval,
            new Period(1)
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

<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\TimeSpan\Period;

class MonthIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        parent::__construct(
            $interval,
            new Period(0, 1)
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

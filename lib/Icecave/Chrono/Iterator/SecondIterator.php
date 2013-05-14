<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\Period;

class SecondIterator extends TimeSpanIterator
{
    /**
     * @param TimePointInterface $startTime The time to start iterating at.
     * @param integer|null $iterations The number of iterations or null to iterate forever.
     */
    public function __construct(TimePointInterface $startTime, $iterations)
    {
        parent::__construct(
            $startTime,
            new Period(0, 0, 0, 0, 0, 1),
            $iterations
        );
    }

// should this just use the parent? it only changes to documented return type.
    /**
     * @return DateTime The current iteration date time.
     */
    public function current()
    {
        return parent::current();
    }
}

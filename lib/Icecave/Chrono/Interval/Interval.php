<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\TimePointInterface;

/**
 * An interval represents a stretch of time between two known time points.
 */
class Interval extends AbstractInterval
{
    /**
     * @param TimePointInterface $start The start of the interval.
     * @param TimePointInterface $end The start of the interval.
     */
    public function __construct(TimePointInterface $start, TimePointInterface $end)
    {
        if ($start->compare($end) > 0) {
            throw new InvalidArgumentException('Start must not be greater than end point.');
        }

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return TimePointInterface The start of the interval.
     */
    public function start()
    {
        return $this->start;
    }

    /**
     * @return TimePointInterface The end of the interval.
     */
    public function end()
    {
        return $this->end;
    }

    private $start;
    private $end;
}

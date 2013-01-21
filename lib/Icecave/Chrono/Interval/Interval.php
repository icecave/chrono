<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;

/**
 * An interval represents a stretch of time between two known time points.
 */
class Interval extends AbstractInterval
{
    /**
     * @param TimePointInterface $start The start of the interval.
     * @param TimePointInterface $end   The start of the interval.
     */
    public function __construct(TimePointInterface $start, TimePointInterface $end)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

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

    private $typeCheck;
    private $start;
    private $end;
}

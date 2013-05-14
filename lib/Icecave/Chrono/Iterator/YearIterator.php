<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\Period;
use Icecave\Chrono\TypeCheck\TypeCheck;

class YearIterator extends TimeSpanIterator
{
    /**
     * @param TimePointInterface $startTime  The time to start iterating at.
     * @param integer|null       $iterations The number of iterations or null to iterate forever.
     */
    public function __construct(TimePointInterface $startTime, $iterations)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

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
        $this->typeCheck->current(func_get_args());

        return Year::fromTimePoint(parent::current());
    }

    private $typeCheck;
}

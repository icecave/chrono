<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\TimeSpan\Period;
use Icecave\Chrono\TypeCheck\TypeCheck;
use Iterator;

class YearIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

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
        $this->typeCheck->current(func_get_args());

        return Year::fromTimePoint(parent::current());
    }

    private $typeCheck;
}

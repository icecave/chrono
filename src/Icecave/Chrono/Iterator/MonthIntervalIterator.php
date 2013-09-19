<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\TimeSpan\Period;
use Icecave\Chrono\TypeCheck\TypeCheck;
use Iterator;

class MonthIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

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
        $this->typeCheck->current(func_get_args());

        return Month::fromTimePoint(parent::current());
    }

    private $typeCheck;
}

<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimeSpan\Period;
use Icecave\Chrono\TypeCheck\TypeCheck;
use Iterator;

class DayIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        parent::__construct(
            $interval,
            new Period(0, 0, 1)
        );
    }

    /**
     * @return Date The current iteration date.
     */
    public function current()
    {
        $this->typeCheck->current(func_get_args());

        $timePoint = parent::current();

        return new Date(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day(),
            $timePoint->timeZone()
        );
    }

    private $typeCheck;
}

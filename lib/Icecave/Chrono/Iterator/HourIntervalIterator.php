<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimeSpan\Period;
use Icecave\Chrono\TypeCheck\TypeCheck;
use Iterator;

class HourIntervalIterator extends IntervalIterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     */
    public function __construct(IntervalInterface $interval)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        parent::__construct(
            $interval,
            new Period(0, 0, 0, 1)
        );
    }

    /**
     * @return DateTime The current iteration date time.
     */
    public function current()
    {
        $this->typeCheck->current(func_get_args());

        $timePoint = parent::current();

        return new DateTime(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day(),
            $timePoint->hours(),
            $timePoint->minutes(),
            $timePoint->seconds(),
            $timePoint->timeZone()
        );
    }

    private $typeCheck;
}

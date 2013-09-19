<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;
use Iterator;

class IntervalIterator implements Iterator
{
    /**
     * @param IntervalInterface $interval The time interval to iterate over.
     * @param TimeSpanInterface $timeSpan The time span to increment by for each iteration.
     */
    public function __construct(IntervalInterface $interval, TimeSpanInterface $timeSpan)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->interval = $interval;
        $this->timeSpan = $timeSpan;

        $this->rewind();
    }

    /**
     * @return TimePointInterface The current iteration time point.
     */
    public function current()
    {
        $this->typeCheck->current(func_get_args());

        return $this->value;
    }

    /**
     * @return integer The current iteration index.
     */
    public function key()
    {
        $this->typeCheck->key(func_get_args());

        return $this->index;
    }

    /**
     * Advance to the next element.
     */
    public function next()
    {
        $this->typeCheck->next(func_get_args());

        ++$this->index;
        $this->value = $this->value->add($this->timeSpan);
    }

    /**
     * Rewind to the first element.
     */
    public function rewind()
    {
        $this->typeCheck->rewind(func_get_args());

        $this->index = 0;
        $this->value = $this->interval->start()->add(0);
    }

    /**
     * @return boolean True if the iterator points to a valid element; otherwise, false.
     */
    public function valid()
    {
        $this->typeCheck->valid(func_get_args());

        return $this->value->isLessThan($this->interval->end());
    }

    private $typeCheck;
    private $interval;
    private $timeSpan;
    private $index;
    private $value;
}

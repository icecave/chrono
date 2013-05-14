<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;
use Iterator;

class TimeSpanIterator implements Iterator
{
    /**
     * @param TimePointInterface $startTime  The time to start iterating at.
     * @param TimeSpanInterface  $timeSpan   The time span to increment by for each iteration.
     * @param integer|null       $iterations The number of iterations or null to iterate forever.
     */
    public function __construct(TimePointInterface $startTime, TimeSpanInterface $timeSpan, $iterations)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->startTime = $startTime->add(0);
        $this->timeSpan = $timeSpan;
        $this->iterations = $iterations;

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
        $this->value = $this->startTime;
    }

    /**
     * @return boolean True if the iterator points to a valid element; otherwise, false.
     */
    public function valid()
    {
        $this->typeCheck->valid(func_get_args());

        if ($this->iterations === null) {
            return true;
        }

        return $this->index < $this->iterations;
    }

    private $typeCheck;
    private $startTime;
    private $timeSpan;
    private $iterations;
    private $index;
    private $value;
}

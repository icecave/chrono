<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;
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
        $this->startTime  = $startTime->add(0);
        $this->timeSpan   = $timeSpan;
        $this->iterations = $iterations;

        $this->rewind();
    }

    /**
     * @return TimePointInterface The current iteration time point.
     */
    public function current()
    {
        return $this->value;
    }

    /**
     * @return integer The current iteration index.
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Advance to the next element.
     */
    public function next()
    {
        ++$this->index;
        $this->value = $this->value->add($this->timeSpan);
    }

    /**
     * Rewind to the first element.
     */
    public function rewind()
    {
        $this->index = 0;
        $this->value = $this->startTime;
    }

    /**
     * @return boolean True if the iterator points to a valid element; otherwise, false.
     */
    public function valid()
    {
        if ($this->iterations === null) {
            return true;
        }

        return $this->index < $this->iterations;
    }

    private $startTime;
    private $timeSpan;
    private $iterations;
    private $index;
    private $value;
}

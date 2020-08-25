<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use Icecave\Chrono\TimeSpan\Period;
use PHPUnit\Framework\TestCase;

class IntervalIteratorTest extends TestCase
{
    public function setUp(): void
    {
        $this->startTime = new Date(2012, 12, 20);
        $this->endTime   = new Date(2012, 12, 25);
        $this->timeSpan  = new Period(0, 0, 1);

        $this->interval = new Interval($this->startTime, $this->endTime);

        $this->expected = array(
            0 => new DateTime(2012, 12, 20),
            1 => new DateTime(2012, 12, 21),
            2 => new DateTime(2012, 12, 22),
            3 => new DateTime(2012, 12, 23),
            4 => new DateTime(2012, 12, 24),
        );
    }

    public function testIteration()
    {
        $iterator = new IntervalIterator($this->interval, $this->timeSpan);

        $this->assertEquals($this->expected, iterator_to_array($iterator, true));
    }
}

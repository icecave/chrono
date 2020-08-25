<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\Interval\Interval;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\Interval\Year;
use PHPUnit\Framework\TestCase;

class MonthIntervalIteratorTest extends TestCase
{
    public function setUp(): void
    {
        $this->year      = new Year(2010);
        $this->startTime = new Date(2010, 1, 25);
        $this->endTime   = new Date(2010, 6, 25);

        $this->interval = new Interval($this->startTime, $this->endTime);

        $this->expected = array(
            0 => new Month($this->year, 1),
            1 => new Month($this->year, 2),
            2 => new Month($this->year, 3),
            3 => new Month($this->year, 4),
            4 => new Month($this->year, 5),
        );
    }

    public function testIteration()
    {
        $iterator = new MonthIntervalIterator($this->interval);

        $this->assertEquals($this->expected, iterator_to_array($iterator, true));
    }
}

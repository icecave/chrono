<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\Interval\Interval;
use Icecave\Chrono\Interval\Year;
use PHPUnit\Framework\TestCase;

class YearIntervalIteratorTest extends TestCase
{
    public function setUp(): void
    {
        $this->startTime = new Date(2010, 12, 25);
        $this->endTime   = new Date(2015, 12, 25);

        $this->interval = new Interval($this->startTime, $this->endTime);

        $this->expected = [
            0 => new Year(2010),
            1 => new Year(2011),
            2 => new Year(2012),
            3 => new Year(2013),
            4 => new Year(2014),
        ];
    }

    public function testIteration()
    {
        $iterator = new YearIntervalIterator($this->interval);

        $this->assertEquals($this->expected, iterator_to_array($iterator, true));
    }
}

<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use PHPUnit\Framework\TestCase;

class HourIntervalIteratorTest extends TestCase
{
    protected function setUp()
    {
        $this->startTime = new DateTime(2010, 12, 25, 10, 20, 30);
        $this->endTime   = new DateTime(2010, 12, 25, 15, 20, 30);

        $this->interval = new Interval($this->startTime, $this->endTime);

        $this->expected = array(
            0 => new DateTime(2010, 12, 25, 10, 20, 30),
            1 => new DateTime(2010, 12, 25, 11, 20, 30),
            2 => new DateTime(2010, 12, 25, 12, 20, 30),
            3 => new DateTime(2010, 12, 25, 13, 20, 30),
            4 => new DateTime(2010, 12, 25, 14, 20, 30),
        );
    }

    public function testIteration()
    {
        $iterator = new HourIntervalIterator($this->interval);

        $this->assertEquals($this->expected, iterator_to_array($iterator, true));
    }
}

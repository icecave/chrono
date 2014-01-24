<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use PHPUnit_Framework_TestCase;

class SecondIntervalIteratorTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->startTime = new DateTime(2010, 12, 25, 10, 20, 30);
        $this->endTime   = new DateTime(2010, 12, 25, 10, 20, 35);

        $this->interval = new Interval($this->startTime, $this->endTime);

        $this->expected = array(
            0 => new DateTime(2010, 12, 25, 10, 20, 30),
            1 => new DateTime(2010, 12, 25, 10, 20, 31),
            2 => new DateTime(2010, 12, 25, 10, 20, 32),
            3 => new DateTime(2010, 12, 25, 10, 20, 33),
            4 => new DateTime(2010, 12, 25, 10, 20, 34)
        );
    }

    public function testIteration()
    {
        $iterator = new SecondIntervalIterator($this->interval);

        $this->assertEquals($this->expected, iterator_to_array($iterator, true));
    }
}

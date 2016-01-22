<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use PHPUnit_Framework_TestCase;

class DayIteratorTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->startTime = new Date(2012, 12, 10);

        $this->expected = array(
            0 => new Date(2012, 12, 10),
            1 => new Date(2012, 12, 11),
            2 => new Date(2012, 12, 12),
            3 => new Date(2012, 12, 13),
            4 => new Date(2012, 12, 14),
        );
    }

    public function testIteration()
    {
        $iterator = new DayIterator($this->startTime, 5);

        $result = array();
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;
        }

        $this->assertEquals($this->expected, $result);
    }

    public function testIterationUnlimited()
    {
        $iterator = new DayIterator($this->startTime, null);

        $result = array();
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;

            if ($index >= 4) {
                break;
            }
        }

        $this->assertEquals($this->expected, $result);
    }
}

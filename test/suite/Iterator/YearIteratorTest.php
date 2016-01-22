<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\Interval\Year;
use PHPUnit_Framework_TestCase;

class YearIteratorTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->startTime = new Date(2010, 12, 25);

        $this->expected = array(
            0 => new Year(2010),
            1 => new Year(2011),
            2 => new Year(2012),
            3 => new Year(2013),
            4 => new Year(2014),
        );
    }

    public function testIteration()
    {
        $iterator = new YearIterator($this->startTime, 5);

        $result = array();
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;
        }

        $this->assertEquals($this->expected, $result);
    }

    public function testIterationUnlimited()
    {
        $iterator = new YearIterator($this->startTime, null);

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

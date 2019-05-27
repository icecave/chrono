<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\DateTime;
use PHPUnit\Framework\TestCase;

class SecondIteratorTest extends TestCase
{
    protected function setUp()
    {
        $this->startTime = new DateTime(2012, 12, 25, 10, 20, 30);

        $this->expected = array(
            0 => new DateTime(2012, 12, 25, 10, 20, 30),
            1 => new DateTime(2012, 12, 25, 10, 20, 31),
            2 => new DateTime(2012, 12, 25, 10, 20, 32),
            3 => new DateTime(2012, 12, 25, 10, 20, 33),
            4 => new DateTime(2012, 12, 25, 10, 20, 34),
        );
    }

    public function testIteration()
    {
        $iterator = new SecondIterator($this->startTime, 5);

        $result = array();
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;
        }

        $this->assertEquals($this->expected, $result);
    }

    public function testIterationUnlimited()
    {
        $iterator = new SecondIterator($this->startTime, null);

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

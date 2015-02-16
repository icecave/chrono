<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\DateTime;
use PHPUnit_Framework_TestCase;

class HourIteratorTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->startTime = new DateTime(2012, 12, 25, 10, 20, 30);

        $this->expected = array(
            0 => new DateTime(2012, 12, 25, 10, 20, 30),
            1 => new DateTime(2012, 12, 25, 11, 20, 30),
            2 => new DateTime(2012, 12, 25, 12, 20, 30),
            3 => new DateTime(2012, 12, 25, 13, 20, 30),
            4 => new DateTime(2012, 12, 25, 14, 20, 30),
        );
    }

    public function testIteration()
    {
        $iterator = new HourIterator($this->startTime, 5);

        $result = array();
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;
        }

        $this->assertEquals($this->expected, $result);
    }

    public function testIterationUnlimited()
    {
        $iterator = new HourIterator($this->startTime, null);

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

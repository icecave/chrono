<?php
namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\Interval\Year;
use PHPUnit_Framework_TestCase;

class MonthIteratorTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->startTime = new Date(2010, 1, 25);
        $this->year      = new Year(2010);

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
        $iterator = new MonthIterator($this->startTime, 5);

        $result = array();
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;
        }

        $this->assertEquals($this->expected, $result);
    }

    public function testIterationUnlimited()
    {
        $iterator = new MonthIterator($this->startTime, null);

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

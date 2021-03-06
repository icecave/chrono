<?php

namespace Icecave\Chrono\Iterator;

use Icecave\Chrono\Date;
use PHPUnit\Framework\TestCase;

class DayIteratorTest extends TestCase
{
    public function setUp(): void
    {
        $this->startTime = new Date(2012, 12, 10);

        $this->expected = [
            0 => new Date(2012, 12, 10),
            1 => new Date(2012, 12, 11),
            2 => new Date(2012, 12, 12),
            3 => new Date(2012, 12, 13),
            4 => new Date(2012, 12, 14),
        ];
    }

    public function testIteration()
    {
        $iterator = new DayIterator($this->startTime, 5);

        $result = [];
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;
        }

        $this->assertEquals($this->expected, $result);
    }

    public function testIterationUnlimited()
    {
        $iterator = new DayIterator($this->startTime, null);

        $result = [];
        foreach ($iterator as $index => $value) {
            $result[$index] = $value;

            if ($index >= 4) {
                break;
            }
        }

        $this->assertEquals($this->expected, $result);
    }
}

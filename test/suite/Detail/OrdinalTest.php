<?php

namespace Icecave\Chrono\Detail;

use PHPUnit\Framework\TestCase;

class OrdinalTest extends TestCase
{
    /**
     * @dataProvider makeTimestampData
     */
    public function testSuffix($number, $suffix)
    {
        $this->assertSame($suffix, Ordinal::suffix($number));
    }

    public function makeTimestampData()
    {
        return [
            [0,  'th'],
            [1,  'st'],
            [2,  'nd'],
            [3,  'rd'],
            [4,  'th'],
            [5,  'th'],
            [6,  'th'],
            [7,  'th'],
            [8,  'th'],
            [9,  'th'],
            [10, 'th'],
            [11, 'th'],
            [12, 'th'],
            [13, 'th'],
            [14, 'th'],
            [15, 'th'],
            [16, 'th'],
            [17, 'th'],
            [18, 'th'],
            [19, 'th'],
            [20, 'th'],

            [100, 'th'],
            [101, 'st'],
            [102, 'nd'],
            [103, 'rd'],
            [104, 'th'],
            [105, 'th'],
            [106, 'th'],
            [107, 'th'],
            [108, 'th'],
            [109, 'th'],
            [110, 'th'],
            [111, 'th'],
            [112, 'th'],
            [113, 'th'],
            [114, 'th'],
            [115, 'th'],
            [116, 'th'],
            [117, 'th'],
            [118, 'th'],
            [119, 'th'],
            [120, 'th'],
        ];
    }
}

<?php
namespace Icecave\Chrono\Support;

use PHPUnit_Framework_TestCase;

class OrdinalTest extends PHPUnit_Framework_TestCase
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
        return array(
            array(0,  'th'),
            array(1,  'st'),
            array(2,  'nd'),
            array(3,  'rd'),
            array(4,  'th'),
            array(5,  'th'),
            array(6,  'th'),
            array(7,  'th'),
            array(8,  'th'),
            array(9,  'th'),
            array(10, 'th'),
            array(11, 'th'),
            array(12, 'th'),
            array(13, 'th'),
            array(14, 'th'),
            array(15, 'th'),
            array(16, 'th'),
            array(17, 'th'),
            array(18, 'th'),
            array(19, 'th'),
            array(20, 'th'),

            array(100, 'th'),
            array(101, 'st'),
            array(102, 'nd'),
            array(103, 'rd'),
            array(104, 'th'),
            array(105, 'th'),
            array(106, 'th'),
            array(107, 'th'),
            array(108, 'th'),
            array(109, 'th'),
            array(110, 'th'),
            array(111, 'th'),
            array(112, 'th'),
            array(113, 'th'),
            array(114, 'th'),
            array(115, 'th'),
            array(116, 'th'),
            array(117, 'th'),
            array(118, 'th'),
            array(119, 'th'),
            array(120, 'th'),
        );
    }
}

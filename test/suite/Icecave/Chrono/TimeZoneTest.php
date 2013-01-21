<?php
namespace Icecave\Chrono;

use PHPUnit_Framework_TestCase;

class TimeZoneTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_timeZone = new TimeZone(36000, false);
    }

    public function testConstructorDefaults()
    {
        $timeZone = new TimeZone;
        $this->assertSame(0, $timeZone->offset());
        $this->assertFalse($timeZone->isDst());
    }

    public function testIsUtc()
    {
        $this->assertFalse($this->_timeZone->isUtc());

        $timeZone = new TimeZone(0, true);
        $this->assertFalse($timeZone->isUtc());

        $timeZone = new TimeZone(36000, false);
        $this->assertFalse($timeZone->isUtc());

        $timeZone = new TimeZone;
        $this->assertTrue($timeZone->isUtc());

        $timeZone = new TimeZone(0, false);
        $this->assertTrue($timeZone->isUtc());
    }

    public function testCompareEquals()
    {
        $a = new TimeZone(0, false);
        $b = new TimeZone(0, false);

        $this->assertSame(0, $a->compare($b));
        $this->assertSame(0, $b->compare($a));

        $a = new TimeZone(0, true);
        $b = new TimeZone(0, true);

        $this->assertSame(0, $a->compare($b));
        $this->assertSame(0, $b->compare($a));
    }

    public function testCompareLess()
    {
        $a = new TimeZone(0);
        $b = new TimeZone(1);

        $this->assertLessThan(0, $a->compare($b));
        $this->assertGreaterThan(0, $b->compare($a));

        $a = new TimeZone(0, false);
        $b = new TimeZone(0, true);

        $this->assertLessThan(0, $a->compare($b));
        $this->assertGreaterThan(0, $b->compare($a));
    }

    public function testCompareGreater()
    {
        $a = new TimeZone(1);
        $b = new TimeZone(0);

        $this->assertGreaterThan(0, $a->compare($b));
        $this->assertLessThan(0, $b->compare($a));

        $a = new TimeZone(0, true);
        $b = new TimeZone(0, false);

        $this->assertGreaterThan(0, $a->compare($b));
        $this->assertLessThan(0, $b->compare($a));
    }
}

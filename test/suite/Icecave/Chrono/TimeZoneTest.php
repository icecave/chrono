<?php
namespace Icecave\Chrono;

use Eloquent\Liberator\Liberator;
use Phake;
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

    public function testConstructorRounding()
    {
        $timeZone = new TimeZone(60 + 15);
        $this->assertSame(60, $timeZone->offset());

        $timeZone = new TimeZone(60 - 15);
        $this->assertSame(60, $timeZone->offset());

        $timeZone = new TimeZone(60);
        $this->assertSame(60, $timeZone->offset());
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
        $b = new TimeZone(60);

        $this->assertLessThan(0, $a->compare($b));
        $this->assertGreaterThan(0, $b->compare($a));

        $a = new TimeZone(0, false);
        $b = new TimeZone(0, true);

        $this->assertLessThan(0, $a->compare($b));
        $this->assertGreaterThan(0, $b->compare($a));
    }

    public function testCompareGreater()
    {
        $a = new TimeZone(60);
        $b = new TimeZone(0);

        $this->assertGreaterThan(0, $a->compare($b));
        $this->assertLessThan(0, $b->compare($a));

        $a = new TimeZone(0, true);
        $b = new TimeZone(0, false);

        $this->assertGreaterThan(0, $a->compare($b));
        $this->assertLessThan(0, $b->compare($a));
    }

    public function testFormat()
    {
        $formatter = Phake::mock(__NAMESPACE__ . '\Format\FormatterInterface');
        Liberator::liberateClass(__NAMESPACE__ . '\Format\DefaultFormatter')->instance = $formatter;

        Phake::when($formatter)
            ->formatTimeZone(Phake::anyParameters())
            ->thenReturn('<1st>')
            ->thenReturn('<2nd>');

        $result = $this->_timeZone->format('H:m');
        $this->assertSame('<1st>', $result);

        $result = $this->_timeZone->format('H:m', $formatter);
        $this->assertSame('<2nd>', $result);

        Phake::verify($formatter, Phake::times(2))->formatTimeZone($this->_timeZone, 'H:m');
    }

    public function testIsoString()
    {
        $this->assertEquals('+10:00', $this->_timeZone->isoString());
        $this->assertEquals('+10:00', $this->_timeZone->__toString());

        // UTC must be "positive zero" ...
        $timeZone = new TimeZone;
        $this->assertEquals('+00:00', $timeZone->isoString());
        $this->assertEquals('+00:00', $timeZone->__toString());

        // Negative ...
        $timeZone = new TimeZone(-19800);
        $this->assertEquals('-05:30', $timeZone->isoString());
        $this->assertEquals('-05:30', $timeZone->__toString());
    }
}

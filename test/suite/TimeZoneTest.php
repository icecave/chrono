<?php

namespace Icecave\Chrono;

use Eloquent\Liberator\Liberator;
use Phake;
use PHPUnit\Framework\TestCase;

/**
 * @covers Icecave\Chrono\TimeZone
 * @covers Icecave\Chrono\Detail\Iso8601
 */
class TimeZoneTest extends TestCase
{
    public function setUp(): void
    {
        $this->timeZone = new TimeZone(36000, false);
    }

    public function testConstructorDefaults()
    {
        $timeZone = new TimeZone();
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
        $this->assertFalse($this->timeZone->isUtc());

        $timeZone = new TimeZone(0, true);
        $this->assertFalse($timeZone->isUtc());

        $timeZone = new TimeZone(36000, false);
        $this->assertFalse($timeZone->isUtc());

        $timeZone = new TimeZone();
        $this->assertTrue($timeZone->isUtc());

        $timeZone = new TimeZone(0, false);
        $this->assertTrue($timeZone->isUtc());
    }

    public function testCompareWithNotComparableException()
    {
        $this->expectException('Icecave\Parity\Exception\NotComparableException');
        $this->timeZone->compare('foo');
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

    public function testIsEqualTo()
    {
        $a = new TimeZone(0, false);
        $b = new TimeZone(0, false);
        $c = new TimeZone(0, true);

        $this->assertTrue($a->isEqualTo($a));
        $this->assertTrue($a->isEqualTo($b));
        $this->assertTrue($b->isEqualTo($a));
        $this->assertFalse($a->isEqualTo($c));

        $a = new TimeZone(0, true);
        $b = new TimeZone(0, true);
        $c = new TimeZone(0, false);

        $this->assertTrue($a->isEqualTo($a));
        $this->assertTrue($a->isEqualTo($b));
        $this->assertTrue($b->isEqualTo($a));
        $this->assertFalse($a->isEqualTo($c));
    }

    public function testIsNotEqualTo()
    {
        $a = new TimeZone(0, false);
        $b = new TimeZone(0, false);
        $c = new TimeZone(0, true);

        $this->assertTrue($a->isNotEqualTo($c));
        $this->assertFalse($a->isNotEqualTo($a));
        $this->assertFalse($b->isNotEqualTo($a));
        $this->assertFalse($a->isNotEqualTo($b));

        $a = new TimeZone(0, true);
        $b = new TimeZone(0, true);
        $c = new TimeZone(0, false);

        $this->assertTrue($a->isNotEqualTo($c));
        $this->assertFalse($a->isNotEqualTo($a));
        $this->assertFalse($b->isNotEqualTo($a));
        $this->assertFalse($a->isNotEqualTo($b));
    }

    public function testIsGreaterThan()
    {
        $a = new TimeZone(60);
        $b = new TimeZone(0);

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($b->isGreaterThan($a));

        $a = new TimeZone(0, true);
        $b = new TimeZone(0, false);

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($b->isGreaterThan($a));
    }

    public function testIsLessThan()
    {
        $a = new TimeZone(0);
        $b = new TimeZone(60);

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($b->isLessThan($a));

        $a = new TimeZone(0, false);
        $b = new TimeZone(0, true);

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($b->isLessThan($a));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $a = new TimeZone(60);
        $b = new TimeZone(0);

        $this->assertTrue($a->isGreaterThanOrEqualTo($a));
        $this->assertTrue($a->isGreaterThanOrEqualTo($b));
        $this->assertFalse($b->isGreaterThanOrEqualTo($a));

        $a = new TimeZone(0, true);
        $b = new TimeZone(0, false);

        $this->assertTrue($a->isGreaterThanOrEqualTo($a));
        $this->assertTrue($a->isGreaterThanOrEqualTo($b));
        $this->assertFalse($b->isGreaterThanOrEqualTo($a));
    }

    public function testIsLessThanOrEqualTo()
    {
        $a = new TimeZone(0);
        $b = new TimeZone(60);

        $this->assertTrue($a->isLessThanOrEqualTo($a));
        $this->assertTrue($a->isLessThanOrEqualTo($b));
        $this->assertFalse($b->isLessThanOrEqualTo($a));

        $a = new TimeZone(0, false);
        $b = new TimeZone(0, true);

        $this->assertTrue($a->isLessThanOrEqualTo($a));
        $this->assertTrue($a->isLessThanOrEqualTo($b));
        $this->assertFalse($b->isLessThanOrEqualTo($a));
    }

    public function testFormat()
    {
        $formatter                                                                     = Phake::mock(__NAMESPACE__ . '\Format\FormatterInterface');
        Liberator::liberateClass(__NAMESPACE__ . '\Format\DefaultFormatter')->instance = $formatter;

        Phake::when($formatter)
            ->formatTimeZone(Phake::anyParameters())
            ->thenReturn('<1st>')
            ->thenReturn('<2nd>');

        $result = $this->timeZone->format('H:m');
        $this->assertSame('<1st>', $result);

        $result = $this->timeZone->format('H:m', $formatter);
        $this->assertSame('<2nd>', $result);

        Phake::verify($formatter, Phake::times(2))->formatTimeZone($this->timeZone, 'H:m');
    }

    public function testIsoString()
    {
        $this->assertEquals('+10:00', $this->timeZone->isoString());
        $this->assertEquals('+10:00', $this->timeZone->__toString());

        // UTC must be "positive zero" ...
        $timeZone = new TimeZone();
        $this->assertEquals('+00:00', $timeZone->isoString());
        $this->assertEquals('+00:00', $timeZone->__toString());

        // Negative ...
        $timeZone = new TimeZone(-19800);
        $this->assertEquals('-05:30', $timeZone->isoString());
        $this->assertEquals('-05:30', $timeZone->__toString());
    }

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = TimeZone::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStrings()
    {
        return [
            'UTC Z'            => ['Z',      '+00:00'],
            'Positive Short'   => ['+01',    '+01:00'],
            'Positive Basic'   => ['+0120',  '+01:20'],
            'Positive Exteded' => ['+01:20', '+01:20'],
            'Negative Short'   => ['-01',    '-01:00'],
            'Negative Basic'   => ['-0120',  '-01:20'],
            'Negative Exteded' => ['-01:20', '-01:20'],
        ];
    }

    /**
     * @dataProvider validIsoStringsWithNegativeZero
     */
    public function testFromIsoStringWithNegativeZero($isoString, $expected)
    {
        $result = TimeZone::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStringsWithNegativeZero()
    {
        return [
            'Negative Short'   => ['-00',    '+00:00'],
            'Negative Basic'   => ['-0000',  '+00:00'],
            'Negative Exteded' => ['-00:00', '+00:00'],
        ];
    }

    public function testFromIsoStringWithDst()
    {
        $timeZoneDst = TimeZone::fromIsoString('Z', true);
        $this->assertTrue($timeZoneDst->isDst());

        $timeZoneNoDst = TimeZone::fromIsoString('Z', false);
        $this->assertFalse($timeZoneNoDst->isDst());
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoTimeZone($isoString, $expected)
    {
        $this->expectException('InvalidArgumentException', $expected);
        TimeZone::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return [
            'UTC lower case z'                  => ['z',       'Invalid ISO time zone: "z".'],
            'Missing prefix'                    => ['12',      'Invalid ISO time zone: "12".'],
            'Missing prefix'                    => ['1234',    'Invalid ISO time zone: "1234".'],
            'Missing prefix'                    => ['12:34',   'Invalid ISO time zone: "12:34".'],
            'Not enough digits'                 => ['+1',      'Invalid ISO time zone: "+1".'],
            'Not enough digits'                 => ['+123',    'Invalid ISO time zone: "+123".'],
            'Not enough digits, missing prefix' => ['1',       'Invalid ISO time zone: "1".'],
            'Not enough digits, missing prefix' => ['123',     'Invalid ISO time zone: "123".'],
            'Invalid prefix space'              => [' 12',     'Invalid ISO time zone: " 12".'],
            'Invalid prefix symbol'             => ['#12',     'Invalid ISO time zone: "#12".'],
            'Invalid prefix letter'             => ['A12',     'Invalid ISO time zone: "A12".'],
            'Invalid letter, missing prefix'    => ['Y',       'Invalid ISO time zone: "Y".'],
            'Invalid letters, missing prefix'   => ['YY',      'Invalid ISO time zone: "YY".'],
            'Invalid letters, missing prefix'   => ['YYY',     'Invalid ISO time zone: "YYY".'],
            'Invalid letters, missing prefix'   => ['YYYY',    'Invalid ISO time zone: "YYYY".'],
            'Invalid letter'                    => ['+Y',      'Invalid ISO time zone: "+Y".'],
            'Invalid letters'                   => ['+YY',     'Invalid ISO time zone: "+YY".'],
            'Invalid letters'                   => ['+YYY',    'Invalid ISO time zone: "+YYY".'],
            'Invalid letters'                   => ['+YYYY',   'Invalid ISO time zone: "+YYYY".'],
            'Invalid letter, and colon'         => ['+Y:',     'Invalid ISO time zone: "+Y:".'],
            'Invalid letters, and colon'        => ['+YY:',    'Invalid ISO time zone: "+YY:".'],
            'Invalid letters, and colon'        => ['+YYY:',   'Invalid ISO time zone: "+YYY:".'],
            'Invalid letters, and colon'        => ['+YYYY:',  'Invalid ISO time zone: "+YYYY:".'],
            'Invalid colon'                     => ['+1:',     'Invalid ISO time zone: "+1:".'],
            'Invalid colon'                     => ['+1:2',    'Invalid ISO time zone: "+1:2".'],
            'Invalid colon'                     => ['+1:2:',   'Invalid ISO time zone: "+1:2:".'],
            'Invalid colon'                     => ['+12:',    'Invalid ISO time zone: "+12:".'],
            'Invalid colon'                     => ['+12:3',   'Invalid ISO time zone: "+12:3".'],
            'Invalid colon'                     => ['+12:34:', 'Invalid ISO time zone: "+12:34:".'],
            'Invalid colon, missing prefix'     => ['1:',      'Invalid ISO time zone: "1:".'],
            'Invalid colon, missing prefix'     => ['1:2',     'Invalid ISO time zone: "1:2".'],
            'Invalid colon, missing prefix'     => ['1:2:',    'Invalid ISO time zone: "1:2:".'],
            'Invalid colon, missing prefix'     => ['12:',     'Invalid ISO time zone: "12:".'],
            'Invalid colon, missing prefix'     => ['12:3',    'Invalid ISO time zone: "12:3".'],
            'Invalid colon, missing prefix'     => ['12:34:',  'Invalid ISO time zone: "12:34:".'],
        ];
    }
}

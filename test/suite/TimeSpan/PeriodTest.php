<?php

namespace Icecave\Chrono\TimeSpan;

use DateInterval;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;
use Phake;
use PHPUnit\Framework\TestCase;

/**
 * @covers Icecave\Chrono\TimeSpan\Period
 * @covers Icecave\Chrono\Detail\Iso8601
 */
class PeriodTest extends TestCase
{
    public function setUp(): void
    {
        $this->period = new Period(1, 2, 3, 4, 5, 6);

        $this->before = new Period(1, 2, 3, 4, 5, 5);
        $this->same   = new Period(1, 2, 3, 4, 5, 6);
        $this->after  = new Period(1, 2, 3, 4, 5, 7);
    }

    public function testYears()
    {
        $this->assertSame(1, $this->period->years());
    }

    public function testMonths()
    {
        $this->assertSame(2, $this->period->months());
    }

    public function testDays()
    {
        $this->assertSame(3, $this->period->days());
    }

    public function testHours()
    {
        $this->assertSame(4, $this->period->hours());
    }

    public function testMinutes()
    {
        $this->assertSame(5, $this->period->minutes());
    }

    public function testSeconds()
    {
        $this->assertSame(6, $this->period->seconds());
    }

    public function testApproximateTotalSeconds()
    {
        $this->assertSame(37091106, $this->period->approximateTotalSeconds());
    }

    public function testCompareWithNotComparableException()
    {
        $this->expectException('Icecave\Parity\Exception\NotComparableException');
        $this->period->compare('foo');
    }

    public function testCompare()
    {
        $this->assertGreaterThan(0, $this->period->compare($this->before));
        $this->assertSame(0, $this->period->compare($this->same));
        $this->assertLessThan(0, $this->period->compare($this->after));
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->period->isEqualTo($this->before));
        $this->assertTrue($this->period->isEqualTo($this->same));
        $this->assertFalse($this->period->isEqualTo($this->after));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->period->isNotEqualTo($this->before));
        $this->assertFalse($this->period->isNotEqualTo($this->same));
        $this->assertTrue($this->period->isNotEqualTo($this->after));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->period->isGreaterThan($this->before));
        $this->assertFalse($this->period->isGreaterThan($this->same));
        $this->assertFalse($this->period->isGreaterThan($this->after));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->period->isLessThan($this->before));
        $this->assertFalse($this->period->isLessThan($this->same));
        $this->assertTrue($this->period->isLessThan($this->after));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->period->isGreaterThanOrEqualTo($this->before));
        $this->assertTrue($this->period->isGreaterThanOrEqualTo($this->same));
        $this->assertFalse($this->period->isGreaterThanOrEqualTo($this->after));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->period->isLessThanOrEqualTo($this->before));
        $this->assertTrue($this->period->isLessThanOrEqualTo($this->same));
        $this->assertTrue($this->period->isLessThanOrEqualTo($this->after));
    }

    public function testIsEmpty()
    {
        $this->assertFalse($this->period->isEmpty());

        $period = new Period();

        $this->assertTrue($period->isEmpty());
    }

    public function testInverse()
    {
        $result = $this->period->inverse();

        $this->assertSame(-1, $result->years());
        $this->assertSame(-2, $result->months());
        $this->assertSame(-3, $result->days());
        $this->assertSame(-4, $result->hours());
        $this->assertSame(-5, $result->minutes());
        $this->assertSame(-6, $result->seconds());
    }

    public function testResolveToSeconds()
    {
        $timeZone  = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $this->assertSame(36993906, $this->period->resolveToSeconds($timePoint));
    }

    public function testResolveToDuration()
    {
        $timeZone  = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $duration = $this->period->resolveToDuration($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Duration', $duration);
        $this->assertSame(36993906, $duration->totalSeconds());
    }

    public function testResolveToPeriod()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame($this->period, $this->period->resolveToPeriod($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToInterval()
    {
        $timeZone  = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->period->resolveToInterval($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\Interval\IntervalInterface', $result);
        $this->assertSame('2012-01-02T10:20:30+10:00', $result->start()->isoString());
        $this->assertSame('2013-03-05T14:25:36+10:00', $result->end()->isoString());
    }

    public function testResolveToIntervalInverse()
    {
        $period    = new Period(0, 0, 0, 0, 0, -10);
        $timePoint = new DateTime(2012, 1, 2, 0, 0, 0);

        $result = $period->resolveToInterval($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\Interval\IntervalInterface', $result);
        $this->assertSame('2012-01-01T23:59:50+00:00', $result->start()->isoString());
        $this->assertSame('2012-01-02T00:00:00+00:00', $result->end()->isoString());
    }

    public function testResolveToTimePoint()
    {
        $timeZone  = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->period->resolveToTimePoint($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\TimePointInterface', $result);
        $this->assertSame('2013-03-05T14:25:36+10:00', $result->isoString());
    }

    public function testNativeDateInterval()
    {
        $period = Period::fromIsoString('P1Y2M3DT4H5M6S');
        $native = $period->nativeDateInterval();

        $this->assertSame($native->format('P%yY%mM%dDT%hH%iM%sS'), $period->isoString());
    }

    public function testAdd()
    {
        $period1 = new Period(1, 2, 3, 4, 5, 6);
        $period2 = new Period(2, 3, 4, 5, 6, 7);

        $this->assertEquals(new Period(3, 5, 7, 9, 11, 13), $period1->add($period2));
    }

    public function testAddWithPeriod()
    {
        $period1 = new Period(1, 2, 3, 4, 5, 6);
        $period2 = new Duration(86400 + 3600 + 60 + 1);

        $this->assertEquals(new Period(1, 2, 4, 5, 6, 7), $period1->add($period2));
    }

    public function testAddWithInteger()
    {
        $period1 = new Period(1, 2, 3, 4, 5, 6);
        $period2 = 86400 + 3600 + 60 + 1;

        $this->assertEquals(new Period(1, 2, 4, 5, 6, 7), $period1->add($period2));
    }

    public function testSubtract()
    {
        $period1 = new Period(3, 5, 7, 9, 11, 13);
        $period2 = new Period(2, 3, 4, 5, 6, 7);

        $this->assertEquals(new Period(1, 2, 3, 4, 5, 6), $period1->subtract($period2));
    }

    public function testSubtractWithDuration()
    {
        $period1 = new Period(3, 5, 7, 9, 11, 13);
        $period2 = new Duration(86400 + 3600 + 60 + 1);

        $this->assertEquals(new Period(3, 5, 6, 8, 10, 12), $period1->subtract($period2));
    }

    public function testSubtractWithInteger()
    {
        $period1 = new Period(3, 5, 7, 9, 11, 13);
        $period2 = 86400 + 3600 + 60 + 1;

        $this->assertEquals(new Period(3, 5, 6, 8, 10, 12), $period1->subtract($period2));
    }

    public function testString()
    {
        $this->assertSame('1y 2m 3d 04:05:06', $this->period->string());
    }

    public function testIsoString()
    {
        $this->assertSame('P1Y2M3DT4H5M6S', $this->period->isoString());
        $this->assertSame('P1Y2M3DT4H5M6S', $this->period->__toString());
    }

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = Period::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStrings()
    {
        return [
            // Duration Format - Empty/Zero
            'Zero weeks'                                => ['P0W',                     'PT0S'],
            'Zero years'                                => ['P0Y',                     'PT0S'],
            'Zero months'                               => ['P0M',                     'PT0S'],
            'Zero days'                                 => ['P0D',                     'PT0S'],
            'Zero hours'                                => ['PT0H',                    'PT0S'],
            'Zero minutes'                              => ['PT0M',                    'PT0S'],
            'Zero seconds'                              => ['PT0S',                    'PT0S'],
            'Zero YMD'                                  => ['P0Y0M0D',                 'PT0S'],
            'Zero HMS'                                  => ['PT0H0M0S',                'PT0S'],
            'Zero YMD HMS'                              => ['P0Y0M0DT0H0M0S',          'PT0S'],
            'Zero months and minutes'                   => ['P0MT0M',                  'PT0S'],

            // Duration Format - Weeks
            'Weeks 1'                                   => ['P1W',                     'P7D'],
            'Weeks 3'                                   => ['P3W',                     'P21D'],
            'Weeks 10'                                  => ['P10W',                    'P70D'],
            'Weeks zero prefix'                         => ['P03W',                    'P21D'],

            // Duration Format - Single digit
            'Years single digit'                         => ['P2Y',                    'P2Y'],
            'Months single digit'                        => ['P2M',                    'P2M'],
            'Days single digit'                          => ['P2D',                    'P2D'],
            'Hours single digit'                         => ['PT2H',                   'PT2H'],
            'Minutes single digit'                       => ['PT2M',                   'PT2M'],
            'Seconds single digit'                       => ['PT2S',                   'PT2S'],

            // Duration Format - Double digit
            'Years double digit'                         => ['P12Y',                   'P12Y'],
            'Months double digit'                        => ['P12M',                   'P12M'],
            'Days double digit'                          => ['P12D',                   'P12D'],
            'Hours double digit'                         => ['PT12H',                  'PT12H'],
            'Minutes double digit'                       => ['PT12M',                  'PT12M'],
            'Seconds double digit'                       => ['PT12S',                  'PT12S'],

            // Duration Format - Single digit with zero prefix
            'Years single digit zero prefix'             => ['P05Y',                   'P5Y'],
            'Months single digit zero prefix'            => ['P05M',                   'P5M'],
            'Days single digit zero prefix'              => ['P05D',                   'P5D'],
            'Hours single digit zero prefix'             => ['PT05H',                  'PT5H'],
            'Minutes single digit zero prefix'           => ['PT05M',                  'PT5M'],
            'Seconds single digit zero prefix'           => ['PT05S',                  'PT5S'],

            // Duration Format - Double digit with zero prefix
            'Years double digit zero prefix'             => ['P012Y',                  'P12Y'],
            'Months double digit zero prefix'            => ['P012M',                  'P12M'],
            'Days double digit zero prefix'              => ['P012D',                  'P12D'],
            'Hours double digit zero prefix'             => ['PT012H',                 'PT12H'],
            'Minutes double digit zero prefix'           => ['PT012M',                 'PT12M'],
            'Seconds double digit zero prefix'           => ['PT012S',                 'PT12S'],

            // Duration Format - Multiple periods
            'Years and months'                          => ['P2Y3M',                   'P2Y3M'],
            'Months and days'                           => ['P2M3D',                   'P2M3D'],
            'Days and hours'                            => ['P2DT3H',                  'P2DT3H'],
            'Hours and minutes'                         => ['PT2H3M',                  'PT2H3M'],
            'Minutes and seconds'                       => ['PT2M3S',                  'PT2M3S'],
            'Seconds and years'                         => ['P3YT2S',                  'P3YT2S'],

            // Duration Format - Full periods
            'Full YMD'                                  => ['P1Y2M3D',                 'P1Y2M3D'],
            'Full HMS'                                  => ['PT4H5M6S',                'PT4H5M6S'],
            'Full YMD HMS'                              => ['P1Y2M3DT4H5M6S',          'P1Y2M3DT4H5M6S'],

            // Date Time Format - Misc
            'Date time basic all zero'                  => ['P00000000T000000',        'PT0S'],
            'Date time extended all zero'               => ['P0000-00-00T00:00:00',    'PT0S'],
            'Date time basic'                           => ['P00010203T040506',        'P1Y2M3DT4H5M6S'],
            'Date time extended'                        => ['P0001-02-03T04:05:06',    'P1Y2M3DT4H5M6S'],
        ];
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoString($isoString, $expected)
    {
        $this->expectException('InvalidArgumentException', $expected);
        Period::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return [
            // Duration Format - Empty/Zero
            'Missing P'                                 => ['',                        'Invalid ISO duration: "".'],
            'Missing P has digit'                       => ['2',                       'Invalid ISO duration: "2".'],
            'Missing P has digit designator'            => ['D',                       'Invalid ISO duration: "D".'],
            'Missing P has digit and designator'        => ['2D',                      'Invalid ISO duration: "2D".'],
            'Missing P has digit and designator dupe'   => ['2D2D',                    'Invalid ISO duration: "2D2D".'],
            'Missing P has spaces'                      => [' ',                       'Invalid ISO duration: " ".'],
            'Empty P'                                   => ['P',                       'Invalid ISO duration: "P".'],
            'Empty P with ending T'                     => ['PT',                      'Invalid ISO duration: "PT".'],
            'P with space prefix'                       => [' P',                      'Invalid ISO duration: " P".'],
            'P with space postfix'                      => ['P ',                      'Invalid ISO duration: "P ".'],
            'P with space pre/post fix'                 => [' P ',                     'Invalid ISO duration: " P ".'],

            // Duration Format - Misc
            'Missing period designator'                 => ['P2',                      'Invalid ISO duration: "P2".'],
            'Duplicate period designator'               => ['P2Y2Y',                   'Invalid ISO duration: "P2Y2Y".'],
            'Missing T before hours designator'         => ['P2H',                     'Invalid ISO duration: "P2H".'],
            'Missing T before seconds designator'       => ['P2S',                     'Invalid ISO duration: "P2S".'],
            'Invalid negative period'                   => ['P-2Y',                    'Invalid ISO duration: "P-2Y".'],
            'Years after T time marker'                 => ['PT2Y',                    'Invalid ISO duration: "PT2Y".'],
            'Days after T time marker'                  => ['PT2D',                    'Invalid ISO duration: "PT2D".'],
            'Years and days after T time marker'        => ['PT1Y2M3D',                'Invalid ISO duration: "PT1Y2M3D".'],
            'Ends with T'                               => ['P0YT',                    'Invalid ISO duration: "P0YT".'],
            'Ends with T'                               => ['P1YT',                    'Invalid ISO duration: "P1YT".'],
            'Ends with T'                               => ['P1MT',                    'Invalid ISO duration: "P1MT".'],
            'Ends with T'                               => ['P1DT',                    'Invalid ISO duration: "P1DT".'],
            'Ends with T'                               => ['P1Y1MT',                  'Invalid ISO duration: "P1Y1MT".'],
            'Ends with T'                               => ['P1M1DT',                  'Invalid ISO duration: "P1M1DT".'],
            'Ends with T'                               => ['P1Y1DT',                  'Invalid ISO duration: "P1Y1DT".'],

            // Date Time Format - Basic
            'Date time basic missing P'                 => ['00010203T040506',         'Invalid ISO duration: "00010203T040506".'],
            'Date time basic missing T'                 => ['P00010203 040506',        'Invalid ISO duration: "P00010203 040506".'],
            'Date time basic missing P and T'           => ['00010203 040506',         'Invalid ISO duration: "00010203 040506".'],
            'Date time basic space prefix'              => [' P00010203T040506',       'Invalid ISO duration: " P00010203T040506".'],
            'Date time basic space postfix'             => ['P00010203T040506 ',       'Invalid ISO duration: "P00010203T040506 ".'],
            'Date time basic space pre/post fix'        => [' P00010203T040506 ',      'Invalid ISO duration: " P00010203T040506 ".'],
            'Date time basic months exceeds moduli'     => ['P00001300T000000',        'Invalid ISO duration: "P00001300T000000".'],
            'Date time basic days exceeds moduli'       => ['P00000032T000000',        'Invalid ISO duration: "P00000032T000000".'],
            'Date time basic hours exceeds moduli'      => ['P00000000T250000',        'Invalid ISO duration: "P00000000T250000".'],
            'Date time basic minutes exceeds moduli'    => ['P00000000T006000',        'Invalid ISO duration: "P00000000T006000".'],
            'Date time basic seconds exceeds moduli'    => ['P00000000T000060',        'Invalid ISO duration: "P00000000T000060".'],

            // Date Time Format - Extended
            'Date time extended missing P'              => ['0001-02-03T04:05:06',     'Invalid ISO duration: "0001-02-03T04:05:06".'],
            'Date time extended missing T'              => ['P0001-02-03 04:05:06',    'Invalid ISO duration: "P0001-02-03 04:05:06".'],
            'Date time extended missing P and T'        => ['0001-02-03 04:05:06',     'Invalid ISO duration: "0001-02-03 04:05:06".'],
            'Date time extended space prefix'           => [' P0001-02-03T04:05:06',   'Invalid ISO duration: " P0001-02-03T04:05:06".'],
            'Date time extended space postfix'          => ['P0001-02-03T04:05:06 ',   'Invalid ISO duration: "P0001-02-03T04:05:06 ".'],
            'Date time extended space pre/post fix'     => [' P0001-02-03T04:05:06 ',  'Invalid ISO duration: " P0001-02-03T04:05:06 ".'],
            'Date time extended months exceeds moduli'  => ['P0000-13-00T00:00:00',    'Invalid ISO duration: "P0000-13-00T00:00:00".'],
            'Date time extended days exceeds moduli'    => ['P0000-00-32T00:00:00',    'Invalid ISO duration: "P0000-00-32T00:00:00".'],
            'Date time extended hours exceeds moduli'   => ['P0000-00-00T25:00:00',    'Invalid ISO duration: "P0000-00-00T25:00:00".'],
            'Date time extended minutes exceeds moduli' => ['P0000-00-00T00:60:00',    'Invalid ISO duration: "P0000-00-00T00:60:00".'],
            'Date time extended seconds exceeds moduli' => ['P0000-00-00T00:00:60',    'Invalid ISO duration: "P0000-00-00T00:00:60".'],
        ];
    }

    public function testFromNativeDateInterval()
    {
        $native = new DateInterval('P1Y2M3DT4H5M6S');
        $result = Period::fromNativeDateInterval($native);

        $this->assertSame(1, $result->years());
        $this->assertSame(2, $result->months());
        $this->assertSame(3, $result->days());
        $this->assertSame(4, $result->hours());
        $this->assertSame(5, $result->minutes());
        $this->assertSame(6, $result->seconds());
    }

    public function testFromNativeDateIntervalWithInvert()
    {
        $native         = new DateInterval('P1Y2M3DT4H5M6S');
        $native->invert = 1;

        $result = Period::fromNativeDateInterval($native);

        $this->assertSame(-1, $result->years());
        $this->assertSame(-2, $result->months());
        $this->assertSame(-3, $result->days());
        $this->assertSame(-4, $result->hours());
        $this->assertSame(-5, $result->minutes());
        $this->assertSame(-6, $result->seconds());
    }
}

<?php
namespace Icecave\Chrono\TimeSpan;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;
use Phake;
use PHPUnit_Framework_TestCase;

class PeriodTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->period = new Period(1, 2, 3, 4, 5, 6);

        $this->before = new Period(1, 2, 3, 4, 5, 5);
        $this->same = new Period(1, 2, 3, 4, 5, 6);
        $this->after = new Period(1, 2, 3, 4, 5, 7);
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

        $period = new Period;

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
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $this->assertSame(36993906, $this->period->resolveToSeconds($timePoint));
    }

    public function testResolveToDuration()
    {
        $timeZone = new TimeZone(36000);
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
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->period->resolveToInterval($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\Interval\IntervalInterface', $result);
        $this->assertSame('2012-01-02T10:20:30+10:00', $result->start()->isoString());
        $this->assertSame('2013-03-05T14:25:36+10:00', $result->end()->isoString());
    }

    public function testResolveToTimePoint()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->period->resolveToTimePoint($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\TimePointInterface', $result);
        $this->assertSame('2013-03-05T14:25:36+10:00', $result->isoString());
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
        return array(
            // Duration Format - Empty/Zero
            'Empty'                                     => array('P',                       'P'),
            'Empty with T'                              => array('PT',                      'P'),
            'Zero years ending with T'                  => array('P0YT',                    'P'),
            'Zero months ending with T'                 => array('P0MT',                    'P'),
            'Zero days ending with T'                   => array('P0DT',                    'P'),
            'Zero weeks'                                => array('P0W',                     'P'),
            'Zero years'                                => array('P0Y',                     'P'),
            'Zero months'                               => array('P0M',                     'P'),
            'Zero days'                                 => array('P0D',                     'P'),
            'Zero hours'                                => array('PT0H',                    'P'),
            'Zero minutes'                              => array('PT0M',                    'P'),
            'Zero seconds'                              => array('PT0S',                    'P'),
            'Zero YMD'                                  => array('P0Y0M0D',                 'P'),
            'Zero HMS'                                  => array('PT0H0M0S',                'P'),
            'Zero YMD HMS'                              => array('P0Y0M0DT0H0M0S',          'P'),
            'Zero months and minutes'                   => array('P0MT0M',                  'P'),

            // Duration Format - Weeks
            'Weeks 1'                                   => array('P1W',                     'P7D'),
            'Weeks 3'                                   => array('P3W',                     'P21D'),
            'Weeks 10'                                  => array('P10W',                    'P70D'),
            'Weeks zero prefix'                         => array('P03W',                    'P21D'),

            // Duration Format - Single digit
            'Years single digit'                         => array('P2Y',                    'P2Y'),
            'Months single digit'                        => array('P2M',                    'P2M'),
            'Days single digit'                          => array('P2D',                    'P2D'),
            'Hours single digit'                         => array('PT2H',                   'PT2H'),
            'Minutes single digit'                       => array('PT2M',                   'PT2M'),
            'Seconds single digit'                       => array('PT2S',                   'PT2S'),
            'Years single digit ending T'                => array('P2YT',                   'P2Y'),
            'Months single digit ending T'               => array('P2MT',                   'P2M'),
            'Days single digit ending T'                 => array('P2DT',                   'P2D'),

            // Duration Format - Double digit
            'Years double digit'                         => array('P12Y',                   'P12Y'),
            'Months double digit'                        => array('P12M',                   'P12M'),
            'Days double digit'                          => array('P12D',                   'P12D'),
            'Hours double digit'                         => array('PT12H',                  'PT12H'),
            'Minutes double digit'                       => array('PT12M',                  'PT12M'),
            'Seconds double digit'                       => array('PT12S',                  'PT12S'),
            'Years double digit ending T'                => array('P12YT',                  'P12Y'),
            'Months double digit ending T'               => array('P12MT',                  'P12M'),
            'Days double digit ending T'                 => array('P12DT',                  'P12D'),

            // Duration Format - Single digit with zero prefix
            'Years single digit zero prefix'             => array('P05Y',                   'P5Y'),
            'Months single digit zero prefix'            => array('P05M',                   'P5M'),
            'Days single digit zero prefix'              => array('P05D',                   'P5D'),
            'Hours single digit zero prefix'             => array('PT05H',                  'PT5H'),
            'Minutes single digit zero prefix'           => array('PT05M',                  'PT5M'),
            'Seconds single digit zero prefix'           => array('PT05S',                  'PT5S'),
            'Years single digit zero prefix ending T'    => array('P05YT',                  'P5Y'),
            'Months single digit zero prefix ending T'   => array('P05MT',                  'P5M'),
            'Days single digit zero prefix ending T'     => array('P05DT',                  'P5D'),

            // Duration Format - Double digit with zero prefix
            'Years double digit zero prefix'             => array('P012Y',                  'P12Y'),
            'Months double digit zero prefix'            => array('P012M',                  'P12M'),
            'Days double digit zero prefix'              => array('P012D',                  'P12D'),
            'Hours double digit zero prefix'             => array('PT012H',                 'PT12H'),
            'Minutes double digit zero prefix'           => array('PT012M',                 'PT12M'),
            'Seconds double digit zero prefix'           => array('PT012S',                 'PT12S'),
            'Years double digit zero prefix ending T'    => array('P012YT',                 'P12Y'),
            'Months double digit zero prefix ending T'   => array('P012MT',                 'P12M'),
            'Days double digit zero prefix ending T'     => array('P012DT',                 'P12D'),

            // Duration Format - Multiple periods
            'Years and months'                          => array('P2Y3M',                   'P2Y3M'),
            'Months and days'                           => array('P2M3D',                   'P2M3D'),
            'Days and hours'                            => array('P2DT3H',                  'P2DT3H'),
            'Hours and minutes'                         => array('PT2H3M',                  'PT2H3M'),
            'Minutes and seconds'                       => array('PT2M3S',                  'PT2M3S'),
            'Seconds and years'                         => array('P3YT2S',                  'P3YT2S'),

            // Duration Format - Full periods
            'Full YMD'                                  => array('P1Y2M3D',                 'P1Y2M3D'),
            'Full YMD ending with T'                    => array('P1Y2M3DT',                'P1Y2M3D'),
            'Full HMS'                                  => array('PT4H5M6S',                'PT4H5M6S'),
            'Full YMD HMS'                              => array('P1Y2M3DT4H5M6S',          'P1Y2M3DT4H5M6S'),

            // Date Time Format - Misc
            'Date time basic all zero'                  => array('P00000000T000000',        'P'),
            'Date time extended all zero'               => array('P0000-00-00T00:00:00',    'P'),
            'Date time basic'                           => array('P00010203T040506',        'P1Y2M3DT4H5M6S'),
            'Date time extended'                        => array('P0001-02-03T04:05:06',    'P1Y2M3DT4H5M6S'),
        );
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoString($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        $result = Period::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return array(
            // Duration Format - Empty/Zero
            'Missing P'                                 => array('',                        'Invalid ISO duration format: "".'),
            'Missing P has digit'                       => array('2',                       'Invalid ISO duration format: "2".'),
            'Missing P has digit designator'            => array('D',                       'Invalid ISO duration format: "D".'),
            'Missing P has digit and designator'        => array('2D',                      'Invalid ISO duration format: "2D".'),
            'Missing P has digit and designator dupe'   => array('2D2D',                    'Invalid ISO duration format: "2D2D".'),
            'Missing P has spaces'                      => array(' ',                       'Invalid ISO duration format: " ".'),
            'P with space prefix'                       => array(' P',                      'Invalid ISO duration format: " P".'),
            'P with space postfix'                      => array('P ',                      'Invalid ISO duration format: "P ".'),
            'P with space pre/post fix'                 => array(' P ',                     'Invalid ISO duration format: " P ".'),

            // Duration Format - Misc
            'Missing period designator'                 => array('P2',                      'Invalid ISO duration format: "P2".'),
            'Duplicate period designator'               => array('P2Y2Y',                   'Invalid ISO duration format: "P2Y2Y".'),
            'Missing T before hours designator'         => array('P2H',                     'Invalid ISO duration format: "P2H".'),
            'Missing T before seconds designator'       => array('P2S',                     'Invalid ISO duration format: "P2S".'),
            'Invalid negative period'                   => array('P-2Y',                    'Invalid ISO duration format: "P-2Y".'),
            'Years after T time marker'                 => array('PT2Y',                    'Invalid ISO duration format: "PT2Y".'),
            'Days after T time marker'                  => array('PT2D',                    'Invalid ISO duration format: "PT2D".'),
            'Years and days after T time marker'        => array('PT1Y2M3D',                'Invalid ISO duration format: "PT1Y2M3D".'),

            // Date Time Format - Basic
            'Date time basic missing P'                 => array('00010203T040506',         'Invalid ISO duration format: "00010203T040506".'),
            'Date time basic missing T'                 => array('P00010203 040506',        'Invalid ISO duration format: "P00010203 040506".'),
            'Date time basic missing P and T'           => array('00010203 040506',         'Invalid ISO duration format: "00010203 040506".'),
            'Date time basic space prefix'              => array(' P00010203T040506',       'Invalid ISO duration format: " P00010203T040506".'),
            'Date time basic space postfix'             => array('P00010203T040506 ',       'Invalid ISO duration format: "P00010203T040506 ".'),
            'Date time basic space pre/post fix'        => array(' P00010203T040506 ',      'Invalid ISO duration format: " P00010203T040506 ".'),
            'Date time basic months exceeds moduli'     => array('P00001300T000000',        'Invalid ISO duration format: "P00001300T000000".'),
            'Date time basic days exceeds moduli'       => array('P00000032T000000',        'Invalid ISO duration format: "P00000032T000000".'),
            'Date time basic hours exceeds moduli'      => array('P00000000T250000',        'Invalid ISO duration format: "P00000000T250000".'),
            'Date time basic minutes exceeds moduli'    => array('P00000000T006000',        'Invalid ISO duration format: "P00000000T006000".'),
            'Date time basic seconds exceeds moduli'    => array('P00000000T000060',        'Invalid ISO duration format: "P00000000T000060".'),

            // Date Time Format - Extended
            'Date time extended missing P'              => array('0001-02-03T04:05:06',     'Invalid ISO duration format: "0001-02-03T04:05:06".'),
            'Date time extended missing T'              => array('P0001-02-03 04:05:06',    'Invalid ISO duration format: "P0001-02-03 04:05:06".'),
            'Date time extended missing P and T'        => array('0001-02-03 04:05:06',     'Invalid ISO duration format: "0001-02-03 04:05:06".'),
            'Date time extended space prefix'           => array(' P0001-02-03T04:05:06',   'Invalid ISO duration format: " P0001-02-03T04:05:06".'),
            'Date time extended space postfix'          => array('P0001-02-03T04:05:06 ',   'Invalid ISO duration format: "P0001-02-03T04:05:06 ".'),
            'Date time extended space pre/post fix'     => array(' P0001-02-03T04:05:06 ',  'Invalid ISO duration format: " P0001-02-03T04:05:06 ".'),
            'Date time extended months exceeds moduli'  => array('P0000-13-00T00:00:00',    'Invalid ISO duration format: "P0000-13-00T00:00:00".'),
            'Date time extended days exceeds moduli'    => array('P0000-00-32T00:00:00',    'Invalid ISO duration format: "P0000-00-32T00:00:00".'),
            'Date time extended hours exceeds moduli'   => array('P0000-00-00T25:00:00',    'Invalid ISO duration format: "P0000-00-00T25:00:00".'),
            'Date time extended minutes exceeds moduli' => array('P0000-00-00T00:60:00',    'Invalid ISO duration format: "P0000-00-00T00:60:00".'),
            'Date time extended seconds exceeds moduli' => array('P0000-00-00T00:00:60',    'Invalid ISO duration format: "P0000-00-00T00:00:60".'),
        );
    }
}

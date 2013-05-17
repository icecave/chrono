<?php
namespace Icecave\Chrono\TimeSpan;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;
use Phake;
use PHPUnit_Framework_TestCase;

class DurationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->duration = Duration::fromComponents(1, 2, 3, 4, 5);

        $this->before = Duration::fromComponents(1, 2, 3, 4, 4);
        $this->same = Duration::fromComponents(1, 2, 3, 4, 5);
        $this->after = Duration::fromComponents(1, 2, 3, 4, 6);
    }

    public function testWeeks()
    {
        $this->assertSame(1, $this->duration->weeks());
    }

    public function testDays()
    {
        $this->assertSame(2, $this->duration->days());
    }

    public function testHours()
    {
        $this->assertSame(3, $this->duration->hours());
    }

    public function testMinutes()
    {
        $this->assertSame(4, $this->duration->minutes());
    }

    public function testSeconds()
    {
        $this->assertSame(5, $this->duration->seconds());
    }

    public function testTotalDays()
    {
        $this->assertSame(9, $this->duration->totalDays());
    }

    public function testTotalHours()
    {
        $this->assertSame(219, $this->duration->totalHours());
    }

    public function testTotalMinutes()
    {
        $this->assertSame(13144, $this->duration->totalMinutes());
    }

    public function testTotalSeconds()
    {
        $this->assertSame(788645, $this->duration->totalSeconds());
    }

    public function testIsEmpty()
    {
        $this->assertFalse($this->duration->isEmpty());

        $duration = new Duration;

        $this->assertTrue($duration->isEmpty());
    }

    public function testCompare()
    {
        $this->assertGreaterThan(0, $this->duration->compare($this->before));
        $this->assertSame(0, $this->duration->compare($this->same));
        $this->assertLessThan(0, $this->duration->compare($this->after));
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->duration->isEqualTo($this->before));
        $this->assertTrue($this->duration->isEqualTo($this->same));
        $this->assertFalse($this->duration->isEqualTo($this->after));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->duration->isNotEqualTo($this->before));
        $this->assertFalse($this->duration->isNotEqualTo($this->same));
        $this->assertTrue($this->duration->isNotEqualTo($this->after));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->duration->isGreaterThan($this->before));
        $this->assertFalse($this->duration->isGreaterThan($this->same));
        $this->assertFalse($this->duration->isGreaterThan($this->after));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->duration->isLessThan($this->before));
        $this->assertFalse($this->duration->isLessThan($this->same));
        $this->assertTrue($this->duration->isLessThan($this->after));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->duration->isGreaterThanOrEqualTo($this->before));
        $this->assertTrue($this->duration->isGreaterThanOrEqualTo($this->same));
        $this->assertFalse($this->duration->isGreaterThanOrEqualTo($this->after));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->duration->isLessThanOrEqualTo($this->before));
        $this->assertTrue($this->duration->isLessThanOrEqualTo($this->same));
        $this->assertTrue($this->duration->isLessThanOrEqualTo($this->after));
    }

    public function testInverse()
    {
        $this->assertSame(-788645, $this->duration->inverse()->totalSeconds());
    }

    public function testResolveToSeconds()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame(788645, $this->duration->resolveToSeconds($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToDuration()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame($this->duration, $this->duration->resolveToDuration($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToPeriod()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $result = $this->duration->resolveToPeriod($timePoint);
        $expected = new Period(0, 0, 9, 3, 4, 5);

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Period', $result);
        $this->assertSame(0, $expected->compare($result));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToInterval()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->duration->resolveToInterval($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\Interval\IntervalInterface', $result);
        $this->assertSame('2012-01-02T10:20:30+10:00', $result->start()->isoString());
        $this->assertSame('2012-01-11T13:24:35+10:00', $result->end()->isoString());
    }

    public function testResolveToTimePoint()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->duration->resolveToTimePoint($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\TimePointInterface', $result);
        $this->assertSame('2012-01-11T13:24:35+10:00', $result->isoString());
    }

    public function testString()
    {
        $this->assertSame('1w 2d 03:04:05', $this->duration->string());
    }

    public function testIsoString()
    {
        $this->assertSame('P9DT3H4M5S', $this->duration->isoString());
        $this->assertSame('P9DT3H4M5S', $this->duration->__toString());
    }

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = Duration::fromIsoString($isoString);
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
            'Years single digit'                         => array('P2Y',                    'P730DT12H'),
            'Months single digit'                        => array('P2M',                    'P60DT21H'),
            'Days single digit'                          => array('P2D',                    'P2D'),
            'Hours single digit'                         => array('PT2H',                   'PT2H'),
            'Minutes single digit'                       => array('PT2M',                   'PT2M'),
            'Seconds single digit'                       => array('PT2S',                   'PT2S'),
            'Years single digit ending T'                => array('P2YT',                   'P730DT12H'),
            'Months single digit ending T'               => array('P2MT',                   'P60DT21H'),
            'Days single digit ending T'                 => array('P2DT',                   'P2D'),

            // Duration Format - Double digit
            'Years double digit'                         => array('P12Y',                   'P4383D'),
            'Months double digit'                        => array('P12M',                   'P365DT6H'),
            'Days double digit'                          => array('P12D',                   'P12D'),
            'Hours double digit'                         => array('PT12H',                  'PT12H'),
            'Minutes double digit'                       => array('PT12M',                  'PT12M'),
            'Seconds double digit'                       => array('PT12S',                  'PT12S'),
            'Years double digit ending T'                => array('P12YT',                  'P4383D'),
            'Months double digit ending T'               => array('P12MT',                  'P365DT6H'),
            'Days double digit ending T'                 => array('P12DT',                  'P12D'),

            // Duration Format - Single digit with zero prefix
            'Years single digit zero prefix'             => array('P05Y',                   'P1826DT6H'),
            'Months single digit zero prefix'            => array('P05M',                   'P152DT4H30M'),
            'Days single digit zero prefix'              => array('P05D',                   'P5D'),
            'Hours single digit zero prefix'             => array('PT05H',                  'PT5H'),
            'Minutes single digit zero prefix'           => array('PT05M',                  'PT5M'),
            'Seconds single digit zero prefix'           => array('PT05S',                  'PT5S'),
            'Years single digit zero prefix ending T'    => array('P05YT',                  'P1826DT6H'),
            'Months single digit zero prefix ending T'   => array('P05MT',                  'P152DT4H30M'),
            'Days single digit zero prefix ending T'     => array('P05DT',                  'P5D'),

            // Duration Format - Double digit with zero prefix
            'Years double digit zero prefix'             => array('P012Y',                  'P4383D'),
            'Months double digit zero prefix'            => array('P012M',                  'P365DT6H'),
            'Days double digit zero prefix'              => array('P012D',                  'P12D'),
            'Hours double digit zero prefix'             => array('PT012H',                 'PT12H'),
            'Minutes double digit zero prefix'           => array('PT012M',                 'PT12M'),
            'Seconds double digit zero prefix'           => array('PT012S',                 'PT12S'),
            'Years double digit zero prefix ending T'    => array('P012YT',                 'P4383D'),
            'Months double digit zero prefix ending T'   => array('P012MT',                 'P365DT6H'),
            'Days double digit zero prefix ending T'     => array('P012DT',                 'P12D'),

            // Duration Format - Multiple periods
            'Years and months'                          => array('P2Y3M',                   'P821DT19H30M'),
            'Months and days'                           => array('P2M3D',                   'P63DT21H'),
            'Days and hours'                            => array('P2DT3H',                  'P2DT3H'),
            'Hours and minutes'                         => array('PT2H3M',                  'PT2H3M'),
            'Minutes and seconds'                       => array('PT2M3S',                  'PT2M3S'),
            'Seconds and years'                         => array('P3YT2S',                  'P1095DT18H2S'),

            // Duration Format - Full periods
            'Full YMD'                                  => array('P1Y2M3D',                 'P429DT3H'),
            'Full YMD ending with T'                    => array('P1Y2M3DT',                'P429DT3H'),
            'Full HMS'                                  => array('PT4H5M6S',                'PT4H5M6S'),
            'Full YMD HMS'                              => array('P1Y2M3DT4H5M6S',          'P429DT7H5M6S'),

            // Date Time Format - Misc
            'Date time basic all zero'                  => array('P00000000T000000',        'P'),
            'Date time extended all zero'               => array('P0000-00-00T00:00:00',    'P'),
            'Date time basic'                           => array('P00010203T040506',        'P429DT7H5M6S'),
            'Date time extended'                        => array('P0001-02-03T04:05:06',    'P429DT7H5M6S'),
        );
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoString($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        $result = Duration::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return array(
            // Duration Format - Empty/Zero
            'Missing P'                                 => array('',                        'Invalid ISO duration: "".'),
            'Missing P has digit'                       => array('2',                       'Invalid ISO duration: "2".'),
            'Missing P has digit designator'            => array('D',                       'Invalid ISO duration: "D".'),
            'Missing P has digit and designator'        => array('2D',                      'Invalid ISO duration: "2D".'),
            'Missing P has digit and designator dupe'   => array('2D2D',                    'Invalid ISO duration: "2D2D".'),
            'Missing P has spaces'                      => array(' ',                       'Invalid ISO duration: " ".'),
            'P with space prefix'                       => array(' P',                      'Invalid ISO duration: " P".'),
            'P with space postfix'                      => array('P ',                      'Invalid ISO duration: "P ".'),
            'P with space pre/post fix'                 => array(' P ',                     'Invalid ISO duration: " P ".'),

            // Duration Format - Misc
            'Missing period designator'                 => array('P2',                      'Invalid ISO duration: "P2".'),
            'Duplicate period designator'               => array('P2Y2Y',                   'Invalid ISO duration: "P2Y2Y".'),
            'Missing T before hours designator'         => array('P2H',                     'Invalid ISO duration: "P2H".'),
            'Missing T before seconds designator'       => array('P2S',                     'Invalid ISO duration: "P2S".'),
            'Invalid negative period'                   => array('P-2Y',                    'Invalid ISO duration: "P-2Y".'),
            'Years after T time marker'                 => array('PT2Y',                    'Invalid ISO duration: "PT2Y".'),
            'Days after T time marker'                  => array('PT2D',                    'Invalid ISO duration: "PT2D".'),
            'Years and days after T time marker'        => array('PT1Y2M3D',                'Invalid ISO duration: "PT1Y2M3D".'),

            // Date Time Format - Basic
            'Date time basic missing P'                 => array('00010203T040506',         'Invalid ISO duration: "00010203T040506".'),
            'Date time basic missing T'                 => array('P00010203 040506',        'Invalid ISO duration: "P00010203 040506".'),
            'Date time basic missing P and T'           => array('00010203 040506',         'Invalid ISO duration: "00010203 040506".'),
            'Date time basic space prefix'              => array(' P00010203T040506',       'Invalid ISO duration: " P00010203T040506".'),
            'Date time basic space postfix'             => array('P00010203T040506 ',       'Invalid ISO duration: "P00010203T040506 ".'),
            'Date time basic space pre/post fix'        => array(' P00010203T040506 ',      'Invalid ISO duration: " P00010203T040506 ".'),
            'Date time basic months exceeds moduli'     => array('P00001300T000000',        'Invalid ISO duration: "P00001300T000000".'),
            'Date time basic days exceeds moduli'       => array('P00000032T000000',        'Invalid ISO duration: "P00000032T000000".'),
            'Date time basic hours exceeds moduli'      => array('P00000000T250000',        'Invalid ISO duration: "P00000000T250000".'),
            'Date time basic minutes exceeds moduli'    => array('P00000000T006000',        'Invalid ISO duration: "P00000000T006000".'),
            'Date time basic seconds exceeds moduli'    => array('P00000000T000060',        'Invalid ISO duration: "P00000000T000060".'),

            // Date Time Format - Extended
            'Date time extended missing P'              => array('0001-02-03T04:05:06',     'Invalid ISO duration: "0001-02-03T04:05:06".'),
            'Date time extended missing T'              => array('P0001-02-03 04:05:06',    'Invalid ISO duration: "P0001-02-03 04:05:06".'),
            'Date time extended missing P and T'        => array('0001-02-03 04:05:06',     'Invalid ISO duration: "0001-02-03 04:05:06".'),
            'Date time extended space prefix'           => array(' P0001-02-03T04:05:06',   'Invalid ISO duration: " P0001-02-03T04:05:06".'),
            'Date time extended space postfix'          => array('P0001-02-03T04:05:06 ',   'Invalid ISO duration: "P0001-02-03T04:05:06 ".'),
            'Date time extended space pre/post fix'     => array(' P0001-02-03T04:05:06 ',  'Invalid ISO duration: " P0001-02-03T04:05:06 ".'),
            'Date time extended months exceeds moduli'  => array('P0000-13-00T00:00:00',    'Invalid ISO duration: "P0000-13-00T00:00:00".'),
            'Date time extended days exceeds moduli'    => array('P0000-00-32T00:00:00',    'Invalid ISO duration: "P0000-00-32T00:00:00".'),
            'Date time extended hours exceeds moduli'   => array('P0000-00-00T25:00:00',    'Invalid ISO duration: "P0000-00-00T25:00:00".'),
            'Date time extended minutes exceeds moduli' => array('P0000-00-00T00:60:00',    'Invalid ISO duration: "P0000-00-00T00:60:00".'),
            'Date time extended seconds exceeds moduli' => array('P0000-00-00T00:00:60',    'Invalid ISO duration: "P0000-00-00T00:00:60".'),
        );
    }

}

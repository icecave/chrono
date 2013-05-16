<?php
namespace Icecave\Chrono\Support;

use PHPUnit_Framework_TestCase;

class Iso8601Test extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validIsoDurationStrings
     */
    public function testParseDuration($isoString, $expected)
    {
        $result = Iso8601::parseDuration($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoDurationStrings()
    {
        return array(
            // Duration Format - Empty/Zero
            'Empty'                                     => array('P',                       array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Empty with T'                              => array('PT',                      array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero years ending with T'                  => array('P0YT',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero months ending with T'                 => array('P0MT',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero days ending with T'                   => array('P0DT',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero weeks'                                => array('P0W',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero years'                                => array('P0Y',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero months'                               => array('P0M',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero days'                                 => array('P0D',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero hours'                                => array('PT0H',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero minutes'                              => array('PT0M',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero seconds'                              => array('PT0S',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero YMD'                                  => array('P0Y0M0D',                 array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero HMS'                                  => array('PT0H0M0S',                array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero YMD HMS'                              => array('P0Y0M0DT0H0M0S',          array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero months and minutes'                   => array('P0MT0M',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Weeks
            'Weeks 1'                                   => array('P1W',                     array('years' => 0, 'months' => 0, 'days' =>  7, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Weeks 3'                                   => array('P3W',                     array('years' => 0, 'months' => 0, 'days' => 21, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Weeks 10'                                  => array('P10W',                    array('years' => 0, 'months' => 0, 'days' => 70, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Weeks zero prefix'                         => array('P03W',                    array('years' => 0, 'months' => 0, 'days' => 21, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Single digit
            'Years single digit'                         => array('P2Y',                    array('years' => 2, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit'                        => array('P2M',                    array('years' => 0, 'months' => 2, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit'                          => array('P2D',                    array('years' => 0, 'months' => 0, 'days' => 2, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Hours single digit'                         => array('PT2H',                   array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 2, 'minutes' => 0, 'seconds' => 0)),
            'Minutes single digit'                       => array('PT2M',                   array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 2, 'seconds' => 0)),
            'Seconds single digit'                       => array('PT2S',                   array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 2)),
            'Years single digit ending T'                => array('P2YT',                   array('years' => 2, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit ending T'               => array('P2MT',                   array('years' => 0, 'months' => 2, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit ending T'                 => array('P2DT',                   array('years' => 0, 'months' => 0, 'days' => 2, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Double digit
            'Years double digit'                         => array('P12Y',                   array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit'                        => array('P12M',                   array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit'                          => array('P12D',                   array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Hours double digit'                         => array('PT12H',                  array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' => 12, 'minutes' =>  0, 'seconds' =>  0)),
            'Minutes double digit'                       => array('PT12M',                  array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' => 12, 'seconds' =>  0)),
            'Seconds double digit'                       => array('PT12S',                  array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' => 12)),
            'Years double digit ending T'                => array('P12YT',                  array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit ending T'               => array('P12MT',                  array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit ending T'                 => array('P12DT',                  array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),

            // Duration Format - Single digit with zero prefix
            'Years single digit zero prefix'             => array('P05Y',                   array('years' => 5, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit zero prefix'            => array('P05M',                   array('years' => 0, 'months' => 5, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit zero prefix'              => array('P05D',                   array('years' => 0, 'months' => 0, 'days' => 5, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Hours single digit zero prefix'             => array('PT05H',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 5, 'minutes' => 0, 'seconds' => 0)),
            'Minutes single digit zero prefix'           => array('PT05M',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 5, 'seconds' => 0)),
            'Seconds single digit zero prefix'           => array('PT05S',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 5)),
            'Years single digit zero prefix ending T'    => array('P05YT',                  array('years' => 5, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit zero prefix ending T'   => array('P05MT',                  array('years' => 0, 'months' => 5, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit zero prefix ending T'     => array('P05DT',                  array('years' => 0, 'months' => 0, 'days' => 5, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Double digit with zero prefix
            'Years double digit zero prefix'             => array('P012Y',                  array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit zero prefix'            => array('P012M',                  array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit zero prefix'              => array('P012D',                  array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Hours double digit zero prefix'             => array('PT012H',                 array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' => 12, 'minutes' =>  0, 'seconds' =>  0)),
            'Minutes double digit zero prefix'           => array('PT012M',                 array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' => 12, 'seconds' =>  0)),
            'Seconds double digit zero prefix'           => array('PT012S',                 array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' => 12)),
            'Years double digit zero prefix ending T'    => array('P012YT',                 array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit zero prefix ending T'   => array('P012MT',                 array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit zero prefix ending T'     => array('P012DT',                 array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),

            // Duration Format - Multiple periods
            'Years and months'                          => array('P2Y3M',                   array('years' => 2, 'months' => 3, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months and days'                           => array('P2M3D',                   array('years' => 0, 'months' => 2, 'days' => 3, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days and hours'                            => array('P2DT3H',                  array('years' => 0, 'months' => 0, 'days' => 2, 'hours' => 3, 'minutes' => 0, 'seconds' => 0)),
            'Hours and minutes'                         => array('PT2H3M',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 2, 'minutes' => 3, 'seconds' => 0)),
            'Minutes and seconds'                       => array('PT2M3S',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 2, 'seconds' => 3)),
            'Seconds and years'                         => array('P3YT2S',                  array('years' => 3, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 2)),

            // Duration Format - Full periods
            'Full YMD'                                  => array('P1Y2M3D',                 array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Full YMD ending with T'                    => array('P1Y2M3DT',                array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Full HMS'                                  => array('PT4H5M6S',                array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),
            'Full YMD HMS'                              => array('P1Y2M3DT4H5M6S',          array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),

            // Date Time Format - Misc
            'Date time basic all zero'                  => array('P00000000T000000',        array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Date time extended all zero'               => array('P0000-00-00T00:00:00',    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Date time basic'                           => array('P00010203T040506',        array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),
            'Date time extended'                        => array('P0001-02-03T04:05:06',    array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),
        );
    }

    /**
     * @dataProvider invalidIsoDurationStrings
     */
    public function testParseDurationWithInvalidIsoString($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        $result = Iso8601::parseDuration($isoString);
    }

    public function invalidIsoDurationStrings()
    {
        return array(
            // Duration Format - Empty/Zero
            'Missing P'                                 => array('',                        'Invalid ISO string format: "".'),
            'Missing P has digit'                       => array('2',                       'Invalid ISO string format: "2".'),
            'Missing P has digit designator'            => array('D',                       'Invalid ISO string format: "D".'),
            'Missing P has digit and designator'        => array('2D',                      'Invalid ISO string format: "2D".'),
            'Missing P has digit and designator dupe'   => array('2D2D',                    'Invalid ISO string format: "2D2D".'),
            'Missing P has spaces'                      => array(' ',                       'Invalid ISO string format: " ".'),
            'P with space prefix'                       => array(' P',                      'Invalid ISO string format: " P".'),
            'P with space postfix'                      => array('P ',                      'Invalid ISO string format: "P ".'),
            'P with space pre/post fix'                 => array(' P ',                     'Invalid ISO string format: " P ".'),

            // Duration Format - Misc
            'Missing period designator'                 => array('P2',                      'Invalid ISO string format: "P2".'),
            'Duplicate period designator'               => array('P2Y2Y',                   'Invalid ISO string format: "P2Y2Y".'),
            'Missing T before hours designator'         => array('P2H',                     'Invalid ISO string format: "P2H".'),
            'Missing T before seconds designator'       => array('P2S',                     'Invalid ISO string format: "P2S".'),
            'Invalid negative period'                   => array('P-2Y',                    'Invalid ISO string format: "P-2Y".'),

            // Date Time Format - Basic
            'Date time basic missing P'                 => array('00010203T040506',         'Invalid ISO string format: "00010203T040506".'),
            'Date time basic missing T'                 => array('P00010203 040506',        'Invalid ISO string format: "P00010203 040506".'),
            'Date time basic missing P and T'           => array('00010203 040506',         'Invalid ISO string format: "00010203 040506".'),
            'Date time basic space prefix'              => array(' P00010203T040506',       'Invalid ISO string format: " P00010203T040506".'),
            'Date time basic space postfix'             => array('P00010203T040506 ',       'Invalid ISO string format: "P00010203T040506 ".'),
            'Date time basic space pre/post fix'        => array(' P00010203T040506 ',      'Invalid ISO string format: " P00010203T040506 ".'),
            'Date time basic months exceeds moduli'     => array('P00001300T000000',        'Invalid ISO string format: "P00001300T000000".'),
            'Date time basic days exceeds moduli'       => array('P00000032T000000',        'Invalid ISO string format: "P00000032T000000".'),
            'Date time basic hours exceeds moduli'      => array('P00000000T250000',        'Invalid ISO string format: "P00000000T250000".'),
            'Date time basic minutes exceeds moduli'    => array('P00000000T006000',        'Invalid ISO string format: "P00000000T006000".'),
            'Date time basic seconds exceeds moduli'    => array('P00000000T000060',        'Invalid ISO string format: "P00000000T000060".'),

            // Date Time Format - Extended
            'Date time extended missing P'              => array('0001-02-03T04:05:06',     'Invalid ISO string format: "0001-02-03T04:05:06".'),
            'Date time extended missing T'              => array('P0001-02-03 04:05:06',    'Invalid ISO string format: "P0001-02-03 04:05:06".'),
            'Date time extended missing P and T'        => array('0001-02-03 04:05:06',     'Invalid ISO string format: "0001-02-03 04:05:06".'),
            'Date time extended space prefix'           => array(' P0001-02-03T04:05:06',   'Invalid ISO string format: " P0001-02-03T04:05:06".'),
            'Date time extended space postfix'          => array('P0001-02-03T04:05:06 ',   'Invalid ISO string format: "P0001-02-03T04:05:06 ".'),
            'Date time extended space pre/post fix'     => array(' P0001-02-03T04:05:06 ',  'Invalid ISO string format: " P0001-02-03T04:05:06 ".'),
            'Date time extended months exceeds moduli'  => array('P0000-13-00T00:00:00',    'Invalid ISO string format: "P0000-13-00T00:00:00".'),
            'Date time extended days exceeds moduli'    => array('P0000-00-32T00:00:00',    'Invalid ISO string format: "P0000-00-32T00:00:00".'),
            'Date time extended hours exceeds moduli'   => array('P0000-00-00T25:00:00',    'Invalid ISO string format: "P0000-00-00T25:00:00".'),
            'Date time extended minutes exceeds moduli' => array('P0000-00-00T00:60:00',    'Invalid ISO string format: "P0000-00-00T00:60:00".'),
            'Date time extended seconds exceeds moduli' => array('P0000-00-00T00:00:60',    'Invalid ISO string format: "P0000-00-00T00:00:60".'),
        );
    }
}

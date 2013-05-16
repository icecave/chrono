<?php
namespace Icecave\Chrono\Support;

// use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

abstract class Iso8601
{
    /**
     * Standard duration formats:
     *   PnYnMnDTnHnMnS (zero periods may be ommitted)
     *   PnW
     *   P<date>T<time>
     *
     * See link for the full specifics on formats.
     * @link http://en.wikipedia.org/wiki/ISO_8601#Durations
     *
     * Note: Decimal fractions are currently not supported.
     *
     * @param string $isoString A string containing a duration in any ISO-8601 compatible duration format.
     *
     * @return array<string,integer> The duration periods from the ISO compatible string.
     */
    public static function parseDuration($isoString)
    {
        if (!strlen($isoString)) {
            throw new InvalidArgumentException('Invalid ISO string format: "' . $isoString . '".');
        }

        $duration = array(
            'years'   => 0,
            'months'  => 0,
            'days'    => 0,
            'hours'   => 0,
            'minutes' => 0,
            'seconds' => 0
        );

        if ($isoString === 'P') {
            return $duration;
        }

        $matches = array();
        if (preg_match(self::DURATION_WEEK, $isoString, $matches)) {
            $duration['days'] = intval($matches[1]) * 7;
        } elseif (preg_match(self::DURATION_PERIOD, $isoString, $matches)) {
            $defaults = array(
                'years'   => 0,
                'months'  => 0,
                'days'    => 0,
                'hours'   => 0,
                'minutes' => 0,
                'seconds' => 0
            );
            $matches += $defaults;

            $duration['years']   = intval($matches['years']);
            $duration['months']  = intval($matches['months']);
            $duration['days']    = intval($matches['days']);

            $duration['hours']   = intval($matches['hours']);
            $duration['minutes'] = intval($matches['minutes']);
            $duration['seconds'] = intval($matches['seconds']);
        } elseif (
            preg_match(self::DURATION_DATETIME_BASIC,    $isoString, $matches) === 1 ||
            preg_match(self::DURATION_DATETIME_EXTENDED, $isoString, $matches) === 1
        ) {
            $duration['years']   = intval($matches[1]);
            $duration['months']  = intval($matches[2]);
            $duration['days']    = intval($matches[3]);

            $duration['hours']   = intval($matches[4]);
            $duration['minutes'] = intval($matches[5]);
            $duration['seconds'] = intval($matches[6]);

            // ISO-8601 Durations: Individual date and time values cannot exceed their moduli (e.g. a value of 13 for the month or 25 for the hour would not be permissible).
            if ($duration['months'] > 12 ||
                $duration['days'] > 31 ||
                $duration['hours'] > 24 ||
                $duration['minutes'] > 59 ||
                $duration['seconds'] > 59) {

                throw new InvalidArgumentException('Invalid ISO string format: "' . $isoString . '".');
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO string format: "' . $isoString . '".');
        }

        return $duration;
    }

    const DURATION_WEEK                 = '/^P(\d+)W$/';
    const DURATION_PERIOD               = '/^P(?:(?:(?P<years>\d+)Y)?(?:(?P<months>\d+)M)?(?:(?P<days>\d+)D)?(?:T(?:(?P<hours>\d+)H)?(?:(?P<minutes>\d+)M)?(?:(?P<seconds>\d+)S)?)?)?$/';
    const DURATION_DATETIME_BASIC       = '/^P(\d\d\d\d)(\d\d)(\d\d)T(\d\d)(\d\d)(\d\d)$/';
    const DURATION_DATETIME_EXTENDED    = '/^P(\d\d\d\d)-(\d\d)-(\d\d)T(\d\d):(\d\d):(\d\d)$/';
}

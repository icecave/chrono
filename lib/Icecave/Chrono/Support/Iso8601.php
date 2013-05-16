<?php
namespace Icecave\Chrono\Support;

use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

/**
 * See link for the full specifics on formats.
 * @link http://en.wikipedia.org/wiki/ISO_8601
 */
abstract class Iso8601
{
    /**
     * Standard date formats:
     *   YYYY-MM-DD[timezone]
     *   YYYYMMDD[timezone]
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Calendar_dates
     *
     * Note: Formats YYYY-MM and YYYYMM for reduced precision are currently not supported.
     *
     * @param string $isoString A string containing a date in any ISO-8601 compatible date format.
     *
     * @return array<string,integer|null> The date periods from the ISO compatible string.
     */
    public static function parseDate($isoString)
    {
        TypeCheck::get(__CLASS__)->parseDate(func_get_args());

        $date = array(
            'year'   => 0,
            'month'  => 0,
            'day'    => 0,
            'offset' => null
        );

        $matches = array();
        if (preg_match(self::DATE_EXTENDED, $isoString, $matches) === 1 ||
            preg_match(self::DATE_BASIC,    $isoString, $matches) === 1) {

            $date['year']  = intval($matches[1]);
            $date['month'] = intval($matches[2]);
            $date['day']   = intval($matches[3]);

            if (count($matches) > 4 && strlen($matches[4]) > 0) {
                $date['offset'] = self::parseTimeZone($matches[4]);
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO date: "' . $isoString . '".');
        }

        return $date;
    }

    /**
     * Standard time formats:
     *   hh:mm:ss[timezone]
     *   hhmmss[timezone]
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Times
     *
     * Note: Formats hh:mm and hhmm for reduced precision are currently not supported.
     *
     * @param string $isoString A string containing a time in any ISO-8601 compatible time format.
     *
     * @return array<string,integer|null> The time periods from the ISO compatible string.
     */
    public static function parseTime($isoString)
    {
        TypeCheck::get(__CLASS__)->parseTime(func_get_args());

        $time = array(
            'hour'   => 0,
            'minute' => 0,
            'second' => 0,
            'offset' => null
        );

        $matches = array();
        if (preg_match(self::TIME_EXTENDED, $isoString, $matches) === 1 ||
            preg_match(self::TIME_BASIC,    $isoString, $matches) === 1) {

            $time['hour']   = intval($matches[1]);
            $time['minute'] = intval($matches[2]);
            $time['second'] = intval($matches[3]);

            if (count($matches) > 4 && strlen($matches[4]) > 0) {
                $time['offset'] = self::parseTimeZone($matches[4]);
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO time: "' . $isoString . '".');
        }

        return $time;
    }

    /**
     * Standard date time formats:
     *   <date>T<time>[timezone]
     *   <date> <time>[timezone]
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations
     *
     * @param string $isoString A string containing a date time in any ISO-8601 compatible date time format.
     *
     * @return array<string,integer|null> The date time periods from the ISO compatible string.
     */
    public static function parseDateTime($isoString)
    {
        TypeCheck::get(__CLASS__)->parseDateTime(func_get_args());

        $dateTime = array(
            'year'   => 0,
            'month'  => 0,
            'day'    => 0,
            'hour'   => 0,
            'minute' => 0,
            'second' => 0,
            'offset' => null
        );

        $matches = array();
        if (preg_match(self::DATETIME_EXTENDED, $isoString, $matches) === 1 ||
            preg_match(self::DATETIME_BASIC,    $isoString, $matches) === 1) {

            $dateTime['year']   = intval($matches[1]);
            $dateTime['month']  = intval($matches[2]);
            $dateTime['day']    = intval($matches[3]);

            $dateTime['hour']   = intval($matches[4]);
            $dateTime['minute'] = intval($matches[5]);
            $dateTime['second'] = intval($matches[6]);

            if (count($matches) > 7 && strlen($matches[7]) > 0) {
                $dateTime['offset'] = self::parseTimeZone($matches[7]);
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO date time: "' . $isoString . '".');
        }

        return $dateTime;
    }

    /**
     * Standard time zone formats:
     *   Z
     *   +/-hh
     *   +/-hhmm
     *   +/-hh:mm
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Time_zone_designators
     *
     * @param string $isoString A string containing a time zone in any ISO-8601 compatible time zone format, with the exception of allowing negative zero's.
     *
     * @return integer The time zone offset from the ISO compatible string.
     */
    public static function parseTimeZone($isoString)
    {
        TypeCheck::get(__CLASS__)->parseTimeZone(func_get_args());

        $offset = 0;

        $matches = array();
        if (preg_match(self::TIMEZONE_UTC, $isoString, $matches) === 1) {
            $offset = 0;
        } elseif (preg_match(self::TIMEZONE_OFFSET, $isoString, $matches) === 1) {
            $sign = trim($matches[1]);
            $hour = intval($matches[2]);
            $minute = count($matches) > 4 ? intval($matches[4]) : 0;

            $offset = intval(($hour * 60 * 60) + ($minute * 60));
            if ($sign === '-') {
                $offset = -$offset;
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO time zone: "' . $isoString . '".');
        }

        return $offset;
    }

    /**
     * Standard duration formats:
     *   PnYnMnDTnHnMnS (zero periods may be ommitted)
     *   PnW
     *   P<date>T<time>
     *
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
        TypeCheck::get(__CLASS__)->parseDuration(func_get_args());

        if (!strlen($isoString)) {
            throw new InvalidArgumentException('Invalid ISO duration format: "' . $isoString . '".');
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

                throw new InvalidArgumentException('Invalid ISO duration format: "' . $isoString . '".');
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO duration format: "' . $isoString . '".');
        }

        return $duration;
    }

    const DATE_BASIC    = '/^(\d\d\d\d)(\d\d)(\d\d)(.*)$/';
    const DATE_EXTENDED = '/^(\d\d\d\d)-(\d\d)-(\d\d)(.*)$/';

    const TIME_BASIC    = '/^(\d\d)(\d\d)(\d\d)(.*)$/';
    const TIME_EXTENDED = '/^(\d\d):(\d\d):(\d\d)(.*)$/';

    const DATETIME_BASIC    = '/^(\d\d\d\d)(\d\d)(\d\d)[T| ](\d\d)(\d\d)(\d\d)(.*)$/';
    const DATETIME_EXTENDED = '/^(\d\d\d\d)-(\d\d)-(\d\d)[T| ](\d\d):(\d\d):(\d\d)(.*)$/';

    const TIMEZONE_UTC    = '/^(Z)$/';
    const TIMEZONE_OFFSET = '/^([+-])(\d\d)(:?(\d\d))?$/';

    const DURATION_WEEK              = '/^P(\d+)W$/';
    const DURATION_PERIOD            = '/^P(?:(?:(?P<years>\d+)Y)?(?:(?P<months>\d+)M)?(?:(?P<days>\d+)D)?(?:T(?:(?P<hours>\d+)H)?(?:(?P<minutes>\d+)M)?(?:(?P<seconds>\d+)S)?)?)?$/';
    const DURATION_DATETIME_BASIC    = '/^P(\d\d\d\d)(\d\d)(\d\d)T(\d\d)(\d\d)(\d\d)$/';
    const DURATION_DATETIME_EXTENDED = '/^P(\d\d\d\d)-(\d\d)-(\d\d)T(\d\d):(\d\d):(\d\d)$/';
}

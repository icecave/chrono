<?php

namespace Icecave\Chrono\Detail;

use InvalidArgumentException;

/**
 * ISO-8601 standard parsing and formatting functions.
 *
 * See link for the full specifics on formats.
 * @link http://en.wikipedia.org/wiki/ISO_8601
 */
abstract class Iso8601
{
    /**
     * @param integer $year
     *
     * @return string A string representing the data in an ISO compatible year format (YYYY).
     */
    public static function formatYear($year)
    {
        return sprintf('%04d', $year);
    }

    /**
     * @param integer $year
     * @param integer $month
     *
     * @return string A string representing the data in an ISO compatible year month format (YYYY-MM).
     */
    public static function formatYearMonth($year, $month)
    {
        return sprintf('%04d-%02d', $year, $month);
    }

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     *
     * @return string A string representing the data in an ISO compatible date format (YYYY-MM-DD).
     */
    public static function formatDate($year, $month, $day)
    {
        return sprintf(
            '%04d-%02d-%02d',
            $year,
            $month,
            $day
        );
    }

    /**
     * @param integer $hour
     * @param integer $minute
     * @param integer $second
     * @param string  $timeZone Time zone in ISO compatible time zone format.
     *
     * @return string A string representing the data in an ISO compatible time format (hh:mm:ss[+-]hh:mm).
     */
    public static function formatTime($hour, $minute, $second, $timeZone)
    {
        return sprintf(
            '%02d:%02d:%02d%s',
            $hour,
            $minute,
            $second,
            $timeZone
        );
    }

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hour
     * @param integer $minute
     * @param integer $second
     * @param string  $timeZone Time zone in ISO compatible time zone format.
     *
     * @return string A string representing the data in an ISO compatible date time format (YYYY-MM-DDThh:mm:ss[+-]hh:mm).
     */
    public static function formatDateTime($year, $month, $day, $hour, $minute, $second, $timeZone)
    {
        return sprintf(
            '%04d-%02d-%02dT%02d:%02d:%02d%s',
            $year,
            $month,
            $day,
            $hour,
            $minute,
            $second,
            $timeZone
        );
    }

    /**
     * @param integer $offset The offset from UTC in seconds.
     *
     * @return string A string representing the data in an ISO compatible time zone format ([+-]hh:mm).
     */
    public static function formatTimeZone($offset)
    {
        $seconds = abs($offset);
        $minutes = ($seconds % 3600) / 60;
        $hours   = $seconds / 3600;

        return sprintf(
            '%s%02d:%02d',
            $offset >= 0 ? '+' : '-',
            $hours,
            $minutes
        );
    }

    /**
     * @param integer $years
     * @param integer $months
     * @param integer $days
     * @param integer $hours
     * @param integer $minutes
     * @param integer $seconds
     *
     * @return string A string representing the data in an ISO compatible duration format (PnYnMnDTnHnMnS).
     */
    public static function formatDuration($years, $months, $days, $hours, $minutes, $seconds)
    {
        $dateParts = '';
        if ($years !== 0) {
            $dateParts .= $years . 'Y';
        }
        if ($months !== 0) {
            $dateParts .= $months . 'M';
        }
        if ($days !== 0) {
            $dateParts .= $days . 'D';
        }

        $timeParts = '';
        if ($hours !== 0) {
            $timeParts .= $hours . 'H';
        }
        if ($minutes !== 0) {
            $timeParts .= $minutes . 'M';
        }
        if ($seconds !== 0 || (strlen($dateParts) === 0 && strlen($timeParts) === 0)) {
            $timeParts .= $seconds . 'S';
        }

        if (strlen($timeParts) > 0) {
            $timeParts = 'T' . $timeParts;
        }

        return 'P' . $dateParts . $timeParts;
    }

    /**
     * Standard year format:
     *   YYYY
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Calendar_dates
     *
     * Note: Negative years (BC) are not supported.
     *
     * @param string $isoString A string containing a year in any ISO-8601 compatible year format.
     *
     * @return integer The year number from the ISO compatible string.
     */
    public static function parseYear($isoString)
    {
        $matches = array();
        if (preg_match(self::YEAR, $isoString, $matches) === 1) {
            $year = intval($matches[1]);
        } else {
            throw new InvalidArgumentException('Invalid ISO year: "' . $isoString . '".');
        }

        return $year;
    }

    /**
     * Standard year month format:
     *   YYYY-MM
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Calendar_dates
     *
     * @param string $isoString A string containing a year month in any ISO-8601 compatible year month format.
     *
     * @return array<string,integer> The year month periods from the ISO compatible string.
     */
    public static function parseYearMonth($isoString)
    {
        $parts = array(
            'year'   => 0,
            'month'  => 0,
        );

        $matches = array();
        if (preg_match(self::YEAR_MONTH, $isoString, $matches) === 1) {
            $parts['year']  = intval($matches[1]);
            $parts['month'] = intval($matches[2]);
        } else {
            throw new InvalidArgumentException('Invalid ISO year month: "' . $isoString . '".');
        }

        return $parts;
    }

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
        $date = array(
            'year'   => 0,
            'month'  => 0,
            'day'    => 0,
            'offset' => null,
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
        $time = array(
            'hour'        => 0,
            'minute'      => 0,
            'second'      => 0,
            'microsecond' => 0,
            'offset'      => null,
        );

        $matches = array();
        if (preg_match(self::TIME_EXTENDED, $isoString, $matches) === 1 ||
            preg_match(self::TIME_BASIC,    $isoString, $matches) === 1) {
            $time['hour']   = intval($matches[1]);
            $time['minute'] = intval($matches[2]);
            $time['second'] = intval($matches[3]);
            $time['microsecond'] = intval(str_pad(substr($matches[4], 0, 6), 6, '0'));

            if (count($matches) > 5 && strlen($matches[5]) > 0) {
                $time['offset'] = self::parseTimeZone($matches[5]);
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
        $dateTime = array(
            'year'        => 0,
            'month'       => 0,
            'day'         => 0,
            'hour'        => 0,
            'minute'      => 0,
            'second'      => 0,
            'microsecond' => 0,
            'offset'      => null,
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
            $dateTime['microsecond'] = intval(str_pad(substr($matches[7], 0, 6), 6, '0'));

            if (count($matches) > 8 && strlen($matches[8]) > 0) {
                $dateTime['offset'] = self::parseTimeZone($matches[8]);
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
        $offset = 0;

        $matches = array();
        if (preg_match(self::TIMEZONE_UTC, $isoString, $matches) === 1) {
            $offset = 0;
        } elseif (preg_match(self::TIMEZONE_OFFSET, $isoString, $matches) === 1) {
            $sign   = trim($matches[1]);
            $hour   = intval($matches[2]);
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
        if (!strlen($isoString) || $isoString === 'P' || substr($isoString, -1) === 'T') {
            throw new InvalidArgumentException('Invalid ISO duration: "' . $isoString . '".');
        }

        $duration = array(
            'years'   => 0,
            'months'  => 0,
            'days'    => 0,
            'hours'   => 0,
            'minutes' => 0,
            'seconds' => 0,
        );

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
                'seconds' => 0,
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
                throw new InvalidArgumentException('Invalid ISO duration: "' . $isoString . '".');
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO duration: "' . $isoString . '".');
        }

        return $duration;
    }

    /**
     * Standard interval formats:
     *   <start datetime>/<end datetime>
     *   <start datetime>/<duration>
     *   <duration>/<end datetime>
     *   <duration>
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Time_intervals
     *
     * Note: Duration only format is not supported.
     *
     * @param string $isoString A string containing an interval in any ISO-8601 compatible interval format.
     *
     * @return array<string,array<string|array>> A associative array of interval type to interval parts from the ISO compatible string.
     */
    public static function parseInterval($isoString)
    {
        if (!strlen($isoString) || $isoString === '/') {
            throw new InvalidArgumentException('Invalid ISO interval: "' . $isoString . '".');
        }

        $parts = explode('/', $isoString, 2);

        if (count($parts) === 1) {
            // Duration only format is not supported.
            throw new InvalidArgumentException('Invalid ISO interval: "' . $isoString . '".');
        }

        list($firstPart, $secondPart) = $parts;

        // If $firstPart begins with P, than its a duration/end-datetime interval.
        if (strlen($firstPart) > 0 && $firstPart[0] === 'P') {
            return array(
                'type'     => 'duration/datetime',
                'interval' => array($firstPart, $secondPart),
            );
        }

        // If $secondPart begins with P, than its a datetime/duration interval.
        if (strlen($secondPart) > 0 && $secondPart[0] === 'P') {
            return array(
                'type'     => 'datetime/duration',
                'interval' => array($firstPart, $secondPart),
            );
        }

        // Only option left is a start-datetime/end-datetime interval.
        return array(
            'type'     => 'datetime/datetime',
            'interval' => array($firstPart, $secondPart),
        );
    }

    const YEAR       = '/^(\d\d\d\d)$/';
    const YEAR_MONTH = '/^(\d\d\d\d)-(\d\d)$/';

    const DATE_BASIC    = '/^(\d\d\d\d)(\d\d)(\d\d)(.*)$/';
    const DATE_EXTENDED = '/^(\d\d\d\d)-(\d\d)-(\d\d)(.*)$/';

    const TIME_BASIC    = '/^(\d\d)(\d\d)(\d\d)(?:\.(\d+))?(.*)$/';
    const TIME_EXTENDED = '/^(\d\d):(\d\d):(\d\d)(?:\.(\d+))?(.*)$/';

    const DATETIME_BASIC    = '/^(\d\d\d\d)(\d\d)(\d\d)[T| ](\d\d)(\d\d)(\d\d)(?:\.(\d+))?(.*)$/';
    const DATETIME_EXTENDED = '/^(\d\d\d\d)-(\d\d)-(\d\d)[T| ](\d\d):(\d\d):(\d\d)(?:\.(\d+))?(.*)$/';

    const TIMEZONE_UTC    = '/^(Z)$/';
    const TIMEZONE_OFFSET = '/^([+-])(\d\d)(:?(\d\d))?$/';

    const DURATION_WEEK              = '/^P(\d+)W$/';
    const DURATION_PERIOD            = '/^P(?:(?:(?P<years>\d+)Y)?(?:(?P<months>\d+)M)?(?:(?P<days>\d+)D)?(?:T(?:(?P<hours>\d+)H)?(?:(?P<minutes>\d+)M)?(?:(?P<seconds>\d+)S)?)?)?$/';
    const DURATION_DATETIME_BASIC    = '/^P(\d\d\d\d)(\d\d)(\d\d)T(\d\d)(\d\d)(\d\d)$/';
    const DURATION_DATETIME_EXTENDED = '/^P(\d\d\d\d)-(\d\d)-(\d\d)T(\d\d):(\d\d):(\d\d)$/';
}

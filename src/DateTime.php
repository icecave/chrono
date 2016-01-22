<?php

namespace Icecave\Chrono;

use DateTime as NativeDateTime;
use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\Detail\Normalizer;
use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;

/**
 * Represents a date/time.
 */
class DateTime extends AbstractTimePoint implements TimeInterface
{
    /**
     * @param integer       $year     The year component of the date.
     * @param integer       $month    The month component of the date.
     * @param integer       $day      The day component of the date.
     * @param integer       $hour     The hour component of the time.
     * @param integer       $minute   The minute component of the time.
     * @param integer       $second   The second component of the time.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     */
    public function __construct(
        $year,
        $month,
        $day,
        $hour = 0,
        $minute = 0,
        $second = 0,
        TimeZone $timeZone = null
    ) {
        Normalizer::normalizeTime($hour, $minute, $second, $day);
        Normalizer::normalizeDate($year, $month, $day);

        if ($timeZone === null) {
            $timeZone = new TimeZone();
        }

        $this->year     = $year;
        $this->month    = $month;
        $this->day      = $day;
        $this->hour     = $hour;
        $this->minute   = $minute;
        $this->second   = $second;
        $this->timeZone = $timeZone;
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
     * @return DateTime The DateTime constructed from the ISO compatible string and optional time zone.
     */
    public static function fromIsoString($isoString)
    {
        $dateTime = Iso8601::parseDateTime($isoString);

        if ($dateTime['offset'] !== null) {
            $timeZone = new TimeZone($dateTime['offset']);
        } else {
            $timeZone = null;
        }

        return new self(
            $dateTime['year'],
            $dateTime['month'],
            $dateTime['day'],
            $dateTime['hour'],
            $dateTime['minute'],
            $dateTime['second'],
            $timeZone
        );
    }

    /**
     * @param integer       $unixTime The unix timestamp.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     *
     * @return DateTime The DateTime constructed from the given timestamp and time zone.
     */
    public static function fromUnixTime($unixTime, TimeZone $timeZone = null)
    {
        if ($timeZone) {
            $unixTime += $timeZone->offset();
        }

        $parts = gmdate('Y,m,d,H,i,s', $unixTime);
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);

        list($year, $month, $day, $hour, $minute, $second) = $parts;

        return new self($year, $month, $day, $hour, $minute, $second, $timeZone);
    }

    /**
     * @param NativeDateTime $native The native PHP DateTime instance.
     *
     * @return DateTime The DateTime constructed from the given instance.
     */
    public static function fromNativeDateTime(NativeDateTime $native)
    {
        return self::fromUnixTime(
            $native->getTimestamp(),
            new TimeZone(
                $native->getOffset(),
                (bool) $native->format('I')
            )
        );
    }

    /**
     * @return integer The year component of the date.
     */
    public function year()
    {
        return $this->year;
    }

    /**
     * @return integer The month component of the date.
     */
    public function month()
    {
        return $this->month;
    }

    /**
     * @return integer The day component of the date.
     */
    public function day()
    {
        return $this->day;
    }

    /**
     * @return integer The hour component of the time.
     */
    public function hour()
    {
        return $this->hour;
    }

    /**
     * @return integer The minute component of the time.
     */
    public function minute()
    {
        return $this->minute;
    }

    /**
     * @return integer The second component of the time.
     */
    public function second()
    {
        return $this->second;
    }

    /**
     * Convert this time to a different timezone.
     *
     * Note that this method returns a {@see DateTime} instance, and not a {@see Date}.
     *
     * @param TimeZone $timeZone The target timezone
     *
     * @return DateTime
     */
    public function toTimeZone(TimeZone $timeZone)
    {
        if ($this->timeZone()->isEqualTo($timeZone)) {
            return $this;
        }

        $offset = $timeZone->offset()
                - $this->timeZone()->offset();

        return new self(
            $this->year(),
            $this->month(),
            $this->day(),
            $this->hour(),
            $this->minute(),
            $this->second() + $offset,
            $timeZone
        );
    }

    /**
     * Convert this time to the UTC timezone.
     *
     * Note that this method returns a {@see DateTime} instance, and not a {@see Date}.
     *
     * @return DateTime
     */
    public function toUtc()
    {
        return $this->toTimeZone(new TimeZone());
    }

    /**
     * @return TimeZone The time zone of the time.
     */
    public function timeZone()
    {
        return $this->timeZone;
    }

    /**
     * @return Date The date component of this date/time.
     */
    public function date()
    {
        return new Date(
            $this->year(),
            $this->month(),
            $this->day(),
            $this->timeZone()
        );
    }

    /**
     * @return TimeOfDay The time component of this date/time.
     */
    public function time()
    {
        return new TimeOfDay(
            $this->hour(),
            $this->minute(),
            $this->second(),
            $this->timeZone()
        );
    }

    /**
     * @return integer The number of seconds since unix epoch (1970-01-01 00:00:00+00:00).
     */
    public function unixTime()
    {
        return gmmktime(
            $this->hour(),
            $this->minute(),
            $this->second(),
            $this->month(),
            $this->day(),
            $this->year()
        ) - $this->timeZone()->offset();
    }

    /**
     * @return NativeDateTime A native PHP DateTime instance representing this time point.
     */
    public function nativeDateTime()
    {
        return new NativeDateTime($this->isoString());
    }

    /**
     * Add a time span to the time point.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     *
     * @return TimePointInterface
     */
    public function add($timeSpan)
    {
        if ($timeSpan instanceof TimeSpanInterface) {
            return $timeSpan->resolveToTimePoint($this);
        }

        return new self(
            $this->year(),
            $this->month(),
            $this->day(),
            $this->hour(),
            $this->minute(),
            $this->second() + $timeSpan,
            $this->timeZone()
        );
    }

    /**
     * Subtract a time span from the time point.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     *
     * @return TimePointInterface
     */
    public function subtract($timeSpan)
    {
        if ($timeSpan instanceof TimeSpanInterface) {
            return $timeSpan->inverse()->resolveToTimePoint($this);
        }

        return new self(
            $this->year(),
            $this->month(),
            $this->day(),
            $this->hour(),
            $this->minute(),
            $this->second() - $timeSpan,
            $this->timeZone()
        );
    }

    /**
     * @param string                  $formatSpecifier The format of the output string.
     * @param FormatterInterface|null $formatter       The formatter to use, or null to use the default.
     *
     * @return string The formatted string.
     */
    public function format($formatSpecifier, FormatterInterface $formatter = null)
    {
        if (null === $formatter) {
            $formatter = DefaultFormatter::instance();
        }

        return $formatter->formatDateTime($this, $formatSpecifier);
    }

    /**
     * @return string A string representing this object in an ISO compatible date time format (YYYY-MM-DDThh:mm:ss[+-]hh:mm).
     */
    public function isoString()
    {
        return Iso8601::formatDateTime(
            $this->year(),
            $this->month(),
            $this->day(),
            $this->hour(),
            $this->minute(),
            $this->second(),
            $this->timeZone()->isoString()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible date time format (YYYY-MM-DDThh:mm:ss[+-]hh:mm).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $year;
    private $month;
    private $day;
    private $hour;
    private $minute;
    private $second;
    private $timeZone;
}

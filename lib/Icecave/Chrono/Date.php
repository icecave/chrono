<?php
namespace Icecave\Chrono;

use DateTime as NativeDateTime;
use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\Detail\Normalizer;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;

/**
 * Represents a date.
 */
class Date extends AbstractTimePoint
{
    /**
     * @param integer       $year     The year component of the date.
     * @param integer       $month    The month component of the date.
     * @param integer       $day      The day component of the date.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     */
    public function __construct(
        $year,
        $month,
        $day,
        TimeZone $timeZone = null
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        Normalizer::normalizeDate($year, $month, $day);

        if ($timeZone === null) {
            $timeZone = new TimeZone;
        }

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->timeZone = $timeZone;

        parent::__construct();
    }

    /**
     * Standard date formats:
     *   YYYY-MM-DD
     *   YYYYMMDD
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Calendar_dates
     *
     * Note: Formats YYYY-MM and YYYYMM for reduced precision are currently not supported.
     *
     * @param string $isoString A string containing a date in any ISO-8601 compatible date format.
     *
     * @return Date The Date constructed from the ISO compatible string and optional time zone.
     */
    public static function fromIsoString($isoString)
    {
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        $date = Iso8601::parseDate($isoString);

        if ($date['offset'] !== null) {
            $timeZone = new TimeZone($date['offset']);
        } else {
            $timeZone = null;
        }

        return new self(
            $date['year'],
            $date['month'],
            $date['day'],
            $timeZone
        );
    }

    /**
     * @param integer       $unixTime The unix timestamp.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     *
     * @return DateTime The Date constructed from the given timestamp and time zone.
     */
    public static function fromUnixTime($unixTime, TimeZone $timeZone = null)
    {
        TypeCheck::get(__CLASS__)->fromUnixTime(func_get_args());

        if ($timeZone) {
            $unixTime += $timeZone->offset();
        }

        $parts = gmdate('Y,m,d', $unixTime);
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);

        list($year, $month, $day) = $parts;

        return new self($year, $month, $day, $timeZone);
    }

    /**
     * @param NativeDateTime $native The native PHP DateTime instance.
     *
     * @return Date The Date constructed from the given instance.
     */
    public static function fromNativeDateTime(NativeDateTime $native)
    {
        TypeCheck::get(__CLASS__)->fromNativeDateTime(func_get_args());

        $unixTime = $native->getTimestamp();
        $transitions = $native->getTimezone()->getTransitions($unixTime, $unixTime);
        $isDst = $transitions && $transitions[0]['isdst'];

        return self::fromUnixTime(
            $unixTime,
            new TimeZone($native->getTimezone()->getOffset($native), $isDst)
        );
    }

    /**
     * @return integer The year component of the date.
     */
    public function year()
    {
        $this->typeCheck->year(func_get_args());

        return $this->year;
    }

    /**
     * @return integer The month component of the date.
     */
    public function month()
    {
        $this->typeCheck->month(func_get_args());

        return $this->month;
    }

    /**
     * @return integer The day component of the date.
     */
    public function day()
    {
        $this->typeCheck->day(func_get_args());

        return $this->day;
    }

    /**
     * @return integer The hours component of the time.
     */
    public function hours()
    {
        $this->typeCheck->hours(func_get_args());

        return 0;
    }

    /**
     * @return integer The minutes component of the time.
     */
    public function minutes()
    {
        $this->typeCheck->minutes(func_get_args());

        return 0;
    }

    /**
     * @return integer The seconds component of the time.
     */
    public function seconds()
    {
        $this->typeCheck->seconds(func_get_args());

        return 0;
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
        $this->typeCheck->toTimeZone(func_get_args());

        if ($this->timeZone()->isEqualTo($timeZone)) {
            return $this;
        }

        $offset = $timeZone->offset()
                - $this->timeZone()->offset();

        return new DateTime(
            $this->year(),
            $this->month(),
            $this->day(),
            0,
            0,
            $offset,
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
        $this->typeCheck->toUtc(func_get_args());

        return $this->toTimeZone(new TimeZone);
    }

    /**
     * @return TimeZone The time zone of the time.
     */
    public function timeZone()
    {
        $this->typeCheck->timeZone(func_get_args());

        return $this->timeZone;
    }

    /**
     * Create a {@see DateTime} instance from this date and the given {@see TimeOfDay} component.
     *
     * The timezone of the time component will be coverted to the timezone of this date.
     *
     * @param TimeOfDay $time The time component.
     *
     * @return DateTime A {@see DateTime instance} consiting of this date and the given time component.
     */
    public function at(TimeOfDay $time)
    {
        $this->typeCheck->at(func_get_args());

        $time = $time->toTimeZone($this->timeZone());

        return new DateTime(
            $this->year(),
            $this->month(),
            $this->day(),
            $time->hours(),
            $time->minutes(),
            $time->seconds(),
            $this->timeZone()
        );
    }

    /**
     * @return integer The number of seconds since unix epoch (1970-01-01 00:00:00+00:00).
     */
    public function unixTime()
    {
        $this->typeCheck->unixTime(func_get_args());

        return gmmktime(
            0,
            0,
            0,
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
        $this->typeCheck->nativeDateTime(func_get_args());

        return new NativeDateTime($this->format('c'));
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
        $this->typeCheck->add(func_get_args());

        if ($timeSpan instanceof TimeSpanInterface) {
            return $timeSpan->resolveToTimePoint($this);
        }

        return new DateTime(
            $this->year(),
            $this->month(),
            $this->day(),
            0,
            0,
            $timeSpan
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
        $this->typeCheck->subtract(func_get_args());

        if ($timeSpan instanceof TimeSpanInterface) {
            return $timeSpan->inverse()->resolveToTimePoint($this);
        }

        return new DateTime(
            $this->year(),
            $this->month(),
            $this->day(),
            0,
            0,
            -$timeSpan
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
        $this->typeCheck->format(func_get_args());

        if (null === $formatter) {
            $formatter = DefaultFormatter::instance();
        }

        return $formatter->formatDate($this, $formatSpecifier);
    }

    /**
     * @return string A string representing this object in an ISO compatible date format (YYYY-MM-DD).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        return Iso8601::formatDate(
            $this->year(),
            $this->month(),
            $this->day()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible date format (YYYY-MM-DD).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $typeCheck;
    private $year;
    private $month;
    private $day;
    private $timeZone;
}

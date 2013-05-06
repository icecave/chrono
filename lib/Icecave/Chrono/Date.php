<?php
namespace Icecave\Chrono;

use DateTime as NativeDateTime;
use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Chrono\Support\Normalizer;
use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

/**
 * Represents a date.
 */
class Date implements TimePointInterface
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
    }

    /**
     * @param string $isoDate A string containing a date in any ISO-8601 compatible format.
     *
     * @return Date The Date constructed from the ISO compatible string and optional time zone.
     */
    public static function fromIsoString($isoDate)
    {
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        $matches = array();
        if (preg_match(self::FORMAT_EXTENDED, $isoDate, $matches) === 1 ||
            preg_match(self::FORMAT_BASIC, $isoDate, $matches) === 1) {

            $year = intval($matches[1]);
            $month = intval($matches[2]);
            $day = intval($matches[3]);

            if (count($matches) > 4 && strlen($matches[4]) > 0) {
                $timeZone = TimeZone::fromIsoString($matches[4]);
            } else {
                $timeZone = null;
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO date: "' . $isoDate . '".');
        }

        return new self($year, $month, $day, $timeZone);
    }

    /**
     * @param integer $unixTime The unix timestamp.
     *
     * @return Date The Date constructed from the given timestamp.
     */
    public static function fromUnixTime($unixTime)
    {
        TypeCheck::get(__CLASS__)->fromUnixTime(func_get_args());

        $parts = gmdate('Y,m,d', $unixTime);
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);

        list($year, $month, $day) = $parts;

        return new self($year, $month, $day);
    }

    /**
     * @param NativeDateTime $native The native PHP DateTime instance.
     *
     * @return Date The Date constructed from the given instance.
     */
    public static function fromNativeDateTime(NativeDateTime $native)
    {
        TypeCheck::get(__CLASS__)->fromNativeDateTime(func_get_args());

        return self::fromUnixTime($native->getTimestamp());
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

        if ($this->timeZone()->compare($timeZone) === 0) {
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
     * Perform a {@see strcmp} style comparison with another time point.
     *
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return integer 0 if $this and $timePoint are equal, <0 if $this < $timePoint, or >0 if $this > $timePoint.
     */
    public function compare(TimePointInterface $timePoint)
    {
        $this->typeCheck->compare(func_get_args());

        // Identical ...
        if ($this === $timePoint) {
            return 0;

        // Another date ...
        } elseif ($timePoint instanceof self) {
            return $this->year() - $timePoint->year()
                ?: $this->month() - $timePoint->month()
                ?: $this->day() - $timePoint->day()
                ?: $this->timeZone()->compare($timePoint->timeZone());
        }

        // Fallback to timestamp calculation ...
        return $this->unixTime() - $timePoint->unixTime();
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

        return new NativeDateTime($this->isoString());
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
     * @return string A string representing this object in an ISO compatible format (YYYY-MM-DD).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        return sprintf(
            '%04d-%02d-%02d',
            $this->year(),
            $this->month(),
            $this->day()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible format (YYYY-MM-DD).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    const FORMAT_BASIC    = '/^(\d\d\d\d)(\d\d)(\d\d)(.*)$/';
    const FORMAT_EXTENDED = '/^(\d\d\d\d)-(\d\d)-(\d\d)(.*)$/';

    private $typeCheck;
    private $year;
    private $month;
    private $day;
    private $timeZone;
}

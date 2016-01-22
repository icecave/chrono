<?php

namespace Icecave\Chrono;

use DateTime as NativeDateTime;
use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\Detail\Normalizer;
use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Parity\AbstractExtendedComparable;
use Icecave\Parity\Exception\NotComparableException;
use Icecave\Parity\SubClassComparableInterface;

class TimeOfDay extends AbstractExtendedComparable implements TimeInterface, SubClassComparableInterface
{
    /**
     * @param integer       $hour     The hour component of the time.
     * @param integer       $minute   The minute component of the time.
     * @param integer       $second   The second component of the time.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     */
    public function __construct(
        $hour = 0,
        $minute = 0,
        $second = 0,
        TimeZone $timeZone = null
    ) {
        Normalizer::normalizeTime($hour, $minute, $second);

        if ($timeZone === null) {
            $timeZone = new TimeZone();
        }

        $this->hour     = $hour;
        $this->minute   = $minute;
        $this->second   = $second;
        $this->timeZone = $timeZone;
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
     * @return TimeOfDay The TimeOfDay constructed from the ISO compatible string and optional time zone.
     */
    public static function fromIsoString($isoString)
    {
        $time = Iso8601::parseTime($isoString);

        if ($time['offset'] !== null) {
            $timeZone = new TimeZone($time['offset']);
        } else {
            $timeZone = null;
        }

        return new self(
            $time['hour'],
            $time['minute'],
            $time['second'],
            $timeZone
        );
    }

    /**
     * @param integer       $unixTime The unix timestamp.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     *
     * @return TimeOfDay The TimeOfDay constructed from the given timestamp and time zone.
     */
    public static function fromUnixTime($unixTime, TimeZone $timeZone = null)
    {
        if ($timeZone) {
            $unixTime += $timeZone->offset();
        }

        $parts = gmdate('H,i,s', $unixTime);
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);

        list($hour, $minute, $second) = $parts;

        return new self($hour, $minute, $second, $timeZone);
    }

    /**
     * @param NativeDateTime $native The native PHP DateTime instance.
     *
     * @return TimeOfDay The TimeOfDay constructed from the given instance.
     */
    public static function fromNativeDateTime(NativeDateTime $native)
    {
        $unixTime    = $native->getTimestamp();
        $transitions = $native->getTimezone()->getTransitions($unixTime, $unixTime);
        $isDst       = $transitions && $transitions[0]['isdst'];

        return self::fromUnixTime(
            $unixTime,
            new TimeZone($native->getTimezone()->getOffset($native), $isDst)
        );
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
     * @param TimeZone $timeZone The target timezone
     *
     * @return TimeOfDay
     */
    public function toTimeZone(TimeZone $timeZone)
    {
        if ($this->timeZone()->isEqualTo($timeZone)) {
            return $this;
        }

        $offset = $timeZone->offset()
                - $this->timeZone()->offset();

        return new self(
            $this->hour(),
            $this->minute(),
            $this->second() + $offset,
            $timeZone
        );
    }

    /**
     * Convert this time to the UTC timezone.
     *
     * @return TimeOfDay
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
     * Create a {@see DateTime} instance from this time and the given {@see Date} component.
     *
     * The timezone of the date component will be coverted to the timezone of this time.
     *
     * @param Date $date The date component.
     *
     * @return DateTime A {@see DateTime instance} consiting of this time and the given date component.
     */
    public function on(Date $date)
    {
        $date = $date->toTimeZone($this->timeZone());

        return new DateTime(
            $date->year(),
            $date->month(),
            $date->day(),
            $this->hour(),
            $this->minute(),
            $this->second(),
            $this->timeZone()
        );
    }

     /**
      * Compare this object with another value, yielding a result according to the following table:
      *
      * +--------------------+---------------+
      * | Condition          | Result        |
      * +--------------------+---------------+
      * | $this == $value    | $result === 0 |
      * | $this < $value     | $result < 0   |
      * | $this > $value     | $result > 0   |
      * +--------------------+---------------+
      *
      * @param mixed $time The time to compare.
      *
      * @return integer                0 if $this and $time are equal, <0 if $this < $time, or >0 if $this > $time.
      * @throws NotComparableException Indicates that the implementation does not know how to compare $this to $time.
      */
     public function compare($time)
     {
         if (!$time instanceof self) {
             throw new NotComparableException($this, $time);
         }

         return ($this->totalSeconds() - $this->timeZone()->offset())
              - ($time->totalSeconds() - $time->timeZone()->offset());
     }

     /**
      * @return integer The total number of seconds since 00:00.
      */
     public function totalSeconds()
     {
         return $this->hour() * 3600
              + $this->minute() * 60
              + $this->second();
     }

     /**
      * @param string $formatSpecifier The format of the output string.
      * @param FormatterInterface|null $formatter The formatter to use, or null to use the default.
      *
      * @return string The formatted string.
      */
     public function format($formatSpecifier, FormatterInterface $formatter = null)
     {
         if (null === $formatter) {
             $formatter = DefaultFormatter::instance();
         }

         return $formatter->formatTimeOfDay($this, $formatSpecifier);
     }

    /**
     * @return string A string representing this object in an ISO compatible time format (hh:mm:ss[+-]hh:mm).
     */
    public function isoString()
    {
        return Iso8601::formatTime(
            $this->hour(),
            $this->minute(),
            $this->second(),
            $this->timeZone()->isoString()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible time format (hh:mm:ss[+-]hh:mm).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $hour;
    private $minute;
    private $second;
    private $timeZone;
}

<?php
namespace Icecave\Chrono;

use DateTime as NativeDateTime;
use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Chrono\Support\Normalizer;
use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

class TimeOfDay implements TimeInterface
{
    /**
     * @param integer       $hours    The hours component of the time.
     * @param integer       $minutes  The minutes component of the time.
     * @param integer       $seconds  The seconds component of the time.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     */
    public function __construct(
        $hours = 0,
        $minutes = 0,
        $seconds = 0,
        TimeZone $timeZone = null
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        Normalizer::normalizeTime($hours, $minutes, $seconds);

        if ($timeZone === null) {
            $timeZone = new TimeZone;
        }

        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
        $this->timeZone = $timeZone;
    }

    /**
     * @param string $isoTime A string containing a time in any ISO-8601 compatible format.
     *
     * @return TimeOfDay The TimeOfDay constructed from the ISO compatible string and optional time zone.
     */
    public static function fromIsoString($isoTime)
    {
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        $matches = array();
        if (preg_match(self::FORMAT_EXTENDED, $isoTime, $matches) === 1 ||
            preg_match(self::FORMAT_BASIC, $isoTime, $matches) === 1) {

            $hour = intval($matches[1]);
            $minute = intval($matches[2]);
            $second = intval($matches[3]);

            if (count($matches) > 4 && strlen($matches[4]) > 0) {
                $timeZone = TimeZone::fromIsoString($matches[4]);
            } else {
                $timeZone = null;
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO time: "' . $isoTime . '".');
        }

        return new self($hour, $minute, $second, $timeZone);
    }

    /**
     * @param integer       $unixTime The unix timestamp.
     * @param TimeZone|null $timeZone The time zone of the time, or null to use UTC.
     *
     * @return TimeOfDay The TimeOfDay constructed from the given timestamp and time zone.
     */
    public static function fromUnixTime($unixTime, TimeZone $timeZone = null)
    {
        TypeCheck::get(__CLASS__)->fromUnixTime(func_get_args());

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
     * @return integer The hours component of the time.
     */
    public function hours()
    {
        $this->typeCheck->hours(func_get_args());

        return $this->hours;
    }

    /**
     * @return integer The minutes component of the time.
     */
    public function minutes()
    {
        $this->typeCheck->minutes(func_get_args());

        return $this->minutes;
    }

    /**
     * @return integer The seconds component of the time.
     */
    public function seconds()
    {
        $this->typeCheck->seconds(func_get_args());

        return $this->seconds;
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
        $this->typeCheck->toTimeZone(func_get_args());

        if ($this->timeZone()->compare($timeZone) === 0) {
            return $this;
        }

        $offset = $timeZone->offset()
                - $this->timeZone()->offset();

        return new TimeOfDay(
            $this->hours(),
            $this->minutes(),
            $this->seconds() + $offset,
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
        $this->typeCheck->on(func_get_args());

        $date = $date->toTimeZone($this->timeZone());

        return new DateTime(
            $date->year(),
            $date->month(),
            $date->day(),
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            $this->timeZone()
        );
    }

    /**
     * Perform a {@see strcmp} style comparison with another time.
     *
     * @param TimeOfDay $time The time to compare.
     *
     * @return integer 0 if $this and $time are equal, <0 if $this < $time, or >0 if $this > $time.
     */
     public function compare(TimeOfDay $time)
     {
         $this->typeCheck->compare(func_get_args());

         // Identical ...
         if ($this === $time) {
             return 0;

         // Another date ...
         } else {
             return $this->hours() - $time->hours()
                 ?: $this->minutes() - $time->minutes()
                 ?: $this->seconds() - $time->seconds()
                 ?: $this->timeZone()->compare($time->timeZone());
         }
     }

     /**
      * @return integer The total number of seconds since 00:00.
      */
     public function totalSeconds()
     {
         $this->typeCheck->totalSeconds(func_get_args());

         return $this->hours() * 3600
              + $this->minutes() * 60
              + $this->seconds();
     }

     /**
      * @param string $formatSpecifier The format of the output string.
      * @param FormatterInterface|null $formatter The formatter to use, or null to use the default.
      *
      * @return string The formatted string.
      */
     public function format($formatSpecifier, FormatterInterface $formatter = null)
     {
         $this->typeCheck->format(func_get_args());

         if (null === $formatter) {
             $formatter = DefaultFormatter::instance();
         }

         return $formatter->formatTimeOfDay($this, $formatSpecifier);
     }

    /**
     * @return string A string representing this object in an ISO compatible format (HH:MM:SS[+-]HH:MM).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        return sprintf(
            '%02d:%02d:%02d%s',
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            $this->timeZone()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible format (HH:MM:SS[+-]HH:MM).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    const FORMAT_BASIC    = '/^(\d\d)(\d\d)(\d\d)(.*)$/';
    const FORMAT_EXTENDED = '/^(\d\d):(\d\d):(\d\d)(.*)$/';

    private $typeCheck;
    private $hours;
    private $minutes;
    private $seconds;
    private $timeZone;
}

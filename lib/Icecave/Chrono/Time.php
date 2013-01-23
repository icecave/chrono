<?php
namespace Icecave\Chrono;

use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Chrono\Support\Normalizer;
use Icecave\Chrono\TypeCheck\TypeCheck;

class Time implements TimeInterface
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
     * @return Time
     */
    public function toTimeZone(TimeZone $timeZone)
    {
        $this->typeCheck->toTimeZone(func_get_args());

        if ($this->timeZone()->compare($timeZone) === 0) {
            return $this;
        }

        $offset = $timeZone->offset()
                - $this->timeZone()->offset();

        return new Time(
            $this->hours(),
            $this->minutes(),
            $this->seconds() + $offset,
            $timeZone
        );
    }

    /**
     * Convert this time to the UTC timezone.
     *
     * @return Time
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
     * @param Time $time The time to compare.
     *
     * @return integer 0 if $this and $time are equal, <0 if $this < $time, or >0 if $this > $time.
     */
     public function compare(Time $time)
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

         return $formatter->formatTime($this, $formatSpecifier);
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

    private $typeCheck;
    private $hours;
    private $minutes;
    private $seconds;
    private $timeZone;
}

<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Month;
use Icecave\Chrono\Time;
use Icecave\Chrono\TimeZone;
use Icecave\Chrono\Year;

abstract class AbstractClock implements ClockInterface
{
    /**
     * @return Time The current local time.
     */
    public function localTime()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Time($hours, $minutes, $seconds, $this->timeZone());
    }

    /**
     * @return DateTime The current local date/time.
     */
    public function localDateTime()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new DateTime($year, $month, $day, $hours, $minutes, $seconds, $this->timeZone());
    }

    /**
     * @return Date The current local date.
     */
    public function localDate()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Date($year, $month, $day);
    }

    /**
     * @return Month The current local month.
     */
    public function localMonth()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Month($year, $month);
    }

    /**
     * @return Year The current local year.
     */
    public function localYear()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Year($year);
    }

    /**
     * @return Time The current UTC time.
     */
    public function utcTime()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Time($hours, $minutes, $seconds);
    }

    /**
     * @return DateTime The current UTC date/time.
     */
    public function utcDateTime()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new DateTime($year, $month, $day, $hours, $minutes, $seconds);
    }

    /**
     * @return Date The current UTC date.
     */
    public function utcDate()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Date($year, $month, $day);
    }

    /**
     * @return Month The current UTC month.
     */
    public function utcMonth()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Month($year, $month);
    }

    /**
     * @return Year The current UTC year.
     */
    public function utcYear()
    {
        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Year($year);
    }

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}.
     */
    abstract protected function localTimeInfo();

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, but for the UTC timezone.
     */
    abstract protected function utcTimeInfo();
}

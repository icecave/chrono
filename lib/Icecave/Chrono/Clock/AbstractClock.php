<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\Time;
use Icecave\Chrono\TimeZone;

abstract class AbstractClock implements SuspendableClockInterface
{
    /**
     * @return Time The current local time.
     */
    public function localTime()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Time($hours, $minutes, $seconds, $this->timeZone());
    }

    /**
     * @return DateTime The current local date/time.
     */
    public function localDateTime()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new DateTime($year, $month, $day, $hours, $minutes, $seconds, $this->timeZone());
    }

    /**
     * @return Date The current local date.
     */
    public function localDate()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Date($year, $month, $day);
    }

    /**
     * @return Month The current local month.
     */
    public function localMonth()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Month(new Year($year), $month);
    }

    /**
     * @return Year The current local year.
     */
    public function localYear()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->localTimeInfo();

        return new Year($year);
    }

    /**
     * @return Time The current UTC time.
     */
    public function utcTime()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Time($hours, $minutes, $seconds);
    }

    /**
     * @return DateTime The current UTC date/time.
     */
    public function utcDateTime()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new DateTime($year, $month, $day, $hours, $minutes, $seconds);
    }

    /**
     * @return Date The current UTC date.
     */
    public function utcDate()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Date($year, $month, $day);
    }

    /**
     * @return Month The current UTC month.
     */
    public function utcMonth()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Month(new Year($year), $month);
    }

    /**
     * @return Year The current UTC year.
     */
    public function utcYear()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year) = $this->utcTimeInfo();

        return new Year($year);
    }

    /**
     * @return TimeZone The local timezone.
     */
    public function timeZone()
    {
        $lock = new ScopedSuspension($this);

        list($seconds, $minutes, $hours, $day, $month, $year, $weekDay, $yearDay, $isDst, $offset) = $this->localTimeInfo();

        return new TimeZone($offset, $isDst ? true : false);
    }

    /**
     * Suspend the clock at the current time.
     */
    public function suspend()
    {
        if (1 === ++$this->suspendCount) {
            $this->suspendState = array(
                $this->currentLocalTimeInfo(),
                $this->currentUtcTimeInfo()
            );
        } else {
            // coverage
            strval('foo');
        }
    }

    /**
     * Resume the clock from the current real time.
     *
     * {@see SuspendableClockInterface::resume()} must be called an equal number of times as {@see SuspendableClockInterface::suspend()}
     * at which time the clock resumes from the current time (not the time at which it was suspended).
     *
     * It is not an error to resume an un-suspended clock.
     */
    public function resume()
    {
        if (0 !== $this->suspendCount) {
            if (0 === --$this->suspendCount) {
                $this->suspendState = null;
            } else {
                // coverage
                strval('foo');
            }
        } else {
            // coverage
            strval('foo');
        }
    }

    /**
     * @return True if the clock is currently suspended; otherwise, false.
     */
    public function isSuspended()
    {
        return 0 !== $this->suspendCount;
    }

    /**
     * The clock MUST be suspended before calling this method.
     *
     * @return array<integer> A tuple containing time information, as per {@see localtime()}.
     */
    protected function localTimeInfo()
    {
        return $this->suspendState[0];
    }

    /**
     * The clock MUST be suspended before calling this method.
     *
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, but for the UTC timezone.
     */
    protected function utcTimeInfo()
    {
        return $this->suspendState[1];
    }

    /**
     * Fetch the current local time information, bypassing suspended state.
     *
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds.
     */
    abstract protected function currentLocalTimeInfo();

    /**
     * Fetch the current UTC time information, bypassing suspended state.
     *
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds, but for the UTC timezone.
     */
    abstract protected function currentUtcTimeInfo();

    private $suspendCount = 0;
    private $suspendState = null;
}

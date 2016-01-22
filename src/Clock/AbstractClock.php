<?php

namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\TimeOfDay;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\Timer\Timer;
use Icecave\Chrono\Timer\TimerInterface;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;
use Icecave\Chrono\TimeZone;
use Icecave\Isolator\Isolator;

abstract class AbstractClock implements SuspendableClockInterface
{
    /**
     * @param Isolator|null $isolator
     */
    public function __construct(Isolator $isolator = null)
    {
        $this->isolator = Isolator::get($isolator);
    }

    /**
     * @return TimeOfDay The current local time.
     */
    public function localTime()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedLocalTimeInfo();

        return new TimeOfDay($hour, $minute, $second, $this->timeZone());
    }

    /**
     * @return DateTime The current local date/time.
     */
    public function localDateTime()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedLocalTimeInfo();

        return new DateTime($year, $month, $day, $hour, $minute, $second, $this->timeZone());
    }

    /**
     * @return Date The current local date.
     */
    public function localDate()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedLocalTimeInfo();

        return new Date($year, $month, $day, $this->timeZone());
    }

    /**
     * @return Month The current local month.
     */
    public function localMonth()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedLocalTimeInfo();

        return new Month(new Year($year), $month);
    }

    /**
     * @return Year The current local year.
     */
    public function localYear()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedLocalTimeInfo();

        return new Year($year);
    }

    /**
     * @return TimeOfDay The current UTC time.
     */
    public function utcTime()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedUtcTimeInfo();

        return new TimeOfDay($hour, $minute, $second);
    }

    /**
     * @return DateTime The current UTC date/time.
     */
    public function utcDateTime()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedUtcTimeInfo();

        return new DateTime($year, $month, $day, $hour, $minute, $second);
    }

    /**
     * @return Date The current UTC date.
     */
    public function utcDate()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedUtcTimeInfo();

        return new Date($year, $month, $day);
    }

    /**
     * @return Month The current UTC month.
     */
    public function utcMonth()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedUtcTimeInfo();

        return new Month(new Year($year), $month);
    }

    /**
     * @return Year The current UTC year.
     */
    public function utcYear()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year) = $this->suspendedUtcTimeInfo();

        return new Year($year);
    }

    /**
     * @return TimeZone The local timezone.
     */
    public function timeZone()
    {
        $lock = new ScopedSuspension($this);

        list($second, $minute, $hour, $day, $month, $year, $weekDay, $yearDay, $isDst, $offset) = $this->suspendedLocalTimeInfo();

        return new TimeZone($offset, $isDst ? true : false);
    }

    /**
     * @return integer The current time as a unix timestamp.
     */
    public function unixTime()
    {
        $lock          = new ScopedSuspension($this);
        list($seconds) = $this->suspendedUnixTime();

        return $seconds;
    }

    /**
     * @return float The current time as a unix timestamp, including partial seconds.
     */
    public function unixTimeAsFloat()
    {
        $lock                        = new ScopedSuspension($this);
        list($seconds, $nanoseconds) = $this->suspendedUnixTime();

        return $seconds + $nanoseconds / 1000000000;
    }

    /**
     * Suspend the clock at the current time.
     */
    public function suspend()
    {
        if (1 === ++$this->suspendCount) {
            $this->suspendState = array(
                $this->currentLocalTimeInfo(),
                $this->currentUtcTimeInfo(),
                $this->currentUnixTime(),
            );
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
        if (0 !== $this->suspendCount && 0 === --$this->suspendCount) {
            $this->suspendState = null;
        }
    }

    /**
     * @return boolean True if the clock is currently suspended; otherwise, false.
     */
    public function isSuspended()
    {
        return 0 !== $this->suspendCount;
    }

    /**
     * Sleep for the given time span.
     *
     * @param TimeSpanInterface|integer $timeSpan        A time span instance, or an integer representing seconds.
     * @param boolean                   $dispatchSignals True to dispatch to signal handlers when sleep is interrupted.
     * @param boolean                   $restart         True to continue sleeping after interrupt.
     *
     * @return boolean True if the sleep completed, false if the sleep was interrupted.
     */
    public function sleep($timeSpan, $dispatchSignals = true, $restart = false)
    {
        $timePoint = $this->localDateTime()->add($timeSpan);

        return $this->sleepUntil($timePoint, $dispatchSignals, $restart);
    }

    /**
     * Sleep until the given time point.
     *
     * @param TimePointInterface $timePoint       The the point to sleep until.
     * @param boolean            $dispatchSignals True to dispatch to signal handlers when sleep is interrupted.
     * @param boolean            $restart         True to continue sleeping after interrupt.
     *
     * @return boolean True if the sleep completed, false if the sleep was interrupted.
     */
    public function sleepUntil(TimePointInterface $timePoint, $dispatchSignals = true, $restart = false)
    {
        if (!$this->isolator->function_exists('pcntl_signal_dispatch')) {
            $dispatchSignals = false;
        }

        do {
            $remaining = $timePoint->differenceAsSeconds($this->localDateTime());

            if ($remaining <= 0) {
                return true;
            } elseif ($this->doSleep($remaining)) {
                return $this->localDateTime()->isGreaterThanOrEqualTo($timePoint);
            } elseif ($dispatchSignals) {
                $this->isolator->pcntl_signal_dispatch();
            }
        } while ($restart);

        return false;
    }

    /**
     * The clock MUST be suspended before calling this method.
     *
     * @return array<integer> A tuple containing time information, as per {@see localtime()}.
     */
    protected function suspendedLocalTimeInfo()
    {
        return $this->suspendState[0];
    }

    /**
     * The clock MUST be suspended before calling this method.
     *
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, but for the UTC timezone.
     */
    protected function suspendedUtcTimeInfo()
    {
        return $this->suspendState[1];
    }

    /**
     * The clock MUST be suspended before calling this method.
     *
     * @return tuple<integer,integer> The Unix time as a 2-tuple of seconds and nanoseconds.
     */
    protected function suspendedUnixTime()
    {
        return $this->suspendState[2];
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

    /**
     * Fetch the current unix timestamp, bypassing suspended state.
     *
     * @return tuple<integer,integer> The current Unix time as a 2-tuple of seconds and nanoseconds.
     */
    abstract protected function currentUnixTime();

    /**
     * @param integer $seconds The number of seconds to sleep.
     *
     * @return boolean True if the sleep completed; or false if the sleep was interrupted.
     */
    abstract protected function doSleep($seconds);

    /**
     * Create a new timer.
     *
     * @return TimerInterface
     */
    public function createTimer()
    {
        return new Timer($this);
    }

    private $suspendCount = 0;
    private $suspendState = null;
    protected $isolator;
}

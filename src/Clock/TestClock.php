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

/**
 * A manually controlled clock designed for time-sensitive unit/functional
 * testing.
 */
class TestClock implements TestClockInterface
{
    /**
     * Construct a new test clock.
     *
     * @param TimePointInterface|null $localDateTime The current local date/time, or null to use the Unix epoch.
     * @param Isolator|null           $isolator      The isolator to use.
     */
    public function __construct(
        TimePointInterface $localDateTime = null,
        Isolator $isolator = null
    ) {
        if (null === $localDateTime) {
            $localDateTime = DateTime::fromUnixTime(0);
        }

        $this->isolator = Isolator::get($isolator);

        $this->setLocalDateTime($localDateTime);
        $this->resume();
    }

    /**
     * Add a time span to the current local date/time.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     */
    public function addTime($timeSpan)
    {
        $this->setLocalDateTime($this->localDateTime()->add($timeSpan));
    }

    /**
     * Subtract a time span from the current local date/time.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     */
    public function subtractTime($timeSpan)
    {
        $this->setLocalDateTime($this->localDateTime()->subtract($timeSpan));
    }

    /**
     * Set the current local date/time.
     *
     * @param TimePointInterface $localDateTime The current local date/time.
     */
    public function setLocalDateTime(TimePointInterface $localDateTime)
    {
        $this->localDateTime = $localDateTime;
    }

    /**
     * @return TimeOfDay The current local time.
     */
    public function localTime()
    {
        return $this->localDateTime()->time();
    }

    /**
     * @return DateTime The current local date/time.
     */
    public function localDateTime()
    {
        return $this->localDateTime;
    }

    /**
     * @return Date The current local date.
     */
    public function localDate()
    {
        return $this->localDateTime()->date();
    }

    /**
     * @return Month The current local month.
     */
    public function localMonth()
    {
        return new Month($this->localYear(), $this->localDateTime()->month());
    }

    /**
     * @return Year The current local year.
     */
    public function localYear()
    {
        return new Year($this->localDate()->year());
    }

    /**
     * @return TimeOfDay The current UTC time.
     */
    public function utcTime()
    {
        return $this->utcDateTime()->time();
    }

    /**
     * @return DateTime The current UTC date/time.
     */
    public function utcDateTime()
    {
        return $this->localDateTime()->toTimeZone(new TimeZone());
    }

    /**
     * @return Date The current UTC date.
     */
    public function utcDate()
    {
        return $this->utcDateTime()->date();
    }

    /**
     * @return Month The current UTC month.
     */
    public function utcMonth()
    {
        return new Month($this->utcYear(), $this->utcDateTime()->month());
    }

    /**
     * @return Year The current UTC year.
     */
    public function utcYear()
    {
        return new Year($this->utcDate()->year());
    }

    /**
     * @return TimeZone The local timezone.
     */
    public function timeZone()
    {
        return $this->localDateTime()->timeZone();
    }

    /**
     * @return integer The current time as a unix timestamp.
     */
    public function unixTime()
    {
        return $this->localDateTime()->unixTime();
    }

    /**
     * @return float The current time as a unix timestamp, including partial seconds.
     */
    public function unixTimeAsFloat()
    {
        return floatval($this->unixTime());
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
        if (!$this->isolator()->function_exists('pcntl_signal_dispatch')) {
            $dispatchSignals = false;
        }

        $remaining = $timePoint->differenceAsSeconds($this->localDateTime());
        $this->addTime($remaining);

        if ($dispatchSignals) {
            $this->isolator()->pcntl_signal_dispatch();
        }

        return true;
    }

    /**
     * Create a new timer.
     *
     * @return TimerInterface
     */
    public function createTimer()
    {
        return new Timer($this);
    }

    /**
     * Suspend the clock at the current time.
     */
    public function suspend()
    {
        $this->isSuspended = true;
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
        $this->isSuspended = false;
    }

    /**
     * @return boolean True if the clock is currently suspended; otherwise, false.
     */
    public function isSuspended()
    {
        return $this->isSuspended;
    }

    /**
     * Get the isolator.
     *
     * @return Isolator The isolator.
     */
    public function isolator()
    {
        return $this->isolator;
    }

    private $localDateTime;
    private $isSuspended;
    private $isolator;
}

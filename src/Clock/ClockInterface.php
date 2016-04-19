<?php

namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\TimeOfDay;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\Timer\TimerInterface;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;
use Icecave\Chrono\TimeZone;

/**
 * A clock is used to produce date and time measurments.
 *
 * In most production code {@see SystemClock} should be used.
 */
interface ClockInterface
{
    /**
     * @return TimeOfDay The current local time.
     */
    public function localTime();

    /**
     * @return DateTime The current local date/time.
     */
    public function localDateTime();

    /**
     * @return Date The current local date.
     */
    public function localDate();

    /**
     * @return Month The current local month.
     */
    public function localMonth();

    /**
     * @return Year The current local year.
     */
    public function localYear();

    /**
     * @return TimeOfDay The current UTC time.
     */
    public function utcTime();

    /**
     * @return DateTime The current UTC date/time.
     */
    public function utcDateTime();

    /**
     * @return Date The current UTC date.
     */
    public function utcDate();

    /**
     * @return Month The current UTC month.
     */
    public function utcMonth();

    /**
     * @return Year The current UTC year.
     */
    public function utcYear();

    /**
     * @return TimeZone The local timezone.
     */
    public function timeZone();

    /**
     * @return integer The current time as a unix timestamp.
     */
    public function unixTime();

    /**
     * @return float The current time as a unix timestamp, including partial seconds.
     */
    public function unixTimeAsFloat();

    /**
     * Sleep for the given time span.
     *
     * @param TimeSpanInterface|integer $timeSpan        A time span instance, or an integer representing seconds.
     * @param boolean                   $dispatchSignals True to dispatch to signal handlers when sleep is interrupted.
     * @param boolean                   $restart         True to continue sleeping after interrupt.
     *
     * @return boolean True if the sleep completed, false if the sleep was interrupted.
     */
    public function sleep($timeSpan, $dispatchSignals = true, $restart = false);

    /**
     * Sleep until the given time point.
     *
     * @param TimePointInterface $timePoint       The the point to sleep until.
     * @param boolean            $dispatchSignals True to dispatch to signal handlers when sleep is interrupted.
     * @param boolean            $restart         True to continue sleeping after interrupt.
     *
     * @return boolean True if the sleep completed, false if the sleep was interrupted.
     */
    public function sleepUntil(TimePointInterface $timePoint, $dispatchSignals = true, $restart = false);

    /**
     * Create a new timer.
     *
     * @return TimerInterface
     */
    public function createTimer();
}

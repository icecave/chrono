<?php

namespace Icecave\Chrono\Clock;

use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;

/**
 * The interface implemented by test clocks.
 */
interface TestClockInterface extends SuspendableClockInterface
{
    /**
     * Add a time span to the current local date/time.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     */
    public function addTime($timeSpan);

    /**
     * Subtract a time span from the current local date/time.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     */
    public function subtractTime($timeSpan);

    /**
     * Set the current local date/time.
     *
     * @param TimePointInterface $localDateTime The current local date/time.
     */
    public function setLocalDateTime(TimePointInterface $localDateTime);
}

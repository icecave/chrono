<?php

namespace Icecave\Chrono\Clock;

/**
 * A suspendable clock can be "paused" and "resumed".
 */
interface SuspendableClockInterface extends ClockInterface
{
    /**
     * Suspend the clock at the current time.
     */
    public function suspend();

    /**
     * Resume the clock from the current real time.
     *
     * {@see SuspendableClockInterface::resume()} must be called an equal number of times as {@see SuspendableClockInterface::suspend()}
     * at which time the clock resumes from the current time (not the time at which it was suspended).
     *
     * It is not an error to resume an un-suspended clock.
     */
    public function resume();

    /**
     * @return boolean True if the clock is currently suspended; otherwise, false.
     */
    public function isSuspended();
}

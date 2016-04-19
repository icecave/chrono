<?php

namespace Icecave\Chrono\Timer;

/**
 * A re-usable timer.
 */
interface TimerInterface
{
    /**
     * Check if the timer is currently running.
     *
     * @return boolean True if the timer is running; otherwise, false.
     */
    public function isRunning();

    /**
     * Check if the timer has been stopped.
     *
     * @return boolean True if the timer is was running and has since been stopped; otherwise, false.
     */
    public function isStopped();

    /**
     * True if the timer has been reset, and is ready to be started again.
     *
     * @return boolean True if the timer has been reset; otherwise, false.
     */
    public function isReset();

    /**
     * Stop and reset the timer.
     */
    public function reset();

    /**
     * Start the timer.
     *
     * Performs no action if the timer is already running.
     */
    public function start();

    /**
     * Stop the timer if it is running.
     *
     * @return float The total number of seconds the timer has been running.
     */
    public function stop();

    /**
     * Resume the timer.
     *
     * If the timer is not running it will be started.
     *
     * If the timer is stopped it will be re-started, {@see Timer::elapsed()} will
     * not include the length of time during which the timer was stopped.
     *
     * @return float The total number of seconds the timer has been running.
     */
    public function resume();

    /**
     * Fetch the number of seconds the timer has been running.
     *
     * @return float The total number of seconds the timer has been running.
     */
    public function elapsed();
}

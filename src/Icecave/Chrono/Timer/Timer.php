<?php
namespace Icecave\Chrono\Timer;

use Icecave\Chrono\Clock\ClockInterface;
use Icecave\Chrono\Clock\SystemClock;
use Icecave\Chrono\TypeCheck\TypeCheck;

/**
 * A re-usable timer.
 */
class Timer implements TimerInterface
{
    /**
     * @param ClockInterface|null $clock The clock to use, or null to use the system clock.
     */
    public function __construct(ClockInterface $clock = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $clock) {
            $clock = new SystemClock;
        }

        $this->clock = $clock;

        $this->reset();
    }

    /**
     * Fetch the clock used for time measurements.
     *
     * @return ClockInterface
     */
    public function clock()
    {
        $this->typeCheck->clock(func_get_args());

        return $this->clock;
    }

    /**
     * Check if the timer is currently running.
     *
     * @return boolean True if the timer is running; otherwise, false.
     */
     public function isRunning()
    {
        $this->typeCheck->isRunning(func_get_args());

        return null !== $this->startedAt
            && null === $this->stoppedAt;
    }

    /**
     * Check if the timer has been stopped.
     *
     * @return boolean True if the timer is was running and has since been stopped; otherwise, false.
     */
    public function isStopped()
    {
        $this->typeCheck->isStopped(func_get_args());

        return null !== $this->stoppedAt;
    }

    /**
     * True if the timer has been reset, and is ready to be started again.
     *
     * @return boolean True if the timer has been reset; otherwise, false.
     */
    public function isReset()
    {
        $this->typeCheck->isReset(func_get_args());

        return null === $this->startedAt
            && null === $this->stoppedAt;
    }

    /**
     * Stop and reset the timer.
     */
    public function reset()
    {
        $this->typeCheck->reset(func_get_args());

        $this->startedAt = null;
        $this->stoppedAt = null;
    }

    /**
     * Start the timer.
     *
     * Performs no action if the timer is already running.
     */
    public function start()
    {
        $this->typeCheck->start(func_get_args());

        if (!$this->isRunning()) {
            $this->reset();
            $this->startedAt = $this->clock->unixTimeAsFloat();
        }
    }

    /**
     * Stop the timer if it is running.
     *
     * @return float The total number of seconds the timer has been running.
     */
    public function stop()
    {
        $this->typeCheck->stop(func_get_args());

        if ($this->isRunning()) {
            $this->stoppedAt = $this->clock->unixTimeAsFloat();
        }

        return $this->elapsed();
    }

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
    public function resume()
    {
        $this->typeCheck->resume(func_get_args());

        $elapsed = $this->elapsed();

        if ($this->isStopped()) {
            $pauseLength = $this->clock->unixTimeAsFloat() - $this->stoppedAt;
            $this->startedAt += $pauseLength;
            $this->stoppedAt = null;
        } elseif ($this->isReset()) {
            $this->start();
        }

        return $elapsed;
    }

    /**
     * Fetch the number of seconds the timer has been running.
     *
     * @return float The total number of seconds the timer has been running.
     */
    public function elapsed()
    {
        $this->typeCheck->elapsed(func_get_args());

        if ($this->isStopped()) {
            return $this->stoppedAt - $this->startedAt;
        } elseif ($this->isRunning()) {
            return $this->clock->unixTimeAsFloat() - $this->startedAt;
        } else {
            return 0.0;
        }
    }

    private $typeCheck;
    private $clock;
    private $startedAt;
    private $stoppedAt;
}

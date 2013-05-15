<?php
namespace Icecave\Chrono\Timer;

use Icecave\Chrono\Clock\ClockInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;

class StatisticalTimer extends Timer
{
    /**
     * @param ClockInterface|null $clock The clock to use, or null to use the system clock.
     */
    public function __construct(ClockInterface $clock = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->resetStatistics();

        parent::__construct($clock);
    }

    /**
     * @return float The minimum elapsed time of a single timer run since {@see StatisticalTimer::resetStatistics()} was last called.
     */
    public function minimumElapsed()
    {
        $this->typeCheck->minimumElapsed(func_get_args());

        if (null === $this->minimumElapsed) {
            return 0.0;
        }

        return $this->minimumElapsed;
    }

    /**
     * @return float The maximum elapsed time of a single timer run since {@see StatisticalTimer::resetStatistics()} was last called.
     */
    public function maximumElapsed()
    {
        $this->typeCheck->maximumElapsed(func_get_args());

        return $this->maximumElapsed;
    }

    /**
     * @return float The total elapsed time across all timer runs since {@see StatisticalTimer::resetStatistics()} was last called.
     */
    public function totalElapsed()
    {
        $this->typeCheck->totalElapsed(func_get_args());

        return $this->totalElapsed;
    }

    /**
     * @return integer The number of times the timer has been run since {@see StatisticalTimer::resetStatistics()} was last called.
     */
    public function count()
    {
        $this->typeCheck->count(func_get_args());

        return $this->count;
    }

    /**
     * @return float The average elapsed time across all timer runs since {@see StatisticalTimer::resetStatistics()} was last called.
     */
    public function averageElapsed()
    {
        $this->typeCheck->averageElapsed(func_get_args());

        return $this->totalElapsed / $this->count;
    }

    public function resetStatistics()
    {
        $this->typeCheck->resetStatistics(func_get_args());

        $this->minimumElapsed = null;
        $this->maximumElapsed = 0.0;
        $this->totalElapsed = 0.0;
        $this->count = 0;
    }

    /**
     * Reset the timer.
     */
    public function reset()
    {
        $this->typeCheck->reset(func_get_args());

        if (!$this->isReset()) {
            $elapsed = $this->elapsed();

            if (null === $this->minimumElapsed || $elapsed < $this->min) {
                $this->minimumElapsed = $elapsed;
            }

            if ($elapsed > $this->maximumElapsed) {
                $this->maximumElapsed = $elapsed;
            }

            $this->totalElapsed += $elapsed;

            ++$this->count;
        }

        parent::reset();
    }

    private $typeCheck;
    private $minimumElapsed;
    private $maximumElapsed;
    private $totalElapsed;
    private $count;
}

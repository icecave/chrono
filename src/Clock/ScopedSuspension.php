<?php

namespace Icecave\Chrono\Clock;

/**
 * Create a scoped clock suspension.
 *
 * Automatically resumes a clock when it goes out of scope.
 */
class ScopedSuspension
{
    /**
     * @param SuspendableClockInterface $clock
     */
    public function __construct(SuspendableClockInterface $clock)
    {
        // Suspend before assigning, so that no resume is performed in case of failure.
        $clock->suspend();

        $this->clock = $clock;
    }

    public function __destruct()
    {
        if ($this->clock) {
            $this->clock->resume();
        }
    }

    private $clock;
}

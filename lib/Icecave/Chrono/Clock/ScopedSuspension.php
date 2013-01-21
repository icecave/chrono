<?php
namespace Icecave\Chrono\Clock;

class ScopedSuspension
{
    public function __construct(SuspendableClockInterface $clock)
    {
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

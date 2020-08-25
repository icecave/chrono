<?php

namespace Icecave\Chrono\Clock;

use Phake;
use PHPUnit\Framework\TestCase;

class ScopedSuspensionTest extends TestCase
{
    public function setUp(): void
    {
        $this->clock = Phake::mock(__NAMESPACE__ . '\SuspendableClockInterface');
    }

    public function testLock()
    {
        $lock = new ScopedSuspension($this->clock);

        Phake::verify($this->clock, Phake::times(1))->suspend();
        Phake::verify($this->clock, Phake::times(0))->resume();

        unset($lock);

        Phake::verify($this->clock, Phake::times(1))->resume();

        // Ensure that the test is not marked risky, as Phake verifications are
        // not recognised by PHPUnit as assertions.
        $this->assertTrue(true);
    }
}

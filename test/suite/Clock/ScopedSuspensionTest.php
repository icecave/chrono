<?php

namespace Icecave\Chrono\Clock;

use Phake;
use PHPUnit_Framework_TestCase;

class ScopedSuspensionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
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
    }
}

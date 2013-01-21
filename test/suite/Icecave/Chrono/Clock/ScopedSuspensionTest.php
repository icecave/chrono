<?php
namespace Icecave\Chrono\Clock;

use PHPUnit_Framework_TestCase;
use Phake;

class ScopedSuspensionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_clock = Phake::mock(__NAMESPACE__ . '\SuspendableClockInterface');
    }

    public function testLock()
    {
        $lock = new ScopedSuspension($this->_clock);
        
        Phake::verify($this->_clock, Phake::times(1))->suspend();
        Phake::verify($this->_clock, Phake::times(0))->resume();

        unset($lock);

        Phake::verify($this->_clock, Phake::times(1))->resume();
    }
}

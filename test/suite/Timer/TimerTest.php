<?php

namespace Icecave\Chrono\Timer;

use Phake;
use PHPUnit_Framework_TestCase;

class TimerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->clock = Phake::mock('Icecave\Chrono\Clock\ClockInterface');

        Phake::when($this->clock)
            ->unixTimeAsFloat()
            ->thenReturn(0.5)
            ->thenReturn(1.0)
            ->thenReturn(1.5)
            ->thenReturn(2.0)
            ->thenReturn(2.5)
            ->thenReturn(3.0)
            ->thenReturn(3.5)
            ->thenReturn(4.0);

        $this->timer = new Timer($this->clock);
    }

    public function testConstructorDefaults()
    {
        $timer = new Timer();

        $this->assertInstanceOf('Icecave\Chrono\Clock\SystemClock', $timer->clock());
    }

    public function testIsRunning()
    {
        $this->assertFalse($this->timer->isRunning());
        $this->timer->start();
        $this->assertTrue($this->timer->isRunning());
        $this->timer->stop();
        $this->assertFalse($this->timer->isRunning());
        $this->timer->resume();
        $this->assertTrue($this->timer->isRunning());
        $this->timer->stop();
        $this->assertFalse($this->timer->isRunning());
        $this->timer->reset();
        $this->assertFalse($this->timer->isRunning());
    }

    public function testIsStopped()
    {
        $this->assertFalse($this->timer->isStopped());
        $this->timer->start();
        $this->assertFalse($this->timer->isStopped());
        $this->timer->stop();
        $this->assertTrue($this->timer->isStopped());
        $this->timer->resume();
        $this->assertFalse($this->timer->isStopped());
        $this->timer->stop();
        $this->assertTrue($this->timer->isStopped());
        $this->timer->reset();
        $this->assertFalse($this->timer->isStopped());
    }

    public function testIsReset()
    {
        $this->assertTrue($this->timer->isReset());
        $this->timer->start();
        $this->assertFalse($this->timer->isReset());
        $this->timer->stop();
        $this->assertFalse($this->timer->isReset());
        $this->timer->resume();
        $this->assertFalse($this->timer->isReset());
        $this->timer->stop();
        $this->assertFalse($this->timer->isReset());
        $this->timer->reset();
        $this->assertTrue($this->timer->isReset());
    }

    public function testStart()
    {
        $this->timer->start();

        $this->assertSame(0.5, $this->timer->elapsed());
    }

    public function testStartWhileRunningIsNoOp()
    {
        $this->timer->start();
        $this->timer->start();

        $this->assertSame(0.5, $this->timer->elapsed());
    }

    public function testStop()
    {
        $this->timer->start();
        $this->assertSame(0.5, $this->timer->stop());
        $this->assertSame(0.5, $this->timer->elapsed());
    }

    public function testStopWhileStoppedIsNoOp()
    {
        $this->timer->start();
        $this->assertSame(0.5, $this->timer->stop());
        $this->assertSame(0.5, $this->timer->stop());
    }

    public function testResume()
    {
        $this->timer->start();
        $this->assertSame(0.5, $this->timer->stop());
        $this->assertSame(0.5, $this->timer->resume());
        $this->assertSame(1.0, $this->timer->stop());
    }

    public function testResumeWhileRunningIsNoOp()
    {
        $this->timer->start();
        $this->assertSame(0.5, $this->timer->resume());
        $this->assertSame(1.0, $this->timer->stop());
    }

    public function testResumeWhileReset()
    {
        $this->timer->resume();
        $this->assertSame(0.5, $this->timer->stop());
    }

    public function testElapsed()
    {
        $this->assertSame(0.0, $this->timer->elapsed());
        $this->timer->start();
        $this->assertSame(0.5, $this->timer->elapsed());
        $this->timer->stop();
        $this->assertSame(1.0, $this->timer->elapsed());
        $this->timer->resume();
        $this->assertSame(1.5, $this->timer->elapsed());
        $this->timer->stop();
        $this->assertSame(2.0, $this->timer->elapsed());
        $this->timer->reset();
        $this->assertSame(0.0, $this->timer->elapsed());
    }
}

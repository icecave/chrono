<?php

namespace Icecave\Chrono\Clock;

use Eloquent\Liberator\Liberator;
use Icecave\Chrono\DateTime;
use Icecave\Isolator\Isolator;
use Phake;
use PHPUnit\Framework\TestCase;

class SystemClockTest extends TestCase
{
    public function setUp()
    {
        $this->isolator = Phake::partialMock('Icecave\Isolator\Isolator');
        $this->clock    = new SystemClock($this->isolator);

        Phake::when($this->isolator)->microtime(true)->thenReturn(1384917020.123456);
    }

    public function testCurrentUnixTime()
    {
        $actual           = Liberator::liberate($this->clock)->currentUnixTime();
        $actualDateTime   = $this->clock->utcDateTime();
        $expectedDateTime = new DateTime(2013, 11, 20, 3, 10, 20);

        $this->assertInternalType('array', $actual);
        $this->assertSame(array(0, 1), array_keys($actual));
        $this->assertSame(1384917020, $actual[0]);
        $this->assertEquals(123456000, $actual[1], '', 1000);
        $this->assertEquals($expectedDateTime, $actualDateTime);
    }

    public function testDoSleep()
    {
        $clock = Liberator::liberate($this->clock);

        Phake::when($this->isolator)
            ->sleep(Phake::anyParameters())
            ->thenReturn(0);

        $result = $clock->doSleep(10);

        Phake::verify($this->isolator)->sleep(10);

        $this->assertTrue($result);
    }

    public function testDoSleepInterrupted()
    {
        $clock = Liberator::liberate($this->clock);

        Phake::when($this->isolator)
            ->sleep(Phake::anyParameters())
            ->thenReturn(101);

        $result = $clock->doSleep(10);

        Phake::verify($this->isolator)->sleep(10);

        $this->assertFalse($result);
    }
}

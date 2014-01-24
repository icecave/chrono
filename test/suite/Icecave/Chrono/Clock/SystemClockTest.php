<?php
namespace Icecave\Chrono\Clock;

use Eloquent\Liberator\Liberator;
use Icecave\Chrono\DateTime;
use Icecave\Isolator\Isolator;
use Phake;
use PHPUnit_Framework_TestCase;

class SystemClockTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->isolator = Phake::partialMock(get_class(Isolator::get()));
        $this->clock = new SystemClock($this->isolator);

        Phake::when($this->isolator)
            ->microtime(true)
            ->thenReturn(1384917020.25);
    }

    public function testCurrentUnixTime()
    {
        $result = $this->clock->utcDateTime();
        $expected = new DateTime(2013, 11, 20, 3, 10, 20);
        $this->assertEquals($expected, $result);
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

<?php
namespace Icecave\Chrono\Clock;

use Eloquent\Liberator\Liberator;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;
use Icecave\Isolator\Isolator;
use Phake;
use PHPUnit_Framework_TestCase;

class SystemClockTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->isolator = Phake::mock(get_class(Isolator::get()));
        $this->clock = new SystemClock($this->isolator);

        Phake::when($this->isolator)
            ->time()
            ->thenReturn(1358748637);

        Phake::when($this->isolator)
            ->date('s,i,H,d,m,Y,w,z,I,Z', 1358748637)
            ->thenReturn('37,10,16,21,01,2013,1,20,1,36000');

        Phake::when($this->isolator)
            ->gmdate('s,i,H,d,m,Y,w,z,0,0', 1358748637)
            ->thenReturn('37,10,06,21,01,2013,1,20,0,0');
    }

    public function testUnixTime()
    {
        $this->assertSame(1358748637, $this->clock->unixTime());
    }

    public function testCurrentLocalTimeInfo()
    {
        $result = $this->clock->localDateTime();
        $expected = new DateTime(2013, 1, 21, 16, 10, 37, new TimeZone(36000, true));
        $this->assertEquals($expected, $result);
    }

    public function testCurrentUtcTimeInfo()
    {
        $result = $this->clock->utcDateTime();
        $expected = new DateTime(2013, 1, 21, 6, 10, 37, new TimeZone);
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

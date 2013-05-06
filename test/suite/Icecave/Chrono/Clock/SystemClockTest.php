<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;
use PHPUnit_Framework_TestCase;
use Phake;
use Icecave\Isolator\Isolator;

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
}

<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\TimeZone;
use Icecave\Isolator\Isolator;

class SystemClock extends AbstractClock
{
    /**
     * @param Isolator|null $isolator
     */
    public function __construct(Isolator $isolator = null)
    {
        $this->isolator = Isolator::get($isolator);
    }

    /**
     * @return integer The current time as a unix timestamp.
     */
    public function unixTime()
    {
        return $this->isolator->time();
    }

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds.
     */
    protected function currentLocalTimeInfo()
    {
        $parts = $this->isolator->date('s,i,H,d,m,Y,w,z,I,Z', $this->unixTime());
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);
        return $parts;
    }

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds, but for the UTC timezone.
     */
    protected function currentUtcTimeInfo()
    {
        $parts = $this->isolator->gmdate('s,i,H,d,m,Y,w,z,0,0', $this->unixTime());
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);
        return $parts;
    }

    private $isolator;
}

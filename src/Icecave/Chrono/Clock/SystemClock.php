<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\TimeZone;
use Icecave\Isolator\Isolator;

/**
 * A clock that uses the system to obtain real wall-clock date/times.
 */
class SystemClock extends AbstractClock
{
    /**
     * @param Isolator|null $isolator
     */
    public function __construct(Isolator $isolator = null)
    {
        parent::__construct($isolator);
    }

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds.
     */
    protected function currentLocalTimeInfo()
    {
        $parts = $this->isolator->date('s,i,H,d,m,Y,w,z,I,Z', intval($this->currentUnixTime()));
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);

        return $parts;
    }

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds, but for the UTC timezone.
     */
    protected function currentUtcTimeInfo()
    {
        $parts = $this->isolator->gmdate('s,i,H,d,m,Y,w,z,0,0', intval($this->currentUnixTime()));
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);

        return $parts;
    }

    /**
     * @return float The current time as a unix timestamp, including partial seconds.
     */
    public function currentUnixTime()
    {
        return $this->isolator->microtime(true);
    }

    /**
     * @param integer $seconds The number of seconds to sleep.
     *
     * @return boolean True if the sleep completed; or false if the sleep was interrupted.
     */
    protected function doSleep($seconds)
    {
        return 0 === $this->isolator->sleep($seconds);
    }
}

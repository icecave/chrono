<?php

namespace Icecave\Chrono\Clock;

use Icecave\Chrono\TimeZone;

/**
 * A clock that uses the system to obtain real wall-clock date/times.
 */
class SystemClock extends AbstractClock
{
    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds.
     */
    protected function currentLocalTimeInfo()
    {
        list($seconds) = $this->currentUnixTime();
        $parts         = $this->isolator->date('s,i,H,d,m,Y,w,z,I,Z', $seconds);
        $parts         = explode(',', $parts);
        $parts         = array_map('intval', $parts);

        return $parts;
    }

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds, but for the UTC timezone.
     */
    protected function currentUtcTimeInfo()
    {
        list($seconds) = $this->currentUnixTime();
        $parts         = $this->isolator->gmdate('s,i,H,d,m,Y,w,z,0,0', $seconds);
        $parts         = explode(',', $parts);
        $parts         = array_map('intval', $parts);

        return $parts;
    }

    /**
     * Fetch the current unix timestamp, bypassing suspended state.
     *
     * @return tuple<integer,integer> The current Unix time as a 2-tuple of seconds and nanoseconds.
     */
    protected function currentUnixTime()
    {
        $microtime = $this->isolator->microtime(true);
        $seconds   = intval($microtime);

        return array($seconds, intval(($microtime - $seconds) * 1000000000));
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

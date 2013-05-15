<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\TimeZone;
use Icecave\Chrono\TypeCheck\TypeCheck;
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
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        parent::__construct($isolator);
    }

    /**
     * @return integer The current time as a unix timestamp.
     */
    public function unixTime()
    {
        $this->typeCheck->unixTime(func_get_args());

        return $this->isolator->time();
    }

    /**
     * @return float The current time as a unix timestamp, including partial seconds.
     */
    public function unixTimeAsFloat()
    {
        $this->typeCheck->unixTimeAsFloat(func_get_args());

        return $this->isolator->microtime(true);
    }

    /**
     * @return array<integer> A tuple containing time information, as per {@see localtime()}, plus the timezone offset in seconds.
     */
    protected function currentLocalTimeInfo()
    {
        $this->typeCheck->currentLocalTimeInfo(func_get_args());

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
        $this->typeCheck->currentUtcTimeInfo(func_get_args());

        $parts = $this->isolator->gmdate('s,i,H,d,m,Y,w,z,0,0', $this->unixTime());
        $parts = explode(',', $parts);
        $parts = array_map('intval', $parts);

        return $parts;
    }

    /**
     * @param integer $seconds The number of seconds to sleep.
     *
     * @return boolean True if the sleep completed; or false if the sleep was interrupted.
     */
    protected function doSleep($seconds)
    {
        $this->typeCheck->doSleep(func_get_args());

        return 0 === $this->isolator->sleep($seconds);
    }

    private $typeCheck;
}

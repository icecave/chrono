<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\TimeZone;
use Icecave\Isolator\Isolator;
use Icecave\Chrono\TypeCheck\TypeCheck;

class SystemClock extends AbstractClock
{
    /**
     * @param Isolator|null $isolator
     */
    public function __construct(Isolator $isolator = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->isolator = Isolator::get($isolator);

        parent::__construct();
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

    private $typeCheck;
    private $isolator;
}

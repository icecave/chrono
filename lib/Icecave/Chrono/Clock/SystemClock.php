<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Month;
use Icecave\Chrono\Time;
use Icecave\Chrono\TimeZone;
use Icecave\Chrono\Year;
use Icecave\Isolator\Isolator;

class SystemClock extends ClockBase
{
    public function __construct(Isolator $isolator = null)
    {
        parent::__construct($isolator);
    }

    public function timeZone()
    {
        $offset = $this->isolator->date('Z');
        return new TimeZone(
            intval($offset / 60),
            $offset % 60
        );
    }

    public function unixTime()
    {
        return $this->isolator->time();
    }

    private $isolator;
    private $timeZone;
}

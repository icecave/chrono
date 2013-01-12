<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Month;
use Icecave\Chrono\Time;
use Icecave\Chrono\TimeZone;
use Icecave\Chrono\Year;

interface IClock
{
    /**
     * @return Time
     */
    public function localTime();

    /**
     * @return DateTime
     */
    public function localDateTime();

    /**
     * @return Date
     */
    public function localDate();

    /**
     * @return Month
     */
    public function localMonth();

    /**
     * @return Year
     */
    public function localYear();

    /**
     * @return Time
     */
    public function utcTime();

    /**
     * @return DateTime
     */
    public function utcDateTime();

    /**
     * @return Date
     */
    public function utcDate();

    /**
     * @return Month
     */
    public function utcMonth();

    /**
     * @return Year
     */
    public function utcYear();

    /**
     * @return TimeZone
     */
    public function timeZone();

    /**
     * @return integer
     */
    public function unixTime();
}

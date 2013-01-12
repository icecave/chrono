<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Month;
use Icecave\Chrono\Time;
use Icecave\Chrono\TimeZone;
use Icecave\Chrono\Year;
use Icecave\Isolator\Isolator;

abstract class ClockBase implements IClock
{
    public function __construct(Isolator $isolator = null)
    {
        $this->isolator = Isolator::get($isolator);
    }

    /**
     * @return Time
     */
    public function localTime()
    {
        $timestamp = $this->unixTime();
        return new Time(
            $this->isolator->date('H', $timestamp),
            $this->isolator->date('i', $timestamp),
            $this->isolator->date('s', $timestamp),
            $this->timeZone()
        );
    }

    /**
     * @return DateTime
     */
    public function localDateTime()
    {
        $timestamp = $this->unixTime();
        return new DateTime(
            $this->isolator->date('Y', $timestamp),
            $this->isolator->date('m', $timestamp),
            $this->isolator->date('d', $timestamp),
            $this->isolator->date('H', $timestamp),
            $this->isolator->date('i', $timestamp),
            $this->isolator->date('s', $timestamp),
            $this->timeZone()
        );
    }

    /**
     * @return Date
     */
    public function localDate()
    {
        $timestamp = $this->unixTime();
        return new Date(
            $this->isolator->date('Y', $timestamp),
            $this->isolator->date('m', $timestamp),
            $this->isolator->date('d', $timestamp)
        );
    }

    /**
     * @return Month
     */
    public function localMonth()
    {
        $timestamp = $this->unixTime();
        return new Month(
            $this->isolator->date('Y', $timestamp),
            $this->isolator->date('m', $timestamp),
        );
    }

    /**
     * @return Year
     */
    public function localYear()
    {
        $timestamp = $this->unixTime();
        return new Month(
            $this->isolator->date('Y', $timestamp)
        );
    }

    /**
     * @return Time
     */
    public function utcTime()
    {
        $timestamp = $this->unixTime();
        return new Time(
            $this->isolator->gmdate('H', $timestamp),
            $this->isolator->gmdate('i', $timestamp),
            $this->isolator->gmdate('s', $timestamp)
        );
    }

    /**
     * @return DateTime
     */
    public function utcDateTime()
    {
        $timestamp = $this->unixTime();
        return new DateTime(
            $this->isolator->gmdate('Y', $timestamp),
            $this->isolator->gmdate('m', $timestamp),
            $this->isolator->gmdate('d', $timestamp),
            $this->isolator->gmdate('H', $timestamp),
            $this->isolator->gmdate('i', $timestamp),
            $this->isolator->gmdate('s', $timestamp)
        );
    }

    /**
     * @return Date
     */
    public function utcDate();
    {
        $timestamp = $this->unixTime();
        return new Date(
            $this->isolator->gmdate('Y', $timestamp),
            $this->isolator->gmdate('m', $timestamp),
            $this->isolator->gmdate('d', $timestamp)
        );
    }

    /**
     * @return Month
     */
    public function utcMonth()
    {
        $timestamp = $this->unixTime();
        return new Month(
            $this->isolator->gmdate('Y', $timestamp),
            $this->isolator->gmdate('m', $timestamp),
        );
    }

    /**
     * @return Year
     */
    public function utcYear()
    {
        $timestamp = $this->unixTime();
        return new Year(
            $this->isolator->date('Y', $timestamp)
        );
    }
    
    protected $isolator;
}

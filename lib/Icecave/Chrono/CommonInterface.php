<?php
namespace Icecave\Chrono;

/**
 * Base interface for all measures of dates and/or times.
 */
interface CommonInterface extends Iso8601Interface
{
    // /**
    //  * @param TimeZone $timeZone
    //  *
    //  * @return ComponentInterface
    //  */
    // public function toTimeZone(TimeZone $timeZone);
    // 
    // /**
    //  * @return ComponentInterface
    //  */
    // public function toUtc();

    /**
     * @return TimeZone The time zone of the time point.
     */
    public function timeZone();
}

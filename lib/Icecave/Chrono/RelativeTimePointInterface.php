<?php
namespace Icecave\Chrono;

/**
 * Base interface for all measures of date and time.
 */
interface RelativetimePointInterface extends Iso8601Interface
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

    /**
     * @link http://en.wikipedia.org/wiki/ISO_8601
     *
     * @return string A string representing this object in an ISO compatible format.
     */
    public function isoString();

    /**
     * @link http://en.wikipedia.org/wiki/ISO_8601
     *
     * @return string A string representing this object in an ISO compatible format.
     */
    public function __toString();
}

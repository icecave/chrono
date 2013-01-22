<?php
namespace Icecave\Chrono;

/**
 * Base interface for all measures that contain a time.
 */
interface TimeInterface extends Iso8601Interface
{
    /**
     * @return integer The hours component of the time.
     */
    public function hours();

    /**
     * @return integer The minutes component of the time.
     */
    public function minutes();

    /**
     * @return integer The seconds component of the time.
     */
    public function seconds();

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

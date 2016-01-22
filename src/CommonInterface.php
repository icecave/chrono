<?php

namespace Icecave\Chrono;

use Icecave\Chrono\Format\FormattableInterface;

/**
 * Base interface for all measures of dates and/or times.
 */
interface CommonInterface extends Iso8601Interface, FormattableInterface
{
    /**
     * Convert this date/time to a different timezone.
     *
     * @param TimeZone $timeZone The target timezone
     *
     * @return ComponentInterface
     */
    public function toTimeZone(TimeZone $timeZone);

    /**
     * Convert this date/time to the UTC timezone.
     *
     * @return ComponentInterface
     */
    public function toUtc();

    /**
     * @return TimeZone The time zone of the time point.
     */
    public function timeZone();
}

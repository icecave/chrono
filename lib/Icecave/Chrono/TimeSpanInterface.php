<?php
namespace Icecave\Chrono;

/**
 * A common interface for non-anchored blocks of time (periods and durations).
 */
interface TimeSpanInterface
{
    /**
     * Resolve the time span to a total number of seconds, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return integer The total number of seconds.
     */
    public function resolve(TimePointInterface $timePoint);
}

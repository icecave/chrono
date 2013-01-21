<?php
namespace Icecave\Chrono;

/**
 * Represents a concrete point on the time continuum.
 */
interface TimePointInterface extends IsoRepresentationInterface
{
    /**
     * Perform a {@see strcmp} style comparison with another time point.
     *
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return integer 0 if $this and $timePoint are equal, <0 if $this < $timePoint, or >0 if $this > $timePoint.
     */
    public function compare(TimePointInterface $timePoint);
}

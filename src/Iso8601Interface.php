<?php

namespace Icecave\Chrono;

/**
 * Interface for types that have a string representation defined in ISO 8601.
 *
 * @link http://en.wikipedia.org/wiki/ISO_8601
 */
interface Iso8601Interface
{
    /**
     * @return string A string representing this object in an ISO compatible format.
     */
    public function isoString();

    /**
     * @return string A string representing this object in an ISO compatible format.
     */
    public function __toString();
}

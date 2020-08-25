<?php

namespace Icecave\Chrono;

/**
 * Base interface for all measures that contain a time.
 */
interface TimeInterface extends CommonInterface
{
    /**
     * @return int The hour component of the time.
     */
    public function hour();

    /**
     * @return int The minute component of the time.
     */
    public function minute();

    /**
     * @return int The second component of the time.
     */
    public function second();
}

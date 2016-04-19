<?php

namespace Icecave\Chrono;

/**
 * Base interface for all measures that contain a time.
 */
interface TimeInterface extends CommonInterface
{
    /**
     * @return integer The hour component of the time.
     */
    public function hour();

    /**
     * @return integer The minute component of the time.
     */
    public function minute();

    /**
     * @return integer The second component of the time.
     */
    public function second();
}

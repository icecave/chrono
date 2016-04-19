<?php

namespace Icecave\Chrono;

/**
 * Base interface for all measures that contain a date.
 */
interface DateInterface extends CommonInterface
{
    /**
     * @return integer The year component of the date.
     */
    public function year();

    /**
     * @return integer The month component of the date.
     */
    public function month();

    /**
     * @return integer The day component of the date.
     */
    public function day();

    /**
     * @return integer ISO-8601 numeric representation of the day of the week, 1 (for Monday) through 7 (for Sunday).
     */
    public function isoDayOfWeek();

    /**
     * @return integer Numeric representation of the day of the week, 0 (for Sunday) through 6 (for Saturday).
     */
    public function numericDayOfWeek();
}

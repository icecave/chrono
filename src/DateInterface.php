<?php

namespace Icecave\Chrono;

/**
 * Base interface for all measures that contain a date.
 */
interface DateInterface extends CommonInterface
{
    /**
     * @return int The year component of the date.
     */
    public function year();

    /**
     * @return int The month component of the date.
     */
    public function month();

    /**
     * @return int The day component of the date.
     */
    public function day();

    /**
     * @return int ISO-8601 numeric representation of the day of the week, 1 (for Monday) through 7 (for Sunday).
     */
    public function isoDayOfWeek();

    /**
     * @return int Numeric representation of the day of the week, 0 (for Sunday) through 6 (for Saturday).
     */
    public function numericDayOfWeek();
}

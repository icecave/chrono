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
}

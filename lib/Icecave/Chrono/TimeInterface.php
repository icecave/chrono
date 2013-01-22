<?php
namespace Icecave\Chrono;

/**
 * Base interface for all measures that contain a time.
 */
interface TimeInterface extends CommonInterface
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
}

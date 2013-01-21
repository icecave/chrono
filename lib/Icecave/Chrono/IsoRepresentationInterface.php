<?php
namespace Icecave\Chrono;

interface IsoRepresentationInterface
{
    /**
     * @link http://en.wikipedia.org/wiki/ISO_8601
     *
     * @return string A string representing this object in an ISO compatible format.
     */
    public function isoString();

    /**
     * @link http://en.wikipedia.org/wiki/ISO_8601
     *
     * @return string A string representing this object in an ISO compatible format.
     */
    public function __toString();
}

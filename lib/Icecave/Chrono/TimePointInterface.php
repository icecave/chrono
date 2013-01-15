<?php
namespace Icecave\Chrono;

interface TimePointInterface
{
    public function compare(TimePointInterface $timePoint);
}

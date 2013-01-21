<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Interval;

class IntervalTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('start', 0, 'Icecave\\Chrono\\TimePointInterface');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('end', 1, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function start(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function end(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}

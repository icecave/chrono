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

    public function fromIsoString(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoString', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoString',
                0,
                $arguments[0],
                'string'
            );
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

    public function isoString(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function validateToString(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}

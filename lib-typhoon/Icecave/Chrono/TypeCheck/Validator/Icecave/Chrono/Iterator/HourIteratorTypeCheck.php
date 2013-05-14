<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Iterator;

class HourIteratorTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startTime', 0, 'Icecave\\Chrono\\TimePointInterface');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('iterations', 1, 'integer|null');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        if (!(\is_int($value) || $value === null)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'iterations',
                1,
                $arguments[1],
                'integer|null'
            );
        }
    }

    public function current(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}

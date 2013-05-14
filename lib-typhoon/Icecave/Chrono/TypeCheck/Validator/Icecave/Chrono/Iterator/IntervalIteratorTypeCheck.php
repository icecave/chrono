<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Iterator;

class IntervalIteratorTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('interval', 0, 'Icecave\\Chrono\\Interval\\IntervalInterface');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('timeSpan', 1, 'Icecave\\Chrono\\TimeSpan\\TimeSpanInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function current(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function key(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function next(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function rewind(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function valid(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}

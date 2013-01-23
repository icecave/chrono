<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Support;

class OrdinalTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function suffix(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('number', 0, 'integer');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'number',
                0,
                $arguments[0],
                'integer'
            );
        }
    }

}

<?php
namespace Icecave\Chrono\TypeCheck;

class DummyValidator extends AbstractValidator
{
    public function __call($name, array $arguments)
    {
    }

}

<?php

namespace PrinceJohn\Weave\Manipulators;

use Illuminate\Support\Facades\Config;
use PrinceJohn\Weave\Contracts\StringManipulator;
use PrinceJohn\Weave\FunctionDefinition;

class ConfigString implements StringManipulator
{
    public static function handle(FunctionDefinition $definition, ?string $string): string
    {
        return Config::string(
            $definition->firstParameterOrFail($string),
            $definition->getParameterOrFail(1, '')
        );
    }
}

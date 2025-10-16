<?php

namespace PrinceJohn\Weave\Functions;

use Illuminate\Support\Facades\Config;
use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;

class ConfigString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, ?string $string): string
    {
        return Config::string(
            $definition->firstParameterOrFail($string),
            $definition->getParameterOrFail(1, '')
        );
    }
}

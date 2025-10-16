<?php

namespace PrinceJohn\Weave\Functions;

use Illuminate\Support\Facades\Config;
use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;

class ConfigString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, None|string $string): string
    {
        return Config::string(
            $definition->firstParameterOrFail($string),
            $definition->getParameterOrFail(1, '')
        );
    }
}

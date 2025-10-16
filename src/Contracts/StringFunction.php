<?php

namespace PrinceJohn\Weave\Contracts;

use PrinceJohn\Weave\FunctionDefinition;

interface StringFunction
{
    public static function handle(FunctionDefinition $definition, ?string $string): string;
}

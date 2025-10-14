<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\UnsupportedStringFunctionException;

class StringResolver implements Contracts\StringResolver
{
    public function handle(TokenParser $parser, ?string $string = null): ?string
    {
        foreach ($parser->getFunctions() as $blueprint) {
            $string = $this->manipulateString($blueprint, $string);
        }

        return $string;
    }

    protected function manipulateString(FunctionBlueprint $blueprint, ?string $string): string
    {
        return match ($blueprint->function) {
            'after' => Str::after($string, ...$blueprint->parameters),
            'after_last' => Str::afterLast($string, ...$blueprint->parameters),
            'apa', => Str::apa($string),
            'ascii' => Str::ascii($string, ...$blueprint->parameters),

            default => throw new UnsupportedStringFunctionException($blueprint->function),
        };
    }
}

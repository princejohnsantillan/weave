<?php

namespace PrinceJohn\Weave;

readonly class FunctionBlueprint
{
    public function __construct(
        public string $function,
        public array $parameters
    ) {}
}

<?php

namespace PrinceJohn\Weave;

readonly class FunctionBlueprint
{
    public function __construct(
        public string $function,
        /** @var array<string|bool|int> $parameters */
        public array $parameters
    ) {}
}

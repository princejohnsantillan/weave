<?php

namespace PrinceJohn\Weave;

readonly class FunctionBlueprint
{
    public function __construct(
        public string $function,
        /** @var string[] $parameters */
        public array $parameters
    ) {}

    public function hasParameters(): bool
    {
        return ! empty($this->parameters);
    }

    public function getParameter(int $index, ?string $default = null): ?string
    {
        return $this->parameters[$index] ?? $default;
    }

    /** @return array<string|null> */
    public function getParameters(array $map = []): array
    {
        if ($map === []) {
            return $this->parameters;
        }

        $parameters = [];

        if (array_is_list($map)) {
            foreach ($map as $index) {
                $parameters[] = $this->getParameter($index);
            }
        } else {
            foreach ($map as $index => $default) {
                $parameters[] = $this->getParameter($index, $default);
            }
        }

        return $parameters;
    }

    public function firstParameter(): ?string
    {
        return $this->getParameter(0);
    }
}

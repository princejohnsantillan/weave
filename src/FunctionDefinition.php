<?php

namespace PrinceJohn\Weave;

use PrinceJohn\Weave\Exceptions\ParameterDoesNotExistException;

readonly class FunctionDefinition
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

    public function getParameterOrFail(int $index, ?string $default = null): string
    {
        $parameter = $this->getParameter($index, $default);

        if (is_null($parameter)) {
            throw new ParameterDoesNotExistException;
        }

        return $parameter;
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

    public function limitParameters(int $limit): array
    {
        $limit = max(0, $limit - 1);

        if ($limit === 0) {
            return [];
        }

        return $this->getParameters(range(0, $limit));
    }

    public function firstParameter(?string $default = null): ?string
    {
        return $this->getParameter(0, $default);
    }

    public function firstParameterOrFail(?string $default = null): string
    {
        return $this->getParameterOrFail(0, $default);
    }
}

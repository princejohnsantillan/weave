<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\MalformedTokenException;

class TokenParser
{
    protected string $key;

    /** @var FunctionDefinition[] */
    protected array $functionDefinitionList = [];

    public function __construct(protected string $token)
    {
        if (blank($token)) {
            throw MalformedTokenException::blankToken();
        }

        if (Str::substrCount($token, ':') > 1) {
            throw MalformedTokenException::multipleColon();
        }

        $this->key = Str::before($token, ':');

        if (Str::contains($token, ':')) {
            $functionsString = Str::after($token, ':');

            if ($functionsString === '') {
                throw MalformedTokenException::blankFunction();
            }

            $this->identifyFunctions($functionsString);
        }

    }

    private function identifyFunctions(string $functionsString): void
    {
        $functions = explode('|', $functionsString);

        if (blank($functions)) {
            return;
        }

        foreach ($functions as $function) {
            $parameters = explode(',', $function);

            $method = array_shift($parameters);

            $this->functionDefinitionList[] = new FunctionDefinition($method, $parameters);
        }
    }

    public function getKey(): ?string
    {
        return $this->key === '' ? null : $this->key;
    }

    /** @return FunctionDefinition[] */
    public function getFunctionDefinitionList(): array
    {
        return $this->functionDefinitionList;
    }
}

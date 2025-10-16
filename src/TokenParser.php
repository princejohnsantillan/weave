<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\MalformedTokenException;

class TokenParser
{
    protected None|string $key;

    /** @var FunctionDefinition[] */
    protected array $functionDefinitionList = [];

    public function __construct(protected string $token)
    {
        $this->key = new None;

        $token = trim($this->token);

        if (blank($token)) {
            throw MalformedTokenException::blankToken();
        }

        if (Str::substrCount($token, ':') > 1) {
            throw MalformedTokenException::multipleColon();
        }

        $this->key = Str::of($token)->before(':')->trim()->toString();

        if (Str::contains($token, ':')) {
            $functionsString = Str::of($token)->after(':')->trim()->toString();

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

    public function getKey(): None|string
    {
        return $this->key;
    }

    /** @return FunctionDefinition[] */
    public function getFunctionDefinitionList(): array
    {
        return $this->functionDefinitionList;
    }

    public function hasKey(): bool
    {
        return is_string($this->getKey());
    }

    public function hasFunctions(): bool
    {
        return ! empty($this->getFunctionDefinitionList());
    }
}

<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\BlankTokenException;
use PrinceJohn\Weave\Exceptions\MalformedTokenException;

class TokenParser
{
    protected string $key;

    /** @var FunctionBlueprint[] */
    protected array $functions = [];

    public function __construct(protected string $token)
    {
        if (blank($token)) {
            throw new BlankTokenException;
        }

        if (Str::substrCount($token, ':') > 1) {
            throw MalformedTokenException::multipleColonDetected();
        }

        $this->key = Str::before($token, ':');

        if (Str::contains($token, ':')) {
            $this->identifyFunctions(Str::after($token, ':'));
        }

    }

    private function identifyFunctions(string $functionsString): void
    {
        $functions = explode('|', $functionsString);

        if ($functions === []) {
            return;
        }

        foreach ($functions as $function) {
            $parameters = explode(',', $function);

            $method = array_shift($parameters);

            $this->functions[] = new FunctionBlueprint($method, $parameters);
        }
    }

    public function isGenerator(): bool
    {
        return $this->token === '';
    }

    public function isTransformer(): bool
    {
        return $this->token !== '';
    }

    public function getKey(): ?string
    {
        return $this->key === '' ? null : $this->key;
    }

    /** @return FunctionBlueprint[] */
    public function getFunctions(): array
    {
        return $this->functions;
    }
}

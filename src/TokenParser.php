<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\MalformedTokenException;

final class TokenParser
{
    private None|string $key;

    /** @var FunctionDefinition[] */
    private array $functionDefinitionList = [];

    /** @var array<string,string> */
    private array $markMap;

    /** @var array<string,string> */
    private array $unmarkMap;

    public function __construct(private string $token)
    {
        $this->init();

        if (blank($this->token)) {
            throw MalformedTokenException::blankToken();
        }

        if (Str::contains($this->token, '=')) {
            $key = Str::of($this->token)->before('=')->trim()->toString();

            if (filled($key)) {
                $this->key = $this->unmark($key);
            }
        } else {
            $this->key = $this->unmark($this->token);
        }

        if (Str::contains($this->token, '=')) {
            $functionsString = Str::of($this->token)->after('=')->trim()->toString();

            if ($functionsString === '') {
                throw MalformedTokenException::blankFunction();
            }

            $this->identifyFunctions($functionsString);
        }
    }

    private function init(): void
    {
        $this->key = new None;

        // Append Random ID to avoid possible collision with user input.
        $randomId = bin2hex(random_bytes(2));

        $this->markMap = [
            "\=" => "EQUAL_{$randomId}",
            "\|" => "PIPE_{$randomId}",
            "\:" => "COLON_{$randomId}",
            "\," => "COMMA_{$randomId}",
        ];

        $this->unmarkMap = [
            "EQUAL_{$randomId}" => '=',
            "PIPE_{$randomId}" => '|',
            "COLON_{$randomId}" => ':',
            "COMMA_{$randomId}" => ',',
        ];

        $this->token = $this->mark(trim($this->token));
    }

    private function mark(string $string): string
    {
        return Str::swap($this->markMap, $string);
    }

    private function unmark(string $string): string
    {
        return Str::swap($this->unmarkMap, $string);
    }

    private function identifyFunctions(string $functionsString): void
    {
        $functions = explode('|', $functionsString);

        if (blank($functions)) {
            return;
        }

        foreach ($functions as $function) {
            $method = Str::of($function)->before(':')->trim()->toString();

            /** @var string[] $parameters */
            $parameters = Str::contains($function, ':')
                ? Str::of($function)->after(':')->explode(',')->toArray()
                : [];

            $method = $this->unmark($method);

            array_walk($parameters, function (&$parameter) {
                $parameter = $this->unmark($parameter);
            });

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

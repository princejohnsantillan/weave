<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\TokenMatchingFailedException;

class Weaver
{
    protected bool $variablesArrayIsList;

    protected int $tokenCount;

    protected array $placeholders;

    protected array $tokens;

    public function __construct(
        protected string $subject,
        protected array $variables = []
    ) {
        $this->variablesArrayIsList = array_is_list($this->variables);

        $count = preg_match_all('/(?<!\\\\)\{\{\s*([^{}]*?)\s*\}\}(?<!\\\\)/', $subject, $matches);

        if ($count === false) {
            throw new TokenMatchingFailedException;
        }

        $this->tokenCount = $count;

        [$this->placeholders, $this->tokens] = $matches;
    }

    protected function resolveString(int $index, string $token): ?string
    {
        $parser = new TokenParser($token);

        $key = $parser->getKey();

        $string = $this->variablesArrayIsList
            ? $this->getVariable($index)
            : (is_null($key) ? null : $this->getVariable($key));

        return (new StringResolver)->handle($parser, $string);
    }

    protected function getVariable(string $key): ?string
    {
        return $this->variables[$key] ?? null;
    }

    public function weave(): string
    {
        $weaved = $this->subject;

        foreach ($this->tokens as $i => $token) {
            $resolvedString = $this->resolveString($i, $token);

            if ($resolvedString === null) {
                continue;
            }

            $weaved = Str::replaceFirst($this->placeholders[$i], $resolvedString, $weaved);
        }

        return $weaved;
    }
}

<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\TokenMatchingFailedException;

class Weaver
{
    protected bool $variablesArrayIsList;

    protected int $tokenCount;

    /** @var string[] */
    protected array $placeholders;

    /** @var string[] */
    protected array $tokens;

    /** @var array<string|int, string> */
    protected array $variables;

    /** @param string|mixed[] $variables */
    public function __construct(
        protected string $subject,
        string|array ...$variables
    ) {
        $this->variables = str_args(...$variables);

        $this->variablesArrayIsList = array_is_list($this->variables);

        $pattern = Config::string('weaver.token_regex', '/(?<!\\\\)\{\{\s*([^{}]*?)\s*\}\}(?<!\\\\)/');

        $count = preg_match_all($pattern, $subject, $matches);

        if ($count === false) {
            throw new TokenMatchingFailedException;
        }

        $this->tokenCount = $count;

        [$this->placeholders, $this->tokens] = $matches;
    }

    protected function resolveString(int $index, string $token): false|string
    {
        $parser = new TokenParser($token);

        $key = $parser->getKey();

        $string = $this->variablesArrayIsList
            ? $this->getVariable($index)
            : (is_none($key) ? $key : $this->getVariable($key));

        return resolve(Contracts\StringResolver::class)->handle($parser, $string);
    }

    protected function getVariable(string|int $key): None|string
    {
        return $this->variables[$key] ?? new None;
    }

    public function getTokenCount(): int
    {
        return $this->tokenCount;
    }

    /** @return string[] */
    public function getPlaceholders(): array
    {
        return $this->placeholders;
    }

    /** @return string[] */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function weave(): string
    {
        $weaved = $this->subject;

        foreach ($this->tokens as $i => $token) {
            $resolvedString = $this->resolveString($i, $token);

            if ($resolvedString === false) {
                continue;
            }

            $weaved = Str::replaceFirst($this->placeholders[$i], $resolvedString, $weaved);
        }

        return $weaved;
    }
}

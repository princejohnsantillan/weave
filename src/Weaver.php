<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;

class Weaver
{
    private bool $variablesArrayIsList;

    public function __construct(
        private string $subject,
        private array $variables = []
    ) {
        $this->variablesArrayIsList = array_is_list($this->variables);

//        $this->compatibilityCheck();
    }

//    private function compatibilityCheck(): bool
//    {
//        if ($this->variablesArrayIsList) {
//            if (count($this->variables) !== count($this->getTokens())) {
//                throw new \Exception("Number of tokens and variables does not match.");
//            }
//        }
//
//        return true;
//    }

    private function getTokens(): array
    {
        $tokens = [];

        preg_match_all('/(?<!\\\\)\{([^{}]*)\}(?<!\\\\)/', $this->subject, $tokens);

        return $tokens[0];
    }

    private function prepareVariables(): array
    {
        $tokens = $this->getTokens();

        $map = [];

        foreach ($tokens as $i => $token) {
            $map[$token] = $this->getFinalValue($i, $token);
        }

        return $map;
    }

    private function getFinalValue(int $index, string $token)
    {
        $token = Str::squish(Str::between($token, "{{", "}}"));
        $key = Str::before($token, ":");

        if(blank($key)){
            throw new \Exception("Key not found.");
        }

        $value = $this->variables[$this->variablesArrayIsList ? $index : $key];

        $tokenParts = explode(":", $token);

        if (collect($tokenParts)->count() > 1) {
            $transformersString = $tokenParts[1] ?? "";

            $transformers = collect(explode("|", $transformersString))->map(
                fn ($transformer) => Str::squish($transformer)
            );

            foreach ($transformers as $transformer) {
                $value = match($transformer){
                    'config' => config($value),
                    default => Str::{$transformer}($value), //Use php's call user func?
                };
            }
        }

        return $value;
    }

    public function weave(): string
    {
        $finalVariables = $this->prepareVariables();

        $keys = array_keys($finalVariables);
        $values = array_values($finalVariables);

        return Str::of($this->subject)
            ->replace($keys, $values)
            ->value();
    }
}
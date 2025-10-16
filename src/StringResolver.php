<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\Exceptions\NoneException;
use PrinceJohn\Weave\Exceptions\UnsupportedStringFunctionException;

class StringResolver implements Contracts\StringResolver
{
    public function handle(TokenParser $parser, None|string $string): false|string
    {
        foreach ($parser->getFunctionDefinitionList() as $definition) {
            $string = $this->resolveString($definition, $string);

            if (! is_string($string)) {
                return false;
            }
        }

        return is_string($string) ? $string : false;
    }

    protected function resolveString(FunctionDefinition $definition, None|string $string): false|string
    {
        try {
            $resolvedString = $this->useCustomFunctions($definition, $string);

            if ($resolvedString !== false) {
                return $resolvedString;
            }

            $subject = (fn () => ! is_none($string) ? $string : throw new NoneException);
            $first = (fn (): string => $definition->firstParameterOrFail());
            $params = $definition->parameters;

            $resolvedString = match ($definition->function) {
                'after' => Str::of($subject())->after($first()),
                'after_last' => Str::of($subject())->afterLast($first()),
                'apa', => Str::apa($subject()),
                'append' => Str::of($subject())->append(...$params),
                'ascii' => Str::ascii($subject(), ...$params),
                'basename' => basename($subject(), ...$params),
                'before' => Str::of($subject())->before($first()),
                'before_last' => Str::of($subject())->beforeLast($first()),
                'between' => Str::of($subject())->between(...$params),
                'between_first' => Str::of($subject())->betweenFirst(...$params),
                'camel' => Str::camel($subject()),
                'char_at' => (string) Str::of($subject())->charAt($first()),
                'chop_start' => Str::of($subject())->chopStart($first()),
                'chop_end' => Str::of($subject())->chopEnd($first()),
                'class_basename' => class_basename($subject()),
                'decrypt' => Str::of($subject())->decrypt($definition->firstParameterOrFail('1')),
                'deduplicate' => Str::deduplicate($subject(), ...$params),
                'dirname' => dirname($subject(), ...$params),
                'e' => e($subject(), ...$params),
                'encrypt' => encrypt($subject(), ...$params),
                'finish' => Str::of($subject())->finish($first()),
                'from_base64' => (string) Str::fromBase64($subject(), ...$params),
                'hash' => Str::of($subject())->hash($first()),
                'headline' => Str::headline($subject()),
                'inline_markdown' => Str::inlineMarkdown($subject()),
                'kebab' => Str::kebab($subject()),
                'lcfirst' => Str::lcfirst($subject()),
                'length' => (string) Str::length($subject(), ...$params),
                'limit' => Str::limit($subject(), ...$params),
                'lower' => Str::lower($subject()),
                'markdown' => Str::markdown($subject()),
                'mask' => Str::of($subject())->mask(...$params),
                'match' => Str::of($subject())->match($first()),
                'newline' => Str::of($subject())->newLine($definition->firstParameter(1)),
                'ordered_uuid' => (string) Str::orderedUuid(),
                'pad_both' => Str::of($subject())->padBoth(...$params),
                'pad_left' => Str::of($subject())->padLeft(...$params),
                'pad_right' => Str::of($subject())->padRight(...$params),
                'pipe' => Str::of($subject())->pipe($first()),
                'password' => Str::password(...$params),
                'plural' => Str::plural($subject(), ...$params),
                'plural_studly' => Str::pluralStudly($subject(), ...$params),
                'position' => (string) Str::position($subject(), ...$params),
                'prepend' => Str::of($subject())->prepend(...$params),
                'random' => Str::random(...$params),
                'remove' => Str::of($subject())->remove(...$params),
                'repeat' => Str::of($subject())->repeat($first()),
                'replace' => Str::of($subject())->replace(...$params),
                'replace_first' => Str::of($subject())->replaceFirst(...$params),
                'replace_last' => Str::of($subject())->replaceLast(...$params),
                'replace_matches' => Str::of($subject())->replaceMatches(...$params),
                'replace_start' => Str::of($subject())->replaceStart(...$params),
                'replace_end' => Str::of($subject())->replaceEnd(...$params),
                'reverse' => Str::reverse($subject()),
                'singular' => Str::singular($subject()),
                'slug' => Str::slug($subject(), ...$params),
                'snake' => Str::snake($subject(), ...$params),
                'squish' => Str::squish($subject()),
                'start' => Str::of($subject())->start($first()),
                'strip_tags' => strip_tags($subject(), ...$params),
                'studly' => Str::studly($subject()),
                'substr' => Str::of($subject())->substr(...$params),
                'substr_count' => (string) Str::of($subject())->substrCount(...$params),
                'substr_replace' => Str::of($subject())->substrReplace(...$params),
                'take' => Str::of($subject())->take($first()),
                'title' => Str::title($subject()),
                'to_base64' => base64_encode($subject()),
                'transliterate' => Str::transliterate($subject(), ...$params),
                'trim' => Str::trim($subject(), ...$params),
                'ltrim' => Str::ltrim($subject(), ...$params),
                'rtrim' => Str::rtrim($subject(), ...$params),
                'ucfirst' => Str::ucfirst($subject()),
                'upper' => Str::upper($subject()),
                'ulid' => (string) Str::ulid(),
                'unwrap' => Str::of($subject())->unwrap(...$params),
                'uuid' => (string) Str::uuid(),
                'uuid7' => (string) Str::uuid7(),
                'word_count' => Str::wordCount($subject(), ...$params),
                'word_wrap' => Str::wordWrap($subject(), ...$params),
                'words' => Str::words($subject(), ...$params),
                'wrap' => Str::of($subject())->wrap(...$params),
                default => throw new UnsupportedStringFunctionException($definition->function)
            };
        } catch (NoneException) {
            $resolvedString = false;
        }

        return $resolvedString;
    }

    protected function useCustomFunctions(FunctionDefinition $definition, None|string $string): false|string
    {
        $function = Config::array('weave.string_functions', [])[$definition->function] ?? null;

        if ($function === null) {
            return false;
        }

        if (! is_a($function, StringFunction::class, true)) {
            return false;
        }

        return $function::handle($definition, $string);
    }
}

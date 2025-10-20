<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\Exceptions\NoneToStringConversionException;
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

            $first = (fn (): string => $definition->firstParameterOrFail());
            $params = $definition->parameters;

            $resolvedString = match ($definition->function) {
                'after' => Str::of($string)->after($first()),
                'after_last' => Str::of($string)->afterLast($first()),
                'apa', => Str::apa($string),
                'append' => Str::of($string)->append(...$params),
                'ascii' => Str::ascii($string, ...$params),
                'basename' => basename($string, ...$params),
                'before' => Str::of($string)->before($first()),
                'before_last' => Str::of($string)->beforeLast($first()),
                'between' => Str::of($string)->between(...$params),
                'between_first' => Str::of($string)->betweenFirst(...$params),
                'camel' => Str::camel($string),
                'char_at' => (string) Str::of($string)->charAt($first()),
                'chop_start' => Str::of($string)->chopStart($first()),
                'chop_end' => Str::of($string)->chopEnd($first()),
                'class_basename' => class_basename($string),
                'decrypt' => Str::of($string)->decrypt($definition->firstParameterOrFail('1')),
                'deduplicate' => Str::deduplicate($string, ...$params),
                'dirname' => dirname($string, ...$params),
                'e' => e($string, ...$params),
                'encrypt' => encrypt($string, ...$params),
                'finish' => Str::of($string)->finish($first()),
                'from_base64' => (string) Str::fromBase64($string, ...$params),
                'hash' => Str::of($string)->hash($first()),
                'headline' => Str::headline($string),
                'inline_markdown' => Str::inlineMarkdown($string),
                'kebab' => Str::kebab($string),
                'lcfirst' => Str::lcfirst($string),
                'length' => (string) Str::length($string, ...$params),
                'limit' => Str::limit($string, ...$params),
                'lower' => Str::lower($string),
                'markdown' => Str::markdown($string),
                'mask' => Str::of($string)->mask(...$params),
                'match' => Str::of($string)->match($first()),
                'newline' => Str::of($string)->newLine($definition->firstParameter(1)),
                'ordered_uuid' => (string) Str::orderedUuid(),
                'pad_both' => Str::of($string)->padBoth(...$params),
                'pad_left' => Str::of($string)->padLeft(...$params),
                'pad_right' => Str::of($string)->padRight(...$params),
                'pipe' => Str::of($string)->pipe($first()),
                'password' => Str::password(...$params),
                'plural' => Str::plural($string, ...$params),
                'plural_studly' => Str::pluralStudly($string, ...$params),
                'position' => (string) Str::position($string, ...$params),
                'prepend' => Str::of($string)->prepend(...$params),
                'random' => Str::random(...$params),
                'remove' => Str::of($string)->remove(...$params),
                'repeat' => Str::of($string)->repeat($first()),
                'replace' => Str::of($string)->replace(...$params),
                'replace_first' => Str::of($string)->replaceFirst(...$params),
                'replace_last' => Str::of($string)->replaceLast(...$params),
                'replace_matches' => Str::of($string)->replaceMatches(...$params),
                'replace_start' => Str::of($string)->replaceStart(...$params),
                'replace_end' => Str::of($string)->replaceEnd(...$params),
                'reverse' => Str::reverse($string),
                'singular' => Str::singular($string),
                'slug' => Str::slug($string, ...$params),
                'snake' => Str::snake($string, ...$params),
                'squish' => Str::squish($string),
                'start' => Str::of($string)->start($first()),
                'strip_tags' => strip_tags($string, ...$params),
                'studly' => Str::studly($string),
                'substr' => Str::of($string)->substr(...$params),
                'substr_count' => (string) Str::of($string)->substrCount(...$params),
                'substr_replace' => Str::of($string)->substrReplace(...$params),
                'take' => Str::of($string)->take($first()),
                'title' => Str::title($string),
                'to_base64' => base64_encode($string),
                'transliterate' => Str::transliterate($string, ...$params),
                'trim' => Str::trim($string, ...$params),
                'ltrim' => Str::ltrim($string, ...$params),
                'rtrim' => Str::rtrim($string, ...$params),
                'ucfirst' => Str::ucfirst($string),
                'upper' => Str::upper($string),
                'ulid' => (string) Str::ulid(),
                'unwrap' => Str::of($string)->unwrap(...$params),
                'uuid' => (string) Str::uuid(),
                'uuid7' => (string) Str::uuid7(),
                'word_count' => Str::wordCount($string, ...$params),
                'word_wrap' => Str::wordWrap($string, ...$params),
                'words' => Str::words($string, ...$params),
                'wrap' => Str::of($string)->wrap(...$params),
                default => throw new UnsupportedStringFunctionException($definition->function)
            };
        } catch (NoneToStringConversionException) {
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

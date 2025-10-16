<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PrinceJohn\Weave\Contracts\StringManipulator;
use PrinceJohn\Weave\Exceptions\UnsupportedStringFunctionException;

use function Safe\base64_decode;

class StringResolver implements Contracts\StringResolver
{
    public function handle(TokenParser $parser, ?string $string = null): ?string
    {
        foreach ($parser->getFunctionDefinitionList() as $definition) {
            $string = $this->manipulateString($definition, $string);
        }

        return $string;
    }

    protected function manipulateString(FunctionDefinition $definition, ?string $string): string
    {
        $resolvedString = $this->useCustomManipulators($definition, $string);

        if ($resolvedString !== false) {
            return $resolvedString;
        }

        $params = $definition->parameters;
        $first = $definition->firstParameter();
        $stringAndParams = array_merge([$string], $params);

        return match ($definition->function) {
            'after' => Str::of($string)->after($first),
            'after_last' => Str::of($string)->afterLast($first),
            'apa', => Str::apa($string),
            'append' => Str::of($string)->append(...$params),
            'ascii' => Str::ascii(...$stringAndParams),
            'basename' => basename(...$stringAndParams),
            'before' => Str::of($string)->before($first),
            'before_last' => Str::of($string)->beforeLast($first),
            'between' => Str::of($string)->between(...$definition->getParameters([0, 1])),
            'between_first' => Str::of($string)->betweenFirst(...$definition->getParameters([0, 1])),
            'camel' => Str::camel($string),
            'char_at' => Str::of($string)->charAt($first),
            'chop_start' => Str::of($string)->chopStart($first),
            'chop_end' => Str::of($string)->chopEnd($first),
            'class_basename' => class_basename($string),
            'decrypt' => decrypt(...$stringAndParams),
            'deduplicate' => Str::deduplicate(...$stringAndParams),
            'dirname' => dirname(...$stringAndParams),
            'e' => e(...$stringAndParams),
            'encrypt' => encrypt(...$stringAndParams),
            'finish' => Str::of($string)->finish($first),
            'from_base64' => base64_decode(...$stringAndParams),
            'hash' => Str::of($string)->hash($first),
            'headline' => Str::headline($string),
            'inline_markdown' => Str::inlineMarkdown($string),
            'kebab' => Str::kebab($string),
            'lcfirst' => Str::lcfirst($string),
            'length' => Str::length(...$stringAndParams),
            'limit' => Str::limit(...$stringAndParams),
            'lower' => Str::lower($string),
            'markdown' => Str::markdown($string),
            'mask' => Str::of($string)->mask(...$params),
            'match' => Str::of($string)->match($first),
            'newline' => Str::of($string)->newLine($definition->firstParameter(1)),
            'ordered_uuid' => (string) Str::orderedUuid(),
            'pad_both' => Str::of($string)->padBoth(...$params),
            'pad_left' => Str::of($string)->padLeft(...$params),
            'pad_right' => Str::of($string)->padRight(...$params),
            'pipe' => Str::of($string)->pipe($first),
            'password' => Str::password(...$params),
            'plural' => Str::plural(...$stringAndParams),
            'plural_studly' => Str::pluralStudly(...$stringAndParams),
            'position' => (string) Str::position(...$stringAndParams),
            'prepend' => Str::of($string)->prepend(...$params),
            'random' => Str::random(...$params),
            'remove' => Str::of($string)->remove(...$params),
            'repeat' => Str::of($string)->repeat($first),
            'replace' => Str::of($string)->replace(...$params),
            'replace_first' => Str::of($string)->replaceFirst(...$params),
            'replace_last' => Str::of($string)->replaceLast(...$params),
            'replace_matches' => Str::of($string)->replaceMatches(...$params),
            'replace_start' => Str::of($string)->replaceStart(...$params),
            'replace_end' => Str::of($string)->replaceEnd(...$params),
            'reverse' => Str::reverse($string),
            'singular' => Str::singular($string),
            'slug' => Str::slug(...$stringAndParams),
            'snake' => Str::snake(...$stringAndParams),
            'squish' => Str::squish($string),
            'start' => Str::of($string)->start($first),
            'strip_tags' => strip_tags(...$stringAndParams),
            'studly' => Str::studly($string),
            'substr' => Str::of($string)->substr(...$params),
            'substr_count' => Str::of($string)->substrCount(...$params),
            'substr_replace' => Str::of($string)->substrReplace(...$params),
            'take' => Str::of($string)->take($first),
            'title' => Str::title($string),
            'to_base64' => base64_encode($string),
            'transliterate' => Str::transliterate(...$stringAndParams),
            'trim' => Str::trim(...$stringAndParams),
            'ltrim' => Str::ltrim(...$stringAndParams),
            'rtrim' => Str::rtrim(...$stringAndParams),
            'ucfirst' => Str::ucfirst($string),
            'upper' => Str::upper($string),
            'ulid' => (string) Str::ulid(),
            'unwrap' => Str::of($string)->unwrap(...$params),
            'uuid' => (string) Str::uuid(),
            'uuid7' => (string) Str::uuid7(),
            'word_count' => Str::wordCount(...$stringAndParams),
            'word_wrap' => Str::wordWrap(...$stringAndParams),
            'words' => Str::words(...$stringAndParams),
            'wrap' => Str::of($string)->wrap(...$params),
            default => throw new UnsupportedStringFunctionException($definition->function),
        };
    }

    protected function useCustomManipulators(FunctionDefinition $definition, ?string $string): false|string
    {
        $manipulator = Config::array('weave.string_manipulators', [])[$definition->function] ?? null;

        if ($manipulator === null) {
            return false;
        }

        if (! is_a($manipulator, StringManipulator::class, true)) {
            return false;
        }

        return $manipulator::handle($definition, $string);
    }
}

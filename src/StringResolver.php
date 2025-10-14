<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PrinceJohn\Weave\Contracts\StringManipulator;
use PrinceJohn\Weave\Exceptions\UnsupportedStringFunctionException;

class StringResolver implements Contracts\StringResolver
{
    public function handle(TokenParser $parser, ?string $string = null): ?string
    {
        foreach ($parser->getFunctions() as $blueprint) {
            $string = $this->manipulateString($blueprint, $string);
        }

        return $string;
    }

    protected function manipulateString(FunctionBlueprint $blueprint, ?string $string): string
    {
        $resolvedString = $this->useCustomManipulators($blueprint, $string);

        if ($resolvedString !== false) {
            return $resolvedString;
        }

        $stringAndParameters = array_merge([$string], $blueprint->parameters);
        $parametersAndString = array_merge($blueprint->parameters, [$string]);

        return match ($blueprint->function) {
            'after' => Str::after(...$stringAndParameters),
            'after_last' => Str::afterLast(...$stringAndParameters),
            'apa', => Str::apa($string),
            'append' => Str::of($string)->append(...$blueprint->parameters)->toString(),
            'ascii' => Str::ascii(...$stringAndParameters),
            'basename' => Str::of($string)->basename(...$blueprint->parameters)->toString(),
            'before' => Str::before(...$stringAndParameters),
            'before_last' => Str::beforeLast(...$stringAndParameters),
            'between' => Str::between(...$stringAndParameters),
            'between_first' => Str::betweenFirst(...$stringAndParameters),
            'camel' => Str::camel($string),
            'char_at' => (string) Str::charAt(...$stringAndParameters),
            'chop_start' => Str::chopStart(...$stringAndParameters),
            'chop_end' => Str::chopEnd(...$stringAndParameters),
            'class_basename' => Str::of($string)->classBasename()->toString(),
            'decrypt' => Str::of($string)->decrypt(...$blueprint->parameters)->toString(),
            'deduplicate' => Str::deduplicate(...$stringAndParameters),
            'dirname' => Str::of($string)->dirname(...$blueprint->parameters)->toString(),
            'e' => e(...$stringAndParameters),
            'encrypt' => Str::of($string)->encrypt(...$blueprint->parameters)->toString(),
            'finish' => Str::finish(...$stringAndParameters),
            'fromBase64' => (string) Str::fromBase64(...$stringAndParameters),
            'hash' => Str::of($string)->hash(...$blueprint->parameters)->toString(),
            'headline' => Str::headline($string),
            'inlineMarkdown' => Str::inlineMarkdown($string),
            'kebab' => Str::kebab($string),
            'lcfirst' => Str::lcfirst($string),
            'length' => Str::length(...$stringAndParameters),
            'limit' => Str::limit(...$stringAndParameters),
            'lower' => Str::lower($string),
            'markdown' => Str::markdown($string),
            'mask' => Str::mask(...$stringAndParameters),
            'match' => Str::match(...$stringAndParameters),
            'newline' => Str::of($string)->newLine(...$blueprint->parameters)->toString(),
            'orderedUuid' => (string) Str::orderedUuid(),
            'padBoth' => Str::padBoth(...$stringAndParameters),
            'padLeft' => Str::padLeft(...$stringAndParameters),
            'padRight' => Str::padRight(...$stringAndParameters),
            'pipe' => Str::of($string)->pipe(...$blueprint->parameters)->toString(),
            'password' => Str::password(...$blueprint->parameters),
            'plural' => Str::plural(...$stringAndParameters),
            'pluralStudly' => Str::pluralStudly(...$stringAndParameters),
            'position' => (string) Str::position(...$stringAndParameters),
            'prepend' => Str::of($string)->prepend(...$blueprint->parameters)->toString(),
            'random' => Str::random(...$blueprint->parameters),
            'remove' => Str::of($string)->remove(...$blueprint->parameters)->toString(),
            'repeat' => Str::repeat(...$stringAndParameters),
            'replace' => Str::of($string)->replace(...$blueprint->parameters)->toString(),
            'replaceFirst' => Str::replaceFirst(...$parametersAndString),
            'replaceLast' => Str::replaceLast(...$parametersAndString),
            'replaceMatches' => Str::of($string)->replaceMatches(...$blueprint->parameters)->toString(),
            'replaceStart' => Str::replaceStart(...$parametersAndString),
            'replaceEnd' => Str::replaceEnd(...$parametersAndString),
            'reverse' => Str::reverse($string),
            'singular' => Str::singular($string),
            'slug' => Str::slug(...$stringAndParameters),
            'snake' => Str::snake(...$stringAndParameters),
            'squish' => Str::squish($string),
            'start' => Str::start(...$stringAndParameters),
            'stripTags' => Str::of($string)->stripTags(...$blueprint->parameters)->toString(),
            'studly' => Str::studly($string),
            'substr' => Str::substr(...$stringAndParameters),
            'substrCount' => Str::substrCount(...$stringAndParameters),
            'substrReplace' => Str::of($string)->substrReplace(...$blueprint->parameters)->toString(),
            'take' => Str::take(...$stringAndParameters),
            'title' => Str::title($string),
            'toBase64' => Str::toBase64($string),
            'transliterate' => Str::transliterate(...$stringAndParameters),
            'trim' => Str::trim(...$stringAndParameters),
            'ltrim' => Str::ltrim(...$stringAndParameters),
            'rtrim' => Str::rtrim(...$stringAndParameters),
            'ucfirst' => Str::ucfirst($string),
            'upper' => Str::upper($string),
            'ulid' => (string) Str::ulid(),
            'unwrap' => Str::unwrap(...$stringAndParameters),
            'uuid' => (string) Str::uuid(),
            'uuid7' => (string) Str::uuid7(),
            'wordCount' => Str::wordCount(...$stringAndParameters),
            'wordWrap' => Str::wordWrap(...$stringAndParameters),
            'words' => Str::words(...$stringAndParameters),
            'wrap' => Str::wrap(...$stringAndParameters),
            default => throw new UnsupportedStringFunctionException($blueprint->function),
        };
    }

    protected function useCustomManipulators(FunctionBlueprint $blueprint, ?string $string): false|string
    {

        $manipulator = Config::array('weave.string_manipulators', [])[$blueprint->function] ?? null;

        if ($manipulator === null) {
            return false;
        }

        if (! is_a($manipulator, StringManipulator::class, true)) {
            return false;
        }

        return $manipulator::handle($blueprint, $string);
    }
}

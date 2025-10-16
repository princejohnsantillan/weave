![Weave](https://github.com/user-attachments/assets/6a7d7f71-3921-48b3-bf25-afb03e0fa430)


# Weave
An elegant and easy way to format strings and stubs.

## Installation
```php
composer require princejohnsantillan/weave
```

## Usage
```php
/**
 *  Swap tokens with values from an array list.
 *  Index positioning should be observed here. 
 */
weave('Hi {{name}}! Your role is: {{role}}', ['Prince', 'magician']); // Hi Prince! Your role is: magician 

/**
 *  Swap tokens with values from an associative array.
 *  Array keys here should correspond to the token names. 
 */
weave('Hi {{name}}! Your role is: {{role}}', [
    'name' => 'John', 
    'role' => 'developer'
]); // Hi John! Your role is: developer

/**
 * Generate strings like the datetime now. 
 */
weave("Today is {{:now,Y-m-d}}!"); // Today is 2025-10-16!

/**
 * Compound string transformations.
 */
weave("{{title:kebab|upper}}", ["this is a breaking news"]); // THIS-IS-A-BREAKING-NEWS

/**
 * Provide string transformations with a parameter.
 */
weave("{{controller:append,Controller|studly}}", ["controller" => "user"]); // UserController
```

## Custom Functions
You can also register your own custom functions. All you need to do is create a class that implements
the `\PrinceJohn\Weave\Contracts\StringFunction` interface and register it on the config.

1. Create the `String Function`.
```php
use Illuminate\Support\Str;
use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\Exceptions\NoneException;

use function PrinceJohn\Weave\is_none;

class EmojifyString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, None|string $string): string
    {
        $emojis = [':cool:' => '😎', ':fire' => '🔥'];
        
        throw_if(is_none($string), NoneException::class);
        
        return Str::swap($emojis, $string)
    }
}
```

2. Register it on the weave config file.
```php

return [
    'string_functions' => [
        'now' => \PrinceJohn\Weave\Functions\NowString::class,
        'config' => \PrinceJohn\Weave\Functions\ConfigString::class,
        'emojify' => EmojifyString::class
    ],
]
```

3. Now use it!
```php
weave("This is {{:emojify}} and {{:emojify}}!", [":fire:",":cool:"]); // This is 🔥and 😎!
```


## Available Functions

All of these functions are based off of Laravel's string helpers, [see here](https://laravel.com/docs/12.x/strings).

- [after](https://laravel.com/docs/12.x/strings#method-fluent-str-after)
- [after_last](https://laravel.com/docs/12.x/strings#method-fluent-str-after-last)
- [apa](https://laravel.com/docs/12.x/strings#method-fluent-str-apa)
- [append](https://laravel.com/docs/12.x/strings#method-fluent-str-append)
- [ascii](https://laravel.com/docs/12.x/strings#method-fluent-str-ascii)
- [basename](https://laravel.com/docs/12.x/strings#method-fluent-str-basename)
- [before](https://laravel.com/docs/12.x/strings#method-fluent-str-before)
- [before_last](https://laravel.com/docs/12.x/strings#method-fluent-str-before-last)
- [between](https://laravel.com/docs/12.x/strings#method-fluent-str-between)
- [between_first](https://laravel.com/docs/12.x/strings#method-fluent-str-between-first)
- [camel](https://laravel.com/docs/12.x/strings#method-fluent-str-camel)
- [char_at](https://laravel.com/docs/12.x/strings#method-fluent-str-char-at)
- [chop_start](https://laravel.com/docs/12.x/strings#method-fluent-str-chop-start)
- [chop_end](https://laravel.com/docs/12.x/strings#method-fluent-str-chop-end)
- [class_basename](https://laravel.com/docs/12.x/strings#method-fluent-str-class-basename)
- [decrypt](https://laravel.com/docs/12.x/strings#method-fluent-str-decrypt)
- [deduplicate](https://laravel.com/docs/12.x/strings#method-fluent-str-deduplicate)
- [dirname](https://laravel.com/docs/12.x/strings#method-fluent-str-dirname)
- [e](https://laravel.com/docs/12.x/strings#method-e)
- [encrypt](https://laravel.com/docs/12.x/strings#method-fluent-str-encrypt)
- [finish](https://laravel.com/docs/12.x/strings#method-fluent-str-finish)
- [from_base64](https://laravel.com/docs/12.x/strings#method-fluent-str-from-base64)
- [hash](https://laravel.com/docs/12.x/strings#method-fluent-str-hash)
- [headline](https://laravel.com/docs/12.x/strings#method-fluent-str-headline)
- [inline_markdown](https://laravel.com/docs/12.x/strings#method-fluent-str-inline-markdown)
- [kebab](https://laravel.com/docs/12.x/strings#method-fluent-str-kebab)
- [lcfirst](https://laravel.com/docs/12.x/strings#method-fluent-str-lcfirst)
- [length](https://laravel.com/docs/12.x/strings#method-fluent-str-length)
- [limit](https://laravel.com/docs/12.x/strings#method-fluent-str-limit)
- [lower](https://laravel.com/docs/12.x/strings#method-fluent-str-lower)
- [markdown](https://laravel.com/docs/12.x/strings#method-fluent-str-markdown)
- [mask](https://laravel.com/docs/12.x/strings#method-fluent-str-mask)
- [match](https://laravel.com/docs/12.x/strings#method-fluent-str-match)
- [newline](https://laravel.com/docs/12.x/strings#method-fluent-str-new-line)
- [ordered_uuid](https://laravel.com/docs/12.x/strings#method-str-ordered-uuid)
- [pad_both](https://laravel.com/docs/12.x/strings#method-fluent-str-padboth)
- [pad_left](https://laravel.com/docs/12.x/strings#method-fluent-str-padleft)
- [pad_right](https://laravel.com/docs/12.x/strings#method-fluent-str-padright)
- [pipe](https://laravel.com/docs/12.x/strings#method-fluent-str-pipe)
- [password](https://laravel.com/docs/12.x/strings#method-str-password)
- [plural](https://laravel.com/docs/12.x/strings#method-fluent-str-plural)
- [plural_studly](https://laravel.com/docs/12.x/strings#method-str-plural-studly)
- [position](https://laravel.com/docs/12.x/strings#method-fluent-str-position)
- [prepend](https://laravel.com/docs/12.x/strings#method-fluent-str-prepend)
- [random](https://laravel.com/docs/12.x/strings#method-str-random)
- [remove](https://laravel.com/docs/12.x/strings#method-fluent-str-remove)
- [repeat](https://laravel.com/docs/12.x/strings#method-fluent-str-repeat)
- [replace](https://laravel.com/docs/12.x/strings#method-fluent-str-replace)
- [replace_first](https://laravel.com/docs/12.x/strings#method-fluent-str-replace-first)
- [replace_last](https://laravel.com/docs/12.x/strings#method-fluent-str-replace-last)
- [replace_matches](https://laravel.com/docs/12.x/strings#method-fluent-str-replace-matches)
- [replace_start](https://laravel.com/docs/12.x/strings#method-fluent-str-replace-start)
- [replace_end](https://laravel.com/docs/12.x/strings#method-fluent-str-replace-end)
- [reverse](https://laravel.com/docs/12.x/strings#method-str-reverse)
- [singular](https://laravel.com/docs/12.x/strings#method-fluent-str-singular)
- [slug](https://laravel.com/docs/12.x/strings#method-fluent-str-slug)
- [snake](https://laravel.com/docs/12.x/strings#method-fluent-str-snake)
- [squish](https://laravel.com/docs/12.x/strings#method-fluent-str-squish)
- [start](https://laravel.com/docs/12.x/strings#method-fluent-str-start)
- [strip_tags](https://laravel.com/docs/12.x/strings#method-fluent-str-strip-tags)
- [studly](https://laravel.com/docs/12.x/strings#method-fluent-str-studly)
- [substr](https://laravel.com/docs/12.x/strings#method-fluent-str-substr)
- [substr_count](https://laravel.com/docs/12.x/strings#method-str-substrcount)
- [substr_replace](https://laravel.com/docs/12.x/strings#method-fluent-str-substrreplace)
- [take](https://laravel.com/docs/12.x/strings#method-fluent-str-take)
- [title](https://laravel.com/docs/12.x/strings#method-fluent-str-title)
- [to_base64](https://laravel.com/docs/12.x/strings#method-fluent-str-to-base64)
- [transliterate](https://laravel.com/docs/12.x/strings#method-fluent-str-transliterate)
- [trim](https://laravel.com/docs/12.x/strings#method-fluent-str-trim)
- [ltrim](https://laravel.com/docs/12.x/strings#method-fluent-str-ltrim)
- [rtrim](https://laravel.com/docs/12.x/strings#method-fluent-str-rtrim)
- [ucfirst](https://laravel.com/docs/12.x/strings#method-fluent-str-ucfirst)
- [upper](https://laravel.com/docs/12.x/strings#method-fluent-str-upper)
- [ulid](https://laravel.com/docs/12.x/strings#method-str-ulid)
- [unwrap](https://laravel.com/docs/12.x/strings#method-fluent-str-unwrap)
- [uuid](https://laravel.com/docs/12.x/strings#method-str-uuid)
- [uuid7](https://laravel.com/docs/12.x/strings#method-str-uuid7)
- [word_count](https://laravel.com/docs/12.x/strings#method-fluent-str-word-count)
- [word_wrap](https://laravel.com/docs/12.x/strings#method-str-word-wrap)
- [words](https://laravel.com/docs/12.x/strings#method-fluent-str-words)
- [wrap](https://laravel.com/docs/12.x/strings#method-fluent-str-wrap)
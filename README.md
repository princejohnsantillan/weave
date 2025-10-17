![Weave](https://banners.beyondco.de/Weave.png?theme=light&packageManager=composer+require&packageName=princejohnsantillan%2Fweave&pattern=bamboo&style=style_2&description=An+elegant+and+easy+way+to+format+strings+and+stubs.&md=1&showWatermark=0&fontSize=125px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg&widths=250&heights=250)

## Requirements
|PHP|8.2|8.3|8.4|
|---|---|---|---|

|Laravel|11.x| 12.x|
|-------|----|-----|


## Installation

1. Require the package.
```php
composer require princejohnsantillan/weave
```

2. Publish the config.
```php
php artisan vendor:publish --provider="PrinceJohn\Weave\WeaveServiceProvider"
```


## Usage
```php
use function PrinceJohn\Weave\weave;

/**
 *  Swap tokens with values from an array list.
 *  Tokens and values are matched by index position. 
 */
weave('Hi {{name}}! Your role is: {{role}}', ['Prince', 'magician']); // Hi Prince! Your role is: magician 

/**
 *  Swap tokens with values from an associative array.
 *  Tokens and values are matched by token name and array keys. 
 */
weave('Hi {{name}}! Your role is: {{role}}', [
    'name' => 'John', 
    'role' => 'developer'
]); // Hi John! Your role is: developer

/**
 *  Reuse an input value in the same string. 
 */
weave('I am big: {{name|upper}}! I am small: {{name|lower}}.', [
    'name' => 'JoHn',     
]); // I am big: JOHN! I am small: john.

/**
 * Transform a string.
 */
weave('{{text:lower}}', ['CAN YOU HEAR ME?']); // Can you hear me?

/**
 * Compound string transformations.
 */
weave('{{title:kebab|upper}}', ['This is a breaking news']); // THIS-IS-A-BREAKING-NEWS

/**
 * Provide string transformations with a parameter.
 */
weave('{{controller:append,Controller|studly}}', ['controller'=> 'user']); // UserController

/**
 * Generate strings like the datetime now. 
 */
weave('Today is {{:now,Y-m-d}}!'); // Today is 2025-10-16!
```


## Custom Functions
You can also register your own custom functions. All you need to do is create a class that implements
the `\PrinceJohn\Weave\Contracts\StringFunction` interface and register it on the config.

1. Create the `String Function`.
```php
use Illuminate\Support\Str;
use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;

class EmojifyString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, None|string $string): string
    {
        $emojis = [':cool:' => '😎', ':fire' => '🔥'];        
        
        return Str::swap($emojis, $string);
    }
}
```

2. Register it on the weave config file.
```php

return [
    'string_functions' => [        
        'emojify' => EmojifyString::class
    ],
];
```

3. Now use it!
```php
use function PrinceJohn\Weave\weave;

weave('This is {{:emojify}} and {{:emojify}}!', [':fire:',':cool:']); // This is 🔥and 😎!
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

## Additional Functions
Weave has a few additional built-in functions apart from the functions provided by Laravel.

#### config
`config` allows you to pull in a string from your Laravel configs. 
The key may be passed in as a variable or as a paramater. 
```php
weave('{{:config,app.name}}'); // Weave
weave('{{:config}}', ['app.name']); // Weave
```

#### default
`default` allows you to provide a default value when the input variable does not provide it.
You can also omit the parameter to remove the token when the input is missing.
```php
weave('Hi {{name|default}}!'); // Hi !
weave('Hi {{name|default,John}}!', ['title' => 'This is not the name']); // Hi John!
```

#### now
`now` generates the current datetime. This uses Laravel's `now()` method.
You can optionally pass in a parameter to define the format.
```php
weave('{{:now}}'); // 2025-10-17 12:45:57
weave('{{:now,H:i:s}}'); // 12:45:57 
```

#### of
`of` generates a string based of given parameter. 
It generates an empty string  if no parameter is provider.
```php
weave('{{:of}}',["passthrough"]); // passthrough 
weave('{{:of}}'); // ""
weave('{{:of,Hey|upper}}'); // HEY 
```

#### required
By default, when the token cannot be matched or interpolated the token is left as is.
`required` allows you to change this behavior and make it throw an exception instead.
```php
weave('Hi {{name|required}}!'); ‼️ RequiredStringException
weave('Hi {{name|required}}!', ['age' => '1']); ‼️ RequiredStringException
```



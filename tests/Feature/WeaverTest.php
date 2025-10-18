<?php

use PrinceJohn\Weave\Weaver;

use function PrinceJohn\Weave\weave;

it('swaps using a variadic input', function () {
    $string = weave('{{ name }} {{role}}', 'Prince', 'Wizard');

    expect($string)->toBe('Prince Wizard');
});

it('swaps using a list', function () {
    $string = weave('{{ name }}', ['Prince']);

    expect($string)->toBe('Prince');
});

it('swaps using an associative array', function () {
    $string = weave('{{ email }}', ['email' => 'prince@weave.repo']);

    expect($string)->toBe('prince@weave.repo');
});

it('swaps using variadic associative arrays', function () {
    $string = weave('{{ name }}: {{role}}', ['name' => 'John', 'role' => 'staff'], ['role' => 'admin']);

    expect($string)->toBe('John: admin');
});

it('leaves tokens that cannot be matched by a list', function () {
    $string = weave('{{ name }} {{ email }}', ['Prince']);

    expect($string)->toBe('Prince {{ email }}');
});

it('leaves tokens that cannot be matched by an associative array', function () {
    $string = weave('{{ name:ucfirst|prepend,Mr., }} {{ email }}', ['email' => 'prince@weave.repo']);

    expect($string)->toBe('{{ name:ucfirst|prepend,Mr., }} prince@weave.repo');
});

it('can transform a token', function () {
    $string = weave('{{ name:upper }}', ['name' => 'prince john']);

    expect($string)->toBe('PRINCE JOHN');
});

it('can compound multiple transformations on a token', function () {
    $string = weave('{{ name:slug|upper }}', ['prince john']);

    expect($string)->toBe('PRINCE-JOHN');
});

it('tokens can use the same variable', function () {
    $string = weave('{{ name:upper }} {{ name:slug }}', ['name' => 'prince john']);

    expect($string)->toBe('PRINCE JOHN prince-john');
});

it('can count the tokens', function () {
    $weaver = new Weaver('{{token1}} {{token2}} {{token3}}');

    expect($weaver->getTokenCount())->toBe(3);
});

it('can get the tokens', function () {
    $weaver = new Weaver('{{token1}} {{token2:func}} {{token3:func,param|func}}');

    expect($weaver->getTokens())->toBe(['token1', 'token2:func', 'token3:func,param|func']);
});

it('can get the placeholders', function () {
    $weaver = new Weaver('{{token1}} {{token2:func}} {{token3:func,param|func}}');

    expect($weaver->getPlaceholders())->toBe(['{{token1}}', '{{token2:func}}', '{{token3:func,param|func}}']);
});

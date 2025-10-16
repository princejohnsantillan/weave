<?php

use function PrinceJohn\Weave\weave;

it('swaps using a list', function () {
    $string = weave('{{ name }}', ['Prince']);

    expect($string)->toBe('Prince');
});

it('swaps using an associative array', function () {
    $string = weave('{{ email }}', ['email' => 'prince@weave.repo']);

    expect($string)->toBe('prince@weave.repo');
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

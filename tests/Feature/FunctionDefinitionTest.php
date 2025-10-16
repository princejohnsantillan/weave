<?php

use PrinceJohn\Weave\Exceptions\ParameterDoesNotExistException;
use PrinceJohn\Weave\FunctionDefinition;

it('can get the function name', function () {
    $definition = new FunctionDefinition('myfunc', []);

    expect($definition->function)->toBe('myfunc');
});

it('can get the function parameters', function () {
    $definition = new FunctionDefinition('myfunc', ['param1', 'param2']);

    expect($definition->parameters)->toBe(['param1', 'param2']);
});

it('can check if it has parameters', function () {
    $definition = new FunctionDefinition('myfunc-true', ['param1', 'param2']);

    expect($definition->hasParameters())->toBeTrue();

    $definition = new FunctionDefinition('myfunc-false', []);

    expect($definition->hasParameters())->toBeFalse();
});

it('can get a parameter given an index', function () {
    $definition = new FunctionDefinition('myfunc:index', ['param1', 'param2', 'param3']);

    expect($definition->getParameter(0))->toBe('param1');
    expect($definition->getParameter(1))->toBe('param2');
    expect($definition->getParameter(2))->toBe('param3');
    expect($definition->getParameter(3))->toBeNull();
});

it('can use a default if the parameter index does not exist', function () {
    $definition = new FunctionDefinition('myfunc:index', []);

    expect($definition->getParameter(0, 'magic'))->toBe('magic');
    expect($definition->getParameter(1, 'amazing'))->toBe('amazing');
});

it('can get the first parameter', function () {
    $definition = new FunctionDefinition('first-func', ['1']);

    expect($definition->firstParameter())->toBe('1');

    $definition = new FunctionDefinition('first-func', []);

    expect($definition->firstParameter('one'))->toBe('one');
});

it('can fail if the parameter is does not exists', function () {
    $definition = new FunctionDefinition('myfunc:index', ['param']);

    expect($definition->getParameterOrFail(0))->toBe('param');
    expect($definition->getParameterOrFail(1, 'default'))->toBe('default');

    $definition->getParameterOrFail(2);
})->throws(exception: ParameterDoesNotExistException::class, exceptionCode: ParameterDoesNotExistException::ON_INDEX);

it('can fail if the first parameter is does not exists', function () {
    $definition = new FunctionDefinition('myfunc:index', ['first']);

    expect($definition->firstParameterOrFail())->toBe('first');

    $definition = new FunctionDefinition('myfunc:index', []);

    expect($definition->firstParameterOrFail('myfirst'))->toBe('myfirst');
    $definition->firstParameterOrFail();
})->throws(exception: ParameterDoesNotExistException::class, exceptionCode: ParameterDoesNotExistException::ON_INDEX);

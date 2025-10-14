<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use PrinceJohn\Weave\WeaveServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            WeaveServiceProvider::class,
        ];
    }
}

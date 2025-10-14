<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\ServiceProvider;

class WeaveServiceProvider extends ServiceProvider
{
    /** @var array<class-string,class-string> */
    public $bindings = [
        Contracts\StringResolver::class => StringResolver::class,
    ];

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/weave.php' => config_path('weave.php'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/weave.php', 'weave'
        );
    }
}

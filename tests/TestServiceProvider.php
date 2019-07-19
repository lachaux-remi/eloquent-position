<?php

namespace LachauxRemi\EloquentPosition\Tests;

use Illuminate\Support\ServiceProvider;

/**
 * Class TestServiceProvider
 * @package LachauxRemi\EloquentPosition\Tests
 */
class TestServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/database/migrations'
        );
    }
}

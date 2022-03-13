<?php

namespace EloquentPosition\Test;

use Illuminate\Support\ServiceProvider;

/**
 * Class TestServiceProvider
 */
class TestServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(
            __DIR__ . "/database/migrations"
        );
    }
}
<?php

namespace EloquentPosition;

use EloquentPosition\Commands\RecalculatePositionCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ( $this->app->runningInConsole() ) {
            $this->commands( [
                RecalculatePositionCommand::class,
            ] );
        }
    }
}
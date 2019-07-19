<?php

namespace LachauxRemi\EloquentPosition;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LachauxRemi\EloquentPosition\Commands\RecalculatePositionCommand;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RecalculatePositionCommand::class
            ]);
        }
    }
}

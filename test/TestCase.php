<?php

namespace EloquentPosition\Test;

use EloquentPosition\ServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan( "migrate", [ "--database" => "testbench" ] );

        $this->beforeApplicationDestroyed( function () {
            $this->artisan( "migrate:rollback" );
        } );
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app["config"]->set( "database.default", "testbench" );
        $app["config"]->set( "database.connections.testbench", [
            "driver" => "sqlite",
            "database" => ":memory:",
            "prefix" => "",
        ] );
    }

    /**
     * Get Positionable package providers.
     *
     * @param Application $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            TestServiceProvider::class,
        ];
    }
}
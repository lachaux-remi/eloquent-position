<?php

namespace LachauxRemi\EloquentPosition\Tests;

use Illuminate\Foundation\Application;
use LachauxRemi\EloquentPosition\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase
 * @package LachauxRemi\EloquentPosition\Tests
 */
abstract class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench']);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);
    }

    /**
     * Get Positionable package providers.
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            TestServiceProvider::class
        ];
    }
}

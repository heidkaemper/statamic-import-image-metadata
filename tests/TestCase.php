<?php

namespace Heidkaemper\ImportImageMetadata\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            \Statamic\Providers\StatamicServiceProvider::class,
            \Heidkaemper\ImportImageMetadata\ServiceProvider::class,
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('statamic.users.repository', 'file');
    }
}

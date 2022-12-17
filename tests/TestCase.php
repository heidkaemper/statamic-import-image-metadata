<?php

namespace Heidkaemper\ImportImageMetadata\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            \Heidkaemper\ImportImageMetadata\ServiceProvider::class,
        ];
    }
}

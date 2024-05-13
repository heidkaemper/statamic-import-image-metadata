<?php

namespace Heidkaemper\ImportImageMetadata\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Assets\AssetContainer;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Stache;
use Statamic\Statamic;

class TestCase extends OrchestraTestCase
{
    public string $tmpDirectory = __DIR__ . '/Support/tmp';

    public AssetContainer $assetContainer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assetContainer = (new AssetContainer())
            ->disk('assets')
            ->handle('test')
            ->save();
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->tmpDirectory);
        Stache::clear();

        parent::tearDown();
    }

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

        $app['config']->set('filesystems.disks.assets', [
            'driver' => 'local',
            'root' => "{$this->tmpDirectory}/assets",
            'url' => '/test',
        ]);

        Statamic::booted(function () {
            Blueprint::setDirectory("{$this->tmpDirectory}/resources/blueprints");
        });
    }
}

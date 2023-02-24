<?php

namespace Heidkaemper\ImportImageMetadata;

use Heidkaemper\ImportImageMetadata\Listeners\AssetUploadedListener;
use Statamic\Events\AssetReuploaded;
use Statamic\Events\AssetUploaded;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        AssetUploaded::class => [
            AssetUploadedListener::class,
        ],
        AssetReuploaded::class => [
            AssetReuploaded::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        $this->bootAddonConfig();
    }

    protected function bootAddonConfig(): self
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/import-image-metadata.php', 'statamic.import-image-metadata');

        $this->publishes([
            __DIR__ . '/../config/import-image-metadata.php' => config_path('statamic/import-image-metadata.php'),
        ], 'import-image-metadata-config');

        return $this;
    }
}

<?php

namespace Heidkaemper\ImportImageMetadata;

use Statamic\Events\AssetUploaded;
use Statamic\Events\AssetReuploaded;
use Statamic\Providers\AddonServiceProvider;
use Heidkaemper\ImportImageMetadata\Listeners\AssetUploadedListener;
use Heidkaemper\ImportImageMetadata\Listeners\AssetReuploadedListener;

use Heidkaemper\ImportImageMetadata\Jobs\ImportMetadataJob;

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

    public function boot()
    {
        parent::boot();

        $this->bootAddonConfig();
    }

    protected function bootAddonConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/import-image-metadata.php', 'statamic.import-image-metadata');

        $this->publishes([
            __DIR__ . '/../config/import-image-metadata.php' => config_path('statamic/import-image-metadata.php'),
        ], 'import-image-metadata-config');

        return $this;
    }
}

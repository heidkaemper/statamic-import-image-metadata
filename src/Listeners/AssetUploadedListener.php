<?php

namespace Heidkaemper\ImportImageMetadata\Listeners;

use Statamic\Events\AssetUploaded;
use Heidkaemper\ImportImageMetadata\Jobs\ImportMetadataJob;

class AssetUploadedListener
{
    public function handle(AssetUploaded $event): void
    {
        if (! $event->asset->extensionIsOneOf(['jpg', 'jpeg', 'tiff'])) {
            return;
        }

        ImportMetadataJob::dispatch($event->asset);
    }
}

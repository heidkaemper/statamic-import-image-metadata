<?php

namespace Heidkaemper\ImportImageMetadata\Listeners;

use Heidkaemper\ImportImageMetadata\Jobs\ImportMetadataJob;
use Statamic\Events\AssetUploaded;

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

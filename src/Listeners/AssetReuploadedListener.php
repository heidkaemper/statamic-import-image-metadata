<?php

namespace Heidkaemper\ImportImageMetadata\Listeners;

use Heidkaemper\ImportImageMetadata\Jobs\ImportMetadataJob;
use Statamic\Events\AssetUploaded;

class AssetReuploadedListener
{
    public function handle(AssetUploaded $event): void
    {
        if (! config('statamic.import-image-metadata.reupload')) {
            return;
        }

        if (! $event->asset->extensionIsOneOf(['jpg', 'jpeg', 'tiff'])) {
            return;
        }

        ImportMetadataJob::dispatch($event->asset);
    }
}

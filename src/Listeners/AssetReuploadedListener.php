<?php

namespace Heidkaemper\ImportImageMetadata\Listeners;

use Statamic\Events\AssetUploaded;
use Heidkaemper\ImportImageMetadata\Jobs\ImportMetadataJob;

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

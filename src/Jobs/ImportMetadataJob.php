<?php

namespace Heidkaemper\ImportImageMetadata\Jobs;

use Heidkaemper\ImportImageMetadata\Importer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Assets\Asset;

class ImportMetadataJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public Asset $asset,
    ) {
        $this->queue = config('statamic.import-image-metadata.queue', 'default');
    }

    public function handle(): void
    {
        if (! config('statamic.import-image-metadata.fields')) {
            return;
        }

        new Importer($this->asset);
    }
}

<?php

namespace Heidkaemper\ImportImageMetadata\Jobs;

use Statamic\Assets\Asset;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Heidkaemper\ImportImageMetadata\Importer;

use Illuminate\Support\Facades\Log;

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

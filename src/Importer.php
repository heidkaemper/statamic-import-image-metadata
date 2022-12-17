<?php

namespace Heidkaemper\ImportImageMetadata;

use Statamic\Assets\Asset;
use Illuminate\Support\Arr;
use Heidkaemper\ImportImageMetadata\Helpers\Formatter;

class Importer
{
    public function __construct(
        public Asset $asset,
    ) {
        $this->metadata = [
            'exif' => [],
            'iptc' => [],
        ];

        $this->readExif();
        $this->readIptc();
        $this->mapToAssetField();

        $this->asset->save();
    }

    private function readExif(): void
    {
        $data = exif_read_data($this->asset->resolvedPath());

        if (! is_array($data)) {
            return;
        }

        $this->metadata['exif'] = Formatter::exif($data);
    }

    private function readIptc(): void
    {
        getimagesize($this->asset->resolvedPath(), $fileinfo);

        $data = iptcparse($fileinfo['APP13'] ?? '');

        if (! is_array($data)) {
            return;
        }

        $this->metadata['iptc'] = Formatter::iptc($data);
    }

    private function mapToAssetField(): void
    {
        $blueprint = $this->asset->container->blueprint();

        foreach (config('statamic.import-image-metadata.fields') as $field => $sources) {
            if (! $blueprint->hasField($field)) {
                continue;
            }

            $value = $this->findMetadataBySources($sources);

            $this->asset->set($field, $value);
        }
    }

    private function findMetadataBySources(string $sources): string|null
    {
        foreach (explode(',', $sources) as $source) {
            $source = mb_strtolower(trim($source));

            $value = Arr::get($this->metadata, $source);

            if (! empty($value)) {
                return $value;
            }
        }

        return null;
    }
}

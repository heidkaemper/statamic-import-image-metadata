<?php

namespace Heidkaemper\ImportImageMetadata;

use Statamic\Assets\Asset;
use Illuminate\Support\Arr;
use Heidkaemper\ImportImageMetadata\Helpers\Formatter;

class Importer
{
    protected array $metadata = [
        'exif' => [],
        'iptc' => [],
    ];

    protected bool $hasDirtyData = false;

    public function __construct(
        public Asset $asset,
    ) {
        $this->readExif();
        $this->readIptc();
        $this->mapToAssetField();
        $this->save();
    }

    public function readExif(): void
    {
        $data = exif_read_data($this->asset->resolvedPath());

        if (! is_array($data)) {
            return;
        }

        $this->metadata['exif'] = Formatter::exif($data);
    }

    public function readIptc(): void
    {
        getimagesize($this->asset->resolvedPath(), $fileinfo);

        $data = iptcparse($fileinfo['APP13'] ?? '');

        if (! is_array($data)) {
            return;
        }

        $this->metadata['iptc'] = Formatter::iptc($data);
    }

    public function mapToAssetField(): void
    {
        $blueprint = $this->asset->container->blueprint();

        foreach (config('statamic.import-image-metadata.fields') as $field => $sources) {
            if (! $blueprint->hasField($field)) {
                continue;
            }

            $value = $this->findMetadataBySources($sources);

            if ($value) {
                $this->asset->set($field, $value);

                $this->hasDirtyData = true;
            }
        }
    }

    public function findMetadataBySources(string $sources): string|null
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

    public function save(): void
    {
        if (! $this->hasDirtyData) {
            return;
        }

        $this->asset->saveQuietly();

        $this->hasDirtyData = false;
    }
}

<?php

namespace Heidkaemper\ImportImageMetadata\Helpers;

class Formatter
{
    public const IPTC_TAGS = [
        '2#005' => 'title',
        '2#055' => 'date',
        '2#080' => 'author',
        '2#090' => 'city',
        '2#095' => 'state',
        '2#101' => 'country',
        '2#105' => 'headline',
        '2#110' => 'credit',
        '2#115' => 'source',
        '2#116' => 'copyright',
        '2#120' => 'caption',
    ];

    public static function exif(array $data): array
    {
        $data = array_filter($data, fn ($value) => is_string($value) && ! empty($value));

        return array_change_key_case($data, CASE_LOWER);
    }

    public static function iptc(array $data): array
    {
        $data = array_map(fn ($value) => is_array($value) && isset($value[0]) ? $value[0] : $value, $data);

        $data = array_filter($data, fn ($value) => is_string($value) && ! empty($value));

        foreach (self::IPTC_TAGS as $key => $tag) {
            if (isset($data[$key])) {
                $data[$tag] = $data[$key];
            }
        }

        return array_change_key_case($data, CASE_LOWER);
    }
}

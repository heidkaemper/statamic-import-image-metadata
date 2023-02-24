<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fields
    |--------------------------------------------------------------------------
    |
    | Map your asset fields to metadata tags.
    |
    | The keys are field handles of the asset container blueprint. The values
    | are a comma separated list of EXIF and IPTC tags.
    |
    | Example: 'your_field' => 'iptc.author, exif.artist, iptc.2#110'
    |
    */

    'fields' => [
        'title' => 'exif.imagedescription, iptc.title',
        'copyright' => 'exif.copyright, iptc.copyright',
        'source' => 'iptc.source',
    ],

    /*
    |--------------------------------------------------------------------------
    | Reupload
    |--------------------------------------------------------------------------
    |
    | When an image is re-uploaded, the metadata will be overwritten with
    | those of the new image. This can be disabled by setting
    | reupload to 'false'.
    |
    */

    'reupload' => true,

    /*
    |--------------------------------------------------------------------------
    | Queue
    |--------------------------------------------------------------------------
    |
    | If the import metadata job is being queued, specify the name of the
    | target queue. This falls back to the 'default' queue.
    |
    */

    'queue' => 'default',

];

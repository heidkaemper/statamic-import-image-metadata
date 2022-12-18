<!-- statamic:hide -->

![Banner](./banner.png)

# Import Image Metadata

<!-- /statamic:hide -->

Read EXIF and IPTC metadata when uploading an image to Statamic.

## Installation

Require the addon as a Composer dependency.

```
composer require heidkaemper/statamic-import-image-metadata
```

Add a new field to your Asset Container Blueprint. A text field with the handle `copyright` would be a good start.

Import a JPG or TIFF image that contains metadata. 🎉

## Configuration

The default configuration imports metadata for `title`, `copyright` and `source` if the corresponding fields exist in the blueprint.

To change this, you can publish the configuration.

```
php artisan vendor:publish --tag="import-image-metadata-config"
```

Have a look at the [configuration file](https://github.com/heidkaemper/statamic-import-image-metadata/blob/main/config/import-image-metadata.php) for details.

## Metadata tags

Most common EXIF and IPTC tags should be available. Check these resources:

- [Most common EXIF tags](https://www.vcode.no/web/resource.nsf/ii2lnug/642.htm)
- [Most common IPTC tags](https://www.vcode.no/web/resource.nsf/ii2lnug/643.htm)

A specialty of iptcparse in PHP is that the IPTC tags are addressed via the code and are therefore not very human readable. For example, `2#116` would be the copyright field.

To make the configuration a little easier, this plugin [maps the most important IPTC tags to more readable titles](https://github.com/heidkaemper/statamic-import-image-metadata/blob/main/src/Helpers/Formatter.php#L7). However, the IPTC codes work too.

<!-- statamic:hide -->

---

<a href="https://statamic.com"><img src="https://img.shields.io/badge/Statamic-3.3+-FF269E?style=for-the-badge"></a>
<a href="https://packagist.org/packages/heidkaemper/statamic-import-image-metadata"><img src="https://img.shields.io/packagist/v/heidkaemper/statamic-import-image-metadata?style=for-the-badge"></a>

<!-- /statamic:hide -->

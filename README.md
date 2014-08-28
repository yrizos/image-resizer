Quick example:

```php

$ir = new \ImageResizer\ImageResizer(
    "<source directory>",
    "<target directory>"
);

$ir->resizeToMaxDimension(
    1024, // max dimension,
    85 // quality
);

```

See `bin/image-resizer.php` for more.
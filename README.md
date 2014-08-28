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

See `example/example.php` & `bin/image-resizer.php` for more.
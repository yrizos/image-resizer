Quick example:

```php

$ir = new \ImageResizer\ImageResizer(
    "<source directory>",
    "<target directory>",
    85 // quality,
    ["jpg"] // file extensions
);

$ir->resizeToMaxDimension(
    1024 // max dimension
);

```

See `example/example.php` & `bin/image-resizer.php` for more.
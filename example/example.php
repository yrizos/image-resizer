<?php

require_once "./../vendor/autoload.php";

$ir = new \ImageResizer\ImageResizer("./source", "./target/resize-dimension");
$ir->resizeToMaxDimension(1500, 85);

$ir->setTargetDirectory("./target/resize-height");
$ir->resizeToMaxHeight(500, 85);

$ir->setTargetDirectory("./target/resize-width");
$ir->resizeToMaxWidth(500, 85);

$ir->setTargetDirectory("./target/pad-images");
$ir->pad(1500, 1500, "dddddd", 85);




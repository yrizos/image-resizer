<?php

require_once "./../vendor/autoload.php";

$ir = new \ImageResizer\ImageResizer("./source", "./target/resize-dimension", 80, ["jpg", "png"]);
$ir->resizeToMaxDimension(1500);

$ir->setTargetDirectory("./target/resize-height");
$ir->resizeToMaxHeight(500);

$ir->setTargetDirectory("./target/resize-width");
$ir->resizeToMaxWidth(500);

$ir->setTargetDirectory("./target/pad-images");
$ir->pad(1500, 1500, "dddddd");
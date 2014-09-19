<?php

require_once dirname(__FILE__) . "/../vendor/autoload.php";

$application = new \Symfony\Component\Console\Application();
$application->add(new \ImageResizer\Console\ResizeToDimensionCommand());
$application->add(new \ImageResizer\Console\ResizeToWidthCommand());
$application->add(new \ImageResizer\Console\ResizeToHeightCommand());
$application->add(new \ImageResizer\Console\PadCommand());
$application->run();
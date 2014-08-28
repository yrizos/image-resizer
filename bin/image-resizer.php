<?php

require_once dirname(__FILE__) . "/../vendor/autoload.php";

$application = new \Symfony\Component\Console\Application();
$application->add(new \ImageResizer\Console\Command\ResizeToDimensionCommand());
$application->add(new \ImageResizer\Console\Command\ResizeToWidthCommand());
$application->add(new \ImageResizer\Console\Command\ResizeToHeightCommand());
$application->run();
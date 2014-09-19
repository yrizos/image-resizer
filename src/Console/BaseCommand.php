<?php

namespace ImageResizer\Console;

use ImageResizer\ImageResizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class BaseCommand extends Command
{

    protected function configure()
    {
        $this->addArgument("source", InputArgument::REQUIRED, "The source directory");
        $this->addArgument("target", InputArgument::REQUIRED, "The target directory");

        $this->addOption("quality", "Q", InputOption::VALUE_OPTIONAL, "Image quality (0-100)", 100);
        $this->addOption("extensions", "E", InputOption::VALUE_OPTIONAL, "Comma separated file extensions", "jpg,png");
    }

    protected function getImageResizer(InputInterface $inputInterface)
    {
        return new ImageResizer(
            $inputInterface->getArgument("source"),
            $inputInterface->getArgument("target"),
            $inputInterface->getOption("quality"),
            $inputInterface->getOption("extensions")
        );
    }

} 
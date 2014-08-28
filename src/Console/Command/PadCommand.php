<?php

namespace ImageResizer\Console\Command;

use ImageResizer\ImageResizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PadCommand extends Command
{

    protected function configure()
    {
        $this->setName("pad")
            ->addArgument("source", InputArgument::REQUIRED, "The source directory")
            ->addArgument("target", InputArgument::REQUIRED, "The target directory")
            ->addArgument("width", InputArgument::REQUIRED)
            ->addArgument("height", InputArgument::REQUIRED)
            ->addArgument("background color", InputArgument::OPTIONAL, "The background color in hex")
            ->addArgument("quality", InputArgument::OPTIONAL, "Image quality (0-100)");
    }

    protected function execute(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $ir = new ImageResizer($inputInterface->getArgument("source"), $inputInterface->getArgument("target"));
        $ir->pad(
            $inputInterface->getArgument("width"),
            $inputInterface->getArgument("height"),
            $inputInterface->getArgument("background color"),
            $inputInterface->getArgument("quality")
        );
    }

} 
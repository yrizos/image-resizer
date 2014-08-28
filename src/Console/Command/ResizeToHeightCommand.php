<?php

namespace ImageResizer\Console\Command;

use ImageResizer\ImageResizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResizeToHeightCommand extends Command
{

    protected function configure()
    {
        $this->setName("resize:height")
            ->addArgument("source", InputArgument::REQUIRED, "The source directory")
            ->addArgument("target", InputArgument::REQUIRED, "The target directory")
            ->addArgument("height", InputArgument::REQUIRED, "The max height")
            ->addArgument("quality", InputArgument::OPTIONAL, "Image quality (0-100)");
    }

    protected function execute(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $ir = new ImageResizer($inputInterface->getArgument("source"), $inputInterface->getArgument("target"));
        $ir->resizeToMaxHeight($inputInterface->getArgument("height"), $inputInterface->getArgument("quality"));
    }

} 
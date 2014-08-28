<?php

namespace ImageResizer\Console\Command;

use ImageResizer\ImageResizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResizeToWidthCommand extends Command
{

    protected function configure()
    {
        $this->setName("resize:width")
            ->addArgument("source", InputArgument::REQUIRED, "The source directory")
            ->addArgument("target", InputArgument::REQUIRED, "The target directory")
            ->addArgument("width", InputArgument::REQUIRED, "The max width")
            ->addArgument("quality", InputArgument::OPTIONAL, "Image quality (0-100)");
    }

    protected function execute(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $ir = new ImageResizer($inputInterface->getArgument("source"), $inputInterface->getArgument("target"));
        $ir->resizeToMaxWidth($inputInterface->getArgument("width"), $inputInterface->getArgument("quality"));
    }

} 
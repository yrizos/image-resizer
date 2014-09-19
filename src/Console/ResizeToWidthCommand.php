<?php

namespace ImageResizer\Console;

use ImageResizer\ImageResizer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResizeToWidthCommand extends BaseCommand
{

    protected function configure()
    {
        parent::configure();

        $this->setName("resize:width");
        $this->addArgument("width", InputArgument::REQUIRED, "The max width");
    }

    protected function execute(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $ir = $this->getImageResizer($inputInterface);

        $ir->resizeToMaxWidth(
            $inputInterface->getArgument("width")
        );
    }

} 
<?php

namespace ImageResizer\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResizeToHeightCommand extends BaseCommand
{

    protected function configure()
    {
        parent::configure();

        $this->setName("resize:height");
        $this->addArgument("height", InputArgument::REQUIRED, "The max height");
    }

    protected function execute(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $ir = $this->getImageResizer($inputInterface);

        $ir->resizeToMaxHeight(
            $inputInterface->getArgument("height")
        );
    }

} 
<?php

namespace ImageResizer\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResizeToDimensionCommand extends BaseCommand
{

    protected function configure()
    {
        parent::configure();

        $this->setName("resize:dimension");
        $this->addArgument("dimension", InputArgument::REQUIRED, "The max dimension");
    }

    protected function execute(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $ir = $this->getImageResizer($inputInterface);

        $ir->resizeToMaxDimension(
            $inputInterface->getArgument("dimension")
        );
    }


}
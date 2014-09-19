<?php

namespace ImageResizer\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PadCommand extends BaseCommand
{

    protected function configure()
    {
        parent::configure();

        $this->setName("pad");
        $this->addArgument("width", InputArgument::REQUIRED);
        $this->addArgument("height", InputArgument::REQUIRED);
        $this->addArgument("background color", InputArgument::OPTIONAL, "The background color in hex");
    }

    protected function execute(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $ir = $this->getImageResizer($inputInterface);

        $ir->pad(
            $inputInterface->getArgument("width"),
            $inputInterface->getArgument("height")
        );
    }

} 
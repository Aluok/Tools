<?php

// src/Acme/DemoBundle/Command/ReadFileCommand.php

namespace Acme\DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class ReadFileCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('reader:read-file')
            ->addArgument(
                'task',
                InputArgument::OPTIONAL,
                'A long task'
            )
;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('split_file')->process($input);
    }
}

<?php

namespace Timpack\Travian\Command\Resource;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Model\Resources;

class ListCommand extends Command
{
    protected function configure()
    {
        $this->setName('resource:list')
            ->setDescription('Get a list of all resources');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $resources = new Resources();
        $resources->getResourceField();
    }

}
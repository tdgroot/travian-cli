<?php

namespace Timpack\Travian\Command\Resource;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Resource\Field;
use Timpack\Travian\Model\Resource;

class UpgradeCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('resource:upgrade')
            ->setDescription('Start a resource upgrade')
            ->addArgument('id', InputArgument::REQUIRED, 'id');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        $resources = new Resource();

        $field = findField($resources->getResourceList(),$id);

        $success = $field->startUpgrade();

        if($success){
            $output->writeln('<info>Upgrade started</info>');
        } else {
            $output->writeln('Failed to start upgrade');
        }
    }
}

function findField ($fields, $id) : Field
{
    foreach($fields as $field){
        if ($field->constructionId == $id){
            return $field;
        }
    }

    return NULL;
}
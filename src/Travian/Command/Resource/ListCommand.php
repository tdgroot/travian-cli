<?php

namespace Timpack\Travian\Command\Resource;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Resource;

class ListCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('resource:list')
            ->setDescription('Get a list of all resources')
            ->addOption('show-upgrades', NULL, InputOption::VALUE_NONE, 'Show the costs of upgrading the structure as well');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $renderer = $this->getRenderer($input);
        $resources = new Resource();
        $rows = [];

        if ($input->getOption('show-upgrades')){
            foreach ($resources->getResourceList() as $resourceField) {
                
                $rows[] = [
                    'id' => $resourceField->constructionId,
                    'type' => $resourceField->type,
                    'level' => $resourceField->level,
                    'clay' => $resourceField->upgradeInfo->clay,
                    'lumber' => $resourceField->upgradeInfo->lumber,
                    'iron' => $resourceField->upgradeInfo->iron,
                    'crop' => $resourceField->upgradeInfo->crop
                ];
            }
        } else {
            foreach ($resources->getResourceList() as $resourceField) {
                
                $rows[] = [
                    'id' => $resourceField->constructionId,
                    'type' => $resourceField->type,
                    'level' => $resourceField->level
                ];
            }
        }
        
        $renderer->render($output, $rows);
    }

}
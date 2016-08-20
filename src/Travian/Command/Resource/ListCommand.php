<?php

namespace Timpack\Travian\Command\Resource;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Resource\Field;
use Timpack\Travian\Model\Resource;

class ListCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('resource:list')
            ->setDescription('Get a list of all resources');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $renderer = $this->getRenderer($input, $output);
        $resources = new Resource();
        $rows = [];

        /** @var Field $resourceField */
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

        $renderer->render($output, $rows);
    }

}
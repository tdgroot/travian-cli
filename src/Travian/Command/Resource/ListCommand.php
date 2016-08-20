<?php

namespace Timpack\Travian\Command\Resource;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\ResourceField;
use Timpack\Travian\Model\Resources;

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
        $resources = new Resources();
        $rows = [];

        /** @var ResourceField $resourceField */
        foreach ($resources->getResourceList() as $resourceField) {
            $rows[] = [
                'id' => $resourceField->buildId,
                'type' => $resourceField->type,
                'level' => $resourceField->level
            ];
        }
        $renderer->render($output, $rows);

    }

}
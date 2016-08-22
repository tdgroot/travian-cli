<?php

namespace Timpack\Travian\Command\Resource;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Resource;
use Timpack\Travian\Model\Resource\Field;

class ListCommand extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('resource:list')
            ->setDescription('Get a list of all resources')
            ->addOption('show-upgrades', 'u', InputOption::VALUE_NONE, 'Include upgrade info to the result')
            ->addOption('human-readable', 'r', InputOption::VALUE_NONE, 'Format data to be human readable');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $resources = new Resource();
        $rows = [];

        $showUpgrades = $input->getOption('show-upgrades');
        $humanReadable = $input->getOption('human-readable');

        /** @var Field $resourceField */
        foreach ($resources->getResourceList($showUpgrades) as $resourceField) {
            $row = [
                'id' => $resourceField->constructionId,
                'type' => $resourceField->type,
                'level' => $resourceField->level
            ];

            if ($showUpgrades) {
                $row = array_merge($row, [
                    'units_hour' => (int) $resourceField->unitsPerHour,
                    'available' => ($resourceField->upgradeInfo->upgradeTime == 0 ? 1 : 0),
                    'duration' => ($humanReadable ? $resourceField->upgradeInfo->duration->humanize() : $resourceField->upgradeInfo->duration->toSeconds()),
                    'cost_clay' => $resourceField->upgradeInfo->clay,
                    'cost_lumber' => $resourceField->upgradeInfo->lumber,
                    'cost_iron' => $resourceField->upgradeInfo->iron,
                    'cost_crop' => $resourceField->upgradeInfo->crop
                ]);
            }

            $rows[] = $row;
        }

        $this->getRenderer($input)->render($output, $rows);
    }

}
<?php

namespace Timpack\Travian\Command\Village\Building;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Construction;
use Timpack\Travian\Model\Village;

class ListCommand extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('village:building:list')
            ->setDescription('Get a list of all buildings')
            ->addOption('show-upgrades', 'u', InputOption::VALUE_NONE, 'Include upgrade info to the result')
            ->addOption('human-readable', 'r', InputOption::VALUE_NONE, 'Format data to be human readable');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $village = new Village(true);
        $rows = [];

        $showUpgrades = $input->getOption('show-upgrades');
        $humanReadable = $input->getOption('human-readable');

        /** @var Construction $building */
        foreach ($village->getBuildingList($showUpgrades) as $building) {
            $row = [
                'id' => $building->constructionId,
                'name' => $building->name,
                'level' => $building->level
            ];

            if ($showUpgrades) {
                $row = array_merge($row, [
                    'available' => ($building->upgradeInfo->upgradeTime == 0 ? 1 : 0),
                    'duration' => ($humanReadable ? $building->upgradeInfo->duration->humanize() : $building->upgradeInfo->duration->toSeconds()),
                    'cost_lumber' => $building->upgradeInfo->lumber,
                    'cost_clay' => $building->upgradeInfo->clay,
                    'cost_iron' => $building->upgradeInfo->iron,
                    'cost_crop' => $building->upgradeInfo->crop
                ]);
            }

            $rows[] = $row;
        }

        $this->getRenderer($input)->render($output, $rows);
    }

}
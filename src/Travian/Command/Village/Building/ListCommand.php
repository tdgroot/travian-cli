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
            ->addOption('upgrades', 'u', InputOption::VALUE_NONE, 'Additionally add upgrades to the result')
            ->addOption('human-readable', 'r', InputOption::VALUE_NONE, 'Format data to be human readable');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $upgrades = $input->getOption('upgrades');

        $village = new Village(true);
        $rows = [];
        $buildingList = $village->getBuildingList($upgrades);


        /** @var Construction $building */
        foreach ($buildingList as $building)
        {
            $row = [
                'id' => $building->constructionId,
                'name' => $building->name,
                'level' => $building->level
            ];

            if ($upgrades) {
                $row['available'] = ($building->upgradeInfo->upgradeTime == 0 ? 1 : 0);
                if ($input->getOption('human-readable')) {
                    $row['duration'] = $building->upgradeInfo->duration->humanize();
                } else {
                    $row['duration'] = $building->upgradeInfo->duration->toSeconds();
                }
                $row['lumber'] = $building->upgradeInfo->lumber;
                $row['clay'] = $building->upgradeInfo->clay;
                $row['iron'] = $building->upgradeInfo->iron;
                $row['crop'] = $building->upgradeInfo->crop;
            }

            $rows[] = $row;
        }

        $this->getRenderer($input)->render($output, $rows);
    }

}
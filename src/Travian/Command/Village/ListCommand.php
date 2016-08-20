<?php

namespace Timpack\Travian\Command\Village;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Construction;
use Timpack\Travian\Model\Village;

class ListCommand extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('village:list')
            ->setDescription('Render a list of all buildings');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $village = new Village();
        $rows = [];
        $buildingList = $village->getBuildingList();

        /** @var Construction $building */
        foreach ($buildingList as $building)
        {
            $rows[] = [
                'id' => $building->constructionId,
                'name' => $building->name,
                'level' => $building->level
            ];
        }

        $this->getRenderer($input)->render($output, $rows);
    }

}
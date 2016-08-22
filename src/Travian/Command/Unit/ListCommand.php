<?php

namespace Timpack\Travian\Command\Unit;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Unit;

class ListCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('unit:list')
            ->setDescription('Get a list of all units');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $renderer = $this->getRenderer($input);
        $units = new Unit();
        $rows = [];
        
        foreach ($units->getUnitList() as $unit) {
            $rows[] = [
                'name' => $unit->name,
                'amount' => $unit->amount
            ];
        }

        $renderer->render($output, $rows);
    }
}
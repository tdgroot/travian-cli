<?php

namespace Timpack\Travian\Command\Construction;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Command\AbstractCommand;
use Timpack\Travian\Model\Construction;

class UpgradeCommand extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('construction:upgrade')
            ->setDescription('Upgrade or build a construction')
            ->addArgument('construction-id', InputArgument::REQUIRED, 'The id of the construction');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $constructionId = (int)$input->getArgument('construction-id');
        if (!empty($constructionId)) {
            $construction = new Construction();
            $construction->constructionId = $constructionId;
            $construction->load();
            $construction->upgrade();
        } else {
            $output->writeln('Invalid construction id');
        }
    }

}
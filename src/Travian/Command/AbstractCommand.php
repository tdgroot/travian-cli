<?php

namespace Timpack\Travian\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Helper\Table\Renderer\CsvRenderer;
use Timpack\Travian\Helper\Table\Renderer\JsonRenderer;
use Timpack\Travian\Helper\Table\Renderer\RendererInterface;
use Timpack\Travian\Helper\Table\Renderer\TextRenderer;
use Timpack\Travian\Model\Village;

class AbstractCommand extends Command
{

    protected function configure()
    {
        $this->addOption('village-id', null, InputOption::VALUE_REQUIRED, 'Run command on specified village');
        $this->addOption('csv', 'c', InputOption::VALUE_NONE, 'Output csv instead of tables');
        $this->addOption('json', 'j', InputOption::VALUE_NONE, 'Output json instead of tables');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if ($villageId = (int)$input->getOption('village-id')) {
            $village = new Village();
            if ($village->getCurrentVillageId() !== $villageId) {
                $result = $village->switchTo($villageId);
                if ($result) {
                    $output->writeln("Successfully switched to village $village->name");
                } else {
                    $output->writeln("Failed to switch to village $villageId");
                }
            }
        }
    }

    /**
     * @param InputInterface $input
     * @return RendererInterface
     */
    public function getRenderer(InputInterface $input) : RendererInterface
    {
        if ($input->getOption('csv')) {
            $renderer = new CsvRenderer();
        } else {
            if ($input->getOption('json')) {
                $renderer = new JsonRenderer();
            } else {
                $renderer = new TextRenderer();
            }
        }
        return $renderer;
    }

}
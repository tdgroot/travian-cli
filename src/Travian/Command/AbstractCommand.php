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

class AbstractCommand extends Command
{

    protected function configure()
    {
        $this->addOption('csv', 'c', InputOption::VALUE_NONE, 'Output csv instead of tables');
        $this->addOption('json', 'j', InputOption::VALUE_NONE, 'Output json instead of tables');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return RendererInterface
     */
    public function getRenderer(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('csv')) {
            $renderer = new CsvRenderer();
        } else if ($input->getOption('json')) {
            $renderer = new JsonRenderer();
        } else {
            $renderer = new TextRenderer();
        }
        return $renderer;
    }

}
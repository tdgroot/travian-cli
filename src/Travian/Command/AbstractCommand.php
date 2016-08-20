<?php

namespace Timpack\Travian\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Helper\Table\Renderer\CsvRenderer;
use Timpack\Travian\Helper\Table\Renderer\RendererInterface;
use Timpack\Travian\Helper\Table\Renderer\TextRenderer;

class AbstractCommand extends Command
{

    protected function configure()
    {
        $this->addOption('csv', 'c', InputOption::VALUE_NONE, 'Output csv instead of tables');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return RendererInterface
     */
    public function getRenderer(InputInterface $input, OutputInterface $output)
    {
        $renderer = new TextRenderer();
        if ($input->getOption('csv')) {
            $renderer = new CsvRenderer();
        }
        return $renderer;
    }

}